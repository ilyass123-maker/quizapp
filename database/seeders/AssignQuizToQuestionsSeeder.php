<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Question;
use App\Models\Quiz;

class AssignQuizToQuestionsSeeder extends Seeder
{
    public function run()
    {
        // Get the quiz you just created
        $quiz = Quiz::first();  // Assuming there's only one quiz, adjust as needed

        // Find all the questions and update their quiz_id to the newly created quiz
        Question::whereIn('id', [1, 2, 3])->update(['quiz_id' => $quiz->id]); // Replace with actual question IDs
    }
}
