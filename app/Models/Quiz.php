<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'teacher_id'];

    // In App\Models\Quiz.php

public function questions()
{
    return $this->hasMany(Question::class);  // Assuming a Quiz has many Questions
}

}
