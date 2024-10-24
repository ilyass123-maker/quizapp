<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = ['quiz_id', 'text', 'type', 'answers', 'correct'];

    protected $casts = [
        'answers' => 'array',  // Cast 'answers' to an array
    ];

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }
}
