<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 
        'subject', 
        'time_limit', 
        'number_of_questions', 
        'teacher_id'  // Reference to the teacher who created the quiz
    ];

    // A quiz has many questions
    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
