<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Score; // Make sure to include this
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Include this to get the authenticated user ID

class QuizController extends Controller
{
    public function getQuestions()
    {
        $questions = Question::all(); // Fetch all questions, adjust as necessary
        return response()->json($questions);
    }

    // Save the quiz score
    public function saveScore(Request $request)
{
    if (!auth()->check()) {
        return response()->json(['error' => 'Unauthenticated'], 401);
    }

    $validated = $request->validate([
        'quiz_id' => 'required|exists:quizzes,id', // Ensure quiz_id exists in the quizzes table
        'score' => 'required|integer',
    ]);

    try {
        $score = new Score();
        $score->user_id = auth()->id(); // Authenticated user ID
        $score->quiz_id = $validated['quiz_id']; // Validated quiz ID
        $score->score = $validated['score']; // Validated score
        $score->save();

        return response()->json(['message' => 'Score saved successfully!'], 200);
    } catch (\Exception $e) {
        \Log::error('Failed to save score: ' . $e->getMessage());
        return response()->json(['error' => 'Failed to save score.'], 500);
    }
}





    

    
}
