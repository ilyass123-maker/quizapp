<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuizController;

// Authentication routes (provided by Laravel Breeze or Laravel UI)
Auth::routes(['register' => true, 'reset' => false, 'verify' => false]);

// Route for the quiz, user is redirected here after login
Route::get('/quiz', function () {
    return view('quiz');  // Ensure that you have a 'quiz.blade.php' in your resources/views directory
})->middleware('auth')->name('quiz');

// Home route should only redirect to login if not authenticated
Route::get('/', function () {
    return redirect()->route('quiz');  // Redirect to quiz if user is already authenticated
})->middleware('auth');

// Fetching questions


Route::get('/questions', [QuizController::class, 'getQuestions']);
// In web.php or api.php
Route::post('/save-score', [QuizController::class, 'saveScore'])->middleware('auth');





