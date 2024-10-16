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
            $teacherId = Auth::id();

            // Validate incoming data
            $data = $request->validate([
                'title' => 'required|string',
                'time_limit' => 'required|integer',
                'number_of_questions' => 'required|integer',
                'questions' => 'required|array',
                'questions.*.text' => 'required|string',
                'questions.*.answers' => 'required|string',
                'questions.*.correct' => 'required|string',
            ]);

            // Create new quiz
            $quiz = Quiz::create([
                'title' => $data['title'],
                'time_limit' => $data['time_limit'],
                'number_of_questions' => $data['number_of_questions'],
                'teacher_id' => $teacherId
            ]);

            // Save questions
            foreach ($data['questions'] as $questionData) {
                $question = new Question([
                    'text' => $questionData['text'],
                    'answers' => $questionData['answers'],
                    'correct' => $questionData['correct'],
                ]);
                $quiz->questions()->save($question);
            }

            return response()->json(['message' => 'Quiz saved successfully!'], 201);
        } catch (\Exception $e) {
            Log::error('Error saving quiz: ' . $e->getMessage());
            return response()->json(['error' => 'Error saving quiz'], 500);
        }
    }

    public function logGeminiResponse(Request $request)
    {
        // Log the entire request data including the full Gemini API response
        Log::info('Gemini API Response:', [
            'title' => $request->input('title'),
            'subject' => $request->input('subject'),
            'time_limit' => $request->input('time_limit'),
            'number_of_questions' => $request->input('number_of_questions'),
            'questions' => $request->input('questions'),
            'geminiResponse' => $request->input('geminiResponse'),  // Log the full Gemini API response
        ]);

        return response()->json(['message' => 'Logged successfully!'], 200);
    }
}
