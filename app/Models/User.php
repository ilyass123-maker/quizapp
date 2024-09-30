<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Constants for user types
    const TYPE_TEACHER = 'teacher';
    const TYPE_STUDENT = 'student';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'type', // Added 'type' so it's mass assignable
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed', // Using Laravel's hashed cast for security
    ];

    /**
     * Check if the user is a teacher.
     *
     * @return bool
     */
    public function isTeacher()
    {
        return $this->type === self::TYPE_TEACHER;
    }

    /**
     * Check if the user is a student.
     *
     * @return bool
     */
    public function isStudent()
    {
        return $this->type === self::TYPE_STUDENT;
    }

    /**
     * Relation to get the quizzes associated with the teacher.
     * This relation assumes that the quizzes table has a `teacher_id` column that references the `users` table.
     */
    public function quizzes()
    {
        return $this->hasMany(Quiz::class, 'teacher_id');
    }

    /**
     * This function can be added to manage user quizzes or results if needed.
     * If students take quizzes, you can set up another relation between users and quizzes through results, for example.
     */
    // In User.php
public function quizResults()
{
    // Assuming you have a `scores` table to store quiz results or scores for students
    return $this->hasMany(Score::class, 'student_id');  // 'student_id' is the foreign key in the `scores` table
}

}
