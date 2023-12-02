<?php

namespace App\Console\Commands;

use App\Models\Feedback;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ProcessCSVFile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'csv:process';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process Feedier CSV file';

    public function __construct()
    {
        parent::__construct();
    }
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $url = 'http://feedier-production.s3.eu-west-1.amazonaws.com/special/Reviews+Import.csv';
        $fillableColumns = ['review', 'rating', 'start_date', 'address', 'appartments', 'source'];
        // Fetch CSV file content
        $response = Http::get($url);

        if ($response->successful()) {
            $csvData = $response->body();
            // Process CSV data
            $csvData = preg_replace_callback('/"(?:[^"\n\r]|\r\n|\r|\n)*"/s', function($match) {  // Delete newlines within double quotes
                return str_replace(["\n", "\r"], '', $match[0]);
            }, $csvData);
            $rows = array_slice(explode("\n", $csvData), 1);  // Get array of CSV entries, ignore 1st with column names
            foreach ($rows as $row) {
                $entry = str_getcsv($row);  // Array of values of one feedback
                Feedback::create(array_combine($fillableColumns, $entry));  // Need to correspond my values to the key names
            }
            $this->info('Feedier CSV file processed successfully');
        } else {
            $this->error('Failed to save the Feedier CSV file');
        }
    }
}
