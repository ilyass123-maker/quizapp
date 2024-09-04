<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'text', 'type', 'answers', 'correct'
    ];

    /**
     * If your `answers` and `correct` columns are stored as JSON,
     * you can add them to the casts array for automatic decoding/encoding.
     */
    protected $casts = [
        'answers' => 'array',
        'correct' => 'array',
    ];
}
