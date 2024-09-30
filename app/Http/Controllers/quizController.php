<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;
use App\Models\Score;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        $user = Auth::user();  // Get the authenticated user
        $quizId = $request->input('quiz_id');
        $answers = $request->input('answers');  // User's answers from the form
        
        $correctAnswersCount = 0;
    
        // Fetch the quiz and its questions
        $quiz = Quiz::with('questions.options')->findOrFail($quizId);
        
        // Calculate the score by checking each answer
        foreach ($quiz->questions as $question) {
            if (isset($answers[$question->id])) {
                $selectedOption = $answers[$question->id];
                
                // Check if the selected option is correct (assuming you have a way to mark correct options)
                foreach ($question->options as $option) {
                    if ($option->id == $selectedOption && $option->is_correct) {
                        $correctAnswersCount++;
                        break;
                    }
                }
            }
        }
        
        // Calculate percentage score
        $totalQuestions = $quiz->questions->count();
        $score = ($correctAnswersCount / $totalQuestions) * 100;
        
        // Save the score to the 'scores' table
        Score::create([
            'user_id' => $user->id,
            'quiz_id' => $quizId,
            'score' => $score,
        ]);
    
        return redirect()->route('quiz.details', ['quiz' => $quizId])->with('success', 'Quiz submitted successfully! Your score is ' . $score . '%');
    }
public function showCreateQuizForm()
{
    return view('teacher.create-quiz');  // Assuming you have a Blade file for creating quizzes in 'resources/views/teacher/create-quiz.blade.php'
}

// Method to store the quiz with questions
public function storeQuizWithQuestions(Request $request)
{
    // Validate the request data
    $request->validate([
        'title' => 'required|string|max:255',
        'questions' => 'required|array',
        // Add other validation rules if needed
    ]);

    // Create the quiz
    $quiz = Quiz::create([
        'title' => $request->input('title'),
        // Add other fields as necessary
    ]);

    // Save the questions for the quiz
    foreach ($request->input('questions') as $questionData) {
        $quiz->questions()->create($questionData);
    }

    // Redirect back with success message
    return redirect()->route('teacher.view-quizzes')->with('success', 'Quiz created successfully!');
}

// Method to view quizzes (for teachers)
public function viewQuizzes()
{
    $quizzes = Quiz::all();  // Fetch all quizzes (or filter them based on user if needed)
    return view('teacher.view-quizzes', compact('quizzes'));
}

// Method to show details of a specific quiz
public function index()
    {
        // Fetch all quizzes from the database
        $quizzes = Quiz::all();
        return view('quiz', compact('quizzes'));
    }

    // Show the quiz details (and questions) when a quiz is selected
    // In QuizController.php

    public function show($id)
{
    return view('quiz-details', ['quizId' => $id]);
}



// Method to delete a specific quiz
public function delete($quizId)
{
    $quiz = Quiz::findOrFail($quizId);
    $quiz->delete();

    return redirect()->route('teacher.view-quizzes')->with('success', 'Quiz deleted successfully!');
}




}
