<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Score;
use Illuminate\Support\Facades\Auth;

class ScoreController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'quiz_id' => 'required|exists:quizzes,id',
            'score' => 'required|integer',
        ]);

        // Check if the score already exists for this user and quiz
        $existingScore = Score::where('user_id', Auth::id())
                              ->where('quiz_id', $request->quiz_id)
                              ->first();

        if ($existingScore) {
            // Update the existing score
            $existingScore->update([
                'score' => $request->score,
            ]);
        } else {
            // Create a new score entry
            Score::create([
                'user_id' => Auth::id(),
                'quiz_id' => $request->quiz_id,
                'score' => $request->score,
            ]);
        }

        return response()->json(['message' => 'Score saved successfully!'], 200);
    }
}

