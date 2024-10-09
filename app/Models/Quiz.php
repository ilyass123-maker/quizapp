<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    // Allow mass assignment of these fields
    protected $fillable = ['title', 'time_limit', 'number_of_questions', 'teacher_id'];

    // Quiz has many questions
    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
