<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quiz;
use App\Models\Question;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class TeacherQuizController extends Controller
{
    // Show form for creating a new quiz
    public function showCreateQuizForm()
    {
        return view('teacher.create-quiz');
    }

    // Handle quiz creation with questions
    

    public function storeQuizWithQuestions(Request $request)
    {
        // Validation rules
        $request->validate([
            'title' => 'required|string',
            'questions' => 'required|array|min:1', // Allow submitting at least 1 question for testing
            'questions.*.text' => 'required|string', // Ensure question text is provided
            'questions.*.type' => 'required|in:single-choice,multi-choice,typing',
            'questions.*.answers' => 'nullable|array',
            'questions.*.correct' => 'nullable',
        ]);
    
        try {
            // Create a new quiz
            $quiz = Quiz::create([
                'title' => $request->input('title'),
                'teacher_id' => Auth::id(),
            ]);
    
            // Insert associated questions for the quiz
            foreach ($request->input('questions') as $questionData) {
                // Ensure question text is not null or empty
                if (!empty($questionData['text'])) {
                    // Inserting each question
                    Question::create([
                        'quiz_id' => $quiz->id,
                        'text' => $questionData['text'], // Ensure text is being inserted
                        'type' => $questionData['type'],
                        'answers' => $questionData['type'] !== 'typing' ? json_encode($questionData['answers']) : null,
                        'correct' => $questionData['type'] !== 'typing' ? json_encode($questionData['correct']) : $questionData['correct'],
                    ]);
                } else {
                    \Log::error('Empty question text found for quiz id: ' . $quiz->id);
                }
            }
    
            // Return success response
            return response()->json(['success' => true]);
    
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Quiz creation failed: '.$e->getMessage());
    
            return response()->json([
                'success' => false,
                'error' => 'Quiz creation failed: ' . $e->getMessage()
            ], 500);
        }
    }
    
    
    
    // View all quizzes created by the teacher
    public function viewQuizzes()
    {
        $quizzes = Quiz::where('teacher_id', Auth::id())->get(); // Fetch quizzes created by the authenticated teacher
        return view('teacher.view-quizzes', compact('quizzes'));  // Pass quizzes to the view
    }

    // Show specific quiz details
    public function show($quizId)
    {
        $quiz = Quiz::with('questions')->findOrFail($quizId);  // Fetch the quiz with associated questions

        // Ensure the authenticated user is the quiz creator (teacher)
        if ($quiz->teacher_id != Auth::id()) {
            return redirect()->route('teacher.view-quizzes')->with('error', 'Unauthorized action.');
        }

        return view('teacher.show-quiz', compact('quiz'));
    }

    // Delete a specific quiz and its associated questions
    public function delete($quizId)
    {
        $quiz = Quiz::findOrFail($quizId);

        // Ensure the authenticated user is the quiz creator (teacher)
        if ($quiz->teacher_id != Auth::id()) {
            return redirect()->route('teacher.view-quizzes')->with('error', 'Unauthorized action.');
        }

        // Delete the quiz and its associated questions
        $quiz->questions()->delete();
        $quiz->delete();

        return redirect()->route('teacher.view-quizzes')->with('success', 'Quiz deleted successfully!');
    }
}
