<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class GeminiController extends Controller
{
    public function saveQuiz(Request $request)
    {
        try {
            // Log the incoming request data for debugging
            Log::info('Incoming quiz data:', $request->all());

            // Validate the incoming request data with correct min rule syntax
            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'subject' => 'required|string',
                'time_limit' => 'nullable|integer',
                'number_of_questions' => 'required|integer|min:1',  // Corrected validation rule
                'questions' => 'required|array',
                'questions.*.text' => 'required|string',
                'questions.*.answers' => 'required|string',
                'questions.*.correct' => 'required|string',
            ]);

            // Create the quiz with the currently logged-in teacher's ID
            $quiz = Quiz::create([
                'title' => $validatedData['title'],
                'time_limit' => $validatedData['time_limit'],
                'number_of_questions' => $validatedData['number_of_questions'],
                'teacher_id' => Auth::id(),  // Get the currently logged-in teacher's ID
            ]);

            // Save each question
            foreach ($validatedData['questions'] as $questionData) {
                $quiz->questions()->create([
                    'text' => $questionData['text'],
                    'answers' => $questionData['answers'],
                    'correct' => $questionData['correct'],
                ]);
            }

            return response()->json(['message' => 'Quiz created successfully!', 'quiz_id' => $quiz->id], 201);
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('Error saving quiz:', ['error' => $e->getMessage()]);

            return response()->json(['message' => 'Failed to save quiz', 'error' => $e->getMessage()], 500);
        }
    }
}
