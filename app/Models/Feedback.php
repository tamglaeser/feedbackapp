<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $fillable = ['review', 'rating', 'start_date', 'address', 'appartments', 'source'];
    public static function boot()
    {
        parent::boot();

        static::saving(function ($feedback) {
            $validator = validator($feedback->attributes, [
                'review' => 'required|string',
                'rating' => 'required|integer|min:1|max:10',
                'start_date' => 'required|string',
                'address' => 'required|string',
                'appartments' => 'required|string',
                'source' => 'required|string'
            ]);

            // Check for existing entry with the same attributes, don't want duplicate reviews
            $existingEntry = self::where('review', $feedback->review)
                                    ->where('rating', $feedback->rating)
                                    ->where('start_date', $feedback->start_date)
                                    ->where('address', $feedback->address)
                                    ->where('appartments', $feedback->appartments)
                                    ->where('source', $feedback->source)
                                    ->first();

            if ($validator->fails()) {
                throw new \Exception("Validation failed: " . $validator->errors()->first());
            }

            if ($existingEntry) {
                throw new \Exception("Feedback entry already exists in database");
            }
        });
    }
}
