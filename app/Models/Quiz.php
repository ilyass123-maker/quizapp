<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', // Add the fields that you want to be mass assignable
        'description', // Add more fields as needed
    ];

    /**
     * Define the relationship with the Question model.
     * Assuming a quiz has many questions.
     */
    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    /**
     * Define the relationship with the Score model.
     * Assuming a quiz has many scores.
     */
    public function scores()
    {
        return $this->hasMany(Score::class);
    }
}
