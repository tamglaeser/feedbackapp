<?php

namespace App\Console\Commands;

use App\Services\FileProcessingService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

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
    protected $fileService;

    public function __construct(FileProcessingService $fileService)
    {
        parent::__construct();
        $this->fileService = $fileService;
    }
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $url = 'http://feedier-production.s3.eu-west-1.amazonaws.com/special/Reviews+Import.csv';
        // Fetch CSV file content
        $response = Http::get($url);

        if ($response->successful()) {
            $csvData = $response->body();
            // Process CSV data
            $this->fileService->processCSVContent($csvData);
            $this->info('Feedier CSV file processed successfully');
        } else {
            $this->error('Failed to save the Feedier CSV file');
        }
    }
}
