<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Quiz;


class QuizSeeder extends Seeder
{
    public function run()
    {
        // Seed the Math Quiz with ID 1
        Quiz::create([
            'id' => 1,
            'name' => 'Math Quiz',      // Add the `name` field
            'title' => 'Mathematics',   // Keep `title` if it's necessary
        ]);
        
        // Seed the Science Quiz with ID 2
        Quiz::create([
            'id' => 2,
            'name' => 'Science Quiz',   // Add the `name` field
            'title' => 'Science',
        ]);

        // Seed the History Quiz with ID 3
        Quiz::create([
            'id' => 3,
            'name' => 'History Quiz',   // Add the `name` field
            'title' => 'History',
        ]);
    }
}
