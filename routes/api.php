<?php
use App\Models\Quiz;

Route::get('/api/quizzes', function () {
    return response()->json(Quiz::all());  // Ensure JSON response is returned
});
