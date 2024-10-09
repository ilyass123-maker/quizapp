<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;
use App\Models\Score;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Quiz;

	
class QuizController extends Controller
{
    public function getQuestions()
    {
        $questions = Question::all();
    
        // Decode JSON strings in the answers field (if applicable)
        foreach ($questions as $question) {
            if (is_string($question->answers)) {
                $question->answers = json_decode($question->answers, true);
            }
        }
    
        // Return the data as JSON, no further encoding needed
        return response()->json($questions);
    }
    


    public function saveScore(Request $request)
{
    $validatedData = $request->validate([
        'quiz_id' => 'required|exists:quizzes,id',
        'score' => 'required|numeric',
    ]);

    // Assuming you have a `scores` table and a `Score` model
    $score = new Score();
    $score->user_id = Auth::id(); // assuming user is authenticated
    $score->quiz_id = $validatedData['quiz_id'];
    $score->score = $validatedData['score'];
    $score->save();

    return response()->json(['message' => 'Score saved successfully']);
}

public function showCreateQuizForm()
{
    return view('teacher.create-quiz');  // Assuming you have a Blade file for creating quizzes in 'resources/views/teacher/create-quiz.blade.php'
}

// Method to store the quiz with questions




public function storeQuizWithQuestions(Request $request)
{
    try {
        // Log the incoming data for debugging
        \Log::info('Incoming Quiz Data:', $request->all());

        // Validate the request data
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'time_limit' => 'nullable|integer',  // Validate time_limit
            'number_of_questions' => 'required|integer',  // Validate number_of_questions
            'questions' => 'required|array',
            'questions.*.text' => 'required|string',
            'questions.*.type' => 'required|string',
            'questions.*.answers' => 'required|array',
            'questions.*.correct' => 'required|integer',  // Ensure the correct field is set
        ]);

        // Log the validated data for debugging
        \Log::info('Validated Quiz Data:', $validatedData);

        // Create the quiz
        $quiz = Quiz::create([
            'title' => $validatedData['title'],
            'time_limit' => $validatedData['time_limit'],  // Save time_limit
            'number_of_questions' => $validatedData['number_of_questions'],  // Save number_of_questions
            'teacher_id' => Auth::id(),  // Dynamically assign teacher_id
        ]);

        // Log successful quiz creation
        \Log::info('Quiz Created:', ['quiz_id' => $quiz->id]);

        // Save the questions for the quiz
        foreach ($validatedData['questions'] as $questionData) {
            $quiz->questions()->create([
                'text' => $questionData['text'],
                'type' => $questionData['type'],
                'answers' => json_encode($questionData['answers']),  // Convert answers array to JSON
                'correct' => $questionData['correct'],  // Save correct answer
            ]);
        }

        return response()->json(['message' => 'Quiz created successfully!'], 201);

    } catch (\Exception $e) {
        // Log the error for debugging
        \Log::error('Error creating quiz:', ['error' => $e->getMessage()]);

        // Return a JSON error response with the 500 status code
        return response()->json(['message' => 'Error creating quiz', 'error' => $e->getMessage()], 500);
    }
}




// Method to view quizzes (for teachers)
public function viewQuizzes()
{
    $quizzes = Quiz::all();  // Fetch all quizzes (or filter them based on user if needed)
    return view('teacher.view-quizzes', compact('quizzes'));
}

// Method to show details of a specific quiz
// In your QuizController.php
public function index()
{
    // Fetch all quizzes with the number of questions and time limit
    $quizzes = Quiz::withCount('questions')->get(); // Adds `questions_count` to each quiz

    // Pass quizzes with question count and time limit to the view
    return view('quiz', compact('quizzes'));
}




// Method to delete a specific quiz
public function delete($quizId)
{
    $quiz = Quiz::findOrFail($quizId);
    $quiz->delete();

    return redirect()->route('teacher.view-quizzes')->with('success', 'Quiz deleted successfully!');
}

// In your QuizController.php
public function show($id)
{
    // Fetch the quiz by its ID, along with its related questions
    $quiz = Quiz::with('questions')->findOrFail($id);

    // Pass the quiz and quiz ID to the view
    return view('quiz-details', ['quiz' => $quiz, 'quizId' => $quiz->id]);
}


public function getQuiz($id)
{
    $quiz = Quiz::find($id);

    if (!$quiz) {
        return response()->json(['error' => 'Quiz not found'], 404);
    }

    return response()->json($quiz);
}



}
