<?php

namespace App\Console\Commands;

use App\Mail\FeedbackExportMail;
use App\Models\Feedback;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class ExportFeedbackJson extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'export:feedback';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Export feedback as JSON and send it to admin users';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $admins = User::where('role', 'admin')->get();

        // Logic to fetch feedback data and convert to JSON
        $feedbackData = Feedback::all();

        $json = $feedbackData->toJson(JSON_PRETTY_PRINT);
        $fileName = 'feedback_' . now()->format('Y-m-d') . '.json';
        $filePath = storage_path('app/' . $fileName);

        file_put_contents($filePath, $json);

        foreach ($admins as $admin) {
            Mail::raw('Email content', function ($message) use ($admin, $filePath) {
                $message->to($admin->email)
                    ->subject('Feedback JSON')
                    ->attach($filePath);
            });
            Mail::to($admin->email)->send(new FeedbackExportMail($filePath));
        }

        // Clean up - optional
        unlink($filePath);
    }
}
