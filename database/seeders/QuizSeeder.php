<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Quiz;

class QuizSeeder extends Seeder
{
    public function run()
    {
        // Add a new quiz
        Quiz::create([
            'name' => 'General Knowledge Quiz',
            'title' => 'General Knowledge Title', // Add the title here
        ]);
        
    }
}
