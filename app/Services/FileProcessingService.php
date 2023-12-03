<?php

namespace App\Services;

use App\Models\Feedback;

class FileProcessingService
{
    public function processCSVContent($content) {
        $fillableColumns = ['review', 'rating', 'start_date', 'address', 'appartments', 'source'];
        $csvData = preg_replace_callback('/"(?:[^"\n\r]|\r\n|\r|\n)*"/s', function($match) {  // Delete newlines within double quotes
            return str_replace(["\n", "\r"], '', $match[0]);
        }, $content);
        $rows = array_slice(explode("\n", $csvData), 1);  // Get array of CSV entries, ignore 1st with column names
        foreach ($rows as $row) {
            $entry = str_getcsv($row);  // Array of values of one feedback
            Feedback::create(array_combine($fillableColumns, $entry));  // Need to correspond my values to the key names
        }
    }

    public function processJSONContent($jsonContent) {
        foreach (json_decode($jsonContent) as $entry) {
            Feedback::create((array)$entry);
        }
    }
}
