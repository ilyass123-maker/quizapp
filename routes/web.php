<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuizController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Home page route
Route::get('/', function () {
    return view('home'); // Ensure 'home.blade.php' exists in your 'resources/views' directory.
})->name('home');

// Login routes
Route::get('/login', function () {
    return view('login'); // Make sure 'login.blade.php' is in 'resources/views'
})->name('login');

Route::post('/login', [LoginController::class, 'login'])->name('login.post');

// Register routes
Route::get('/register', function () {
    return view('register'); // Make sure 'register.blade.php' is in 'resources/views'
})->name('register');

Route::post('/register', [RegisterController::class, 'register'])->name('register.post');

// Logout route
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Quiz dashboard route: Shows all quizzes in a table
Route::get('/quiz', [QuizController::class, 'index'])->name('quiz')->middleware('auth');

// Route for specific quiz details: This should show the quiz and its questions
Route::get('/quiz/{id}', function ($id) {
    return view('quiz-details', ['id' => $id]); // Render 'quiz-details.blade.php' and pass the quiz ID to it
})->name('quiz.details')->middleware('auth');

// Route to handle quiz submissions
Route::post('/quiz/{id}/submit', [QuizController::class, 'submitQuiz'])->name('quiz.submit')->middleware('auth');

// Teacher's dashboard
Route::get('/teacher/dashboard', function () {
    if (Gate::denies('access-teacher-section')) {
        abort(403, 'Unauthorized');  // Only teachers can access this route
    }
    return view('teacher.welcome-teacher'); // Ensure this points to the correct Blade file under 'resources/views/teacher/'
})->name('teacher.dashboard')->middleware('auth');

// Teacher-specific routes for managing quizzes
Route::middleware(['auth', 'can:access-teacher-section'])->group(function () {
    Route::get('/teacher/create-quiz', [QuizController::class, 'showCreateQuizForm'])->name('teacher.create-quiz');
    Route::post('/teacher/create-quiz', [QuizController::class, 'storeQuizWithQuestions'])->name('teacher.store-quiz');
    Route::get('/teacher/quizzes', [QuizController::class, 'viewQuizzes'])->name('teacher.view-quizzes');
    Route::get('/teacher/quizzes/{quiz}', [QuizController::class, 'show'])->name('teacher.show-quiz');
    Route::delete('/teacher/quizzes/{quiz}', [QuizController::class, 'delete'])->name('teacher.delete-quiz');
});

// Student-specific routes for accessing quizzes
Route::middleware(['auth', 'can:access-student-section'])->group(function () {
    Route::get('/quiz', [QuizController::class, 'index'])->name('quiz');
    Route::get('/quiz/{id}', [QuizController::class, 'show'])->name('quiz.details');
    Route::post('/quiz/{id}/submit', [QuizController::class, 'submitQuiz'])->name('quiz.submit');
});

// Route for fetching all quizzes in JSON format for use in the frontend
Route::get('/quizzes', function () {
    return response()->json(App\Models\Quiz::all());
})->middleware('auth');

// Route for fetching specific quiz questions in JSON format
Route::get('/quizzes/{quizId}/questions', function ($quizId) {
    $questions = App\Models\Quiz::findOrFail($quizId)->questions;
    return response()->json($questions);
})->middleware('auth');

// Route for saving quiz scores
Route::post('/save-score', [QuizController::class, 'saveScore'])->name('save-score');



// Password reset routes
Route::get('/password/reset', function () {
    return view('auth.passwords.email'); // Assuming you have the password reset views
})->name('password.request');

// Catch-all route for undefined routes (Optional)
Route::fallback(function () {
    return redirect()->route('home');
});
// Teacher's welcome page route
Route::get('/teacher/welcome', function () {
    return view('teacher.welcome-teacher'); // Ensure this points to the correct Blade file in 'resources/views/teacher/'
})->name('welcome-teacher')->middleware('auth');
