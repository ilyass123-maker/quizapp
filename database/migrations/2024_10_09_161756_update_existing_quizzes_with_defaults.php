<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Update all existing quizzes with default values of 7 minutes and 10 questions
        DB::table('quizzes')
            ->whereNull('time_limit')
            ->orWhereNull('number_of_questions')
            ->update([
                'time_limit' => 7,  // Set default time limit of 7 minutes
                'number_of_questions' => 10,  // Set default number of questions to 10
            ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Optionally, revert changes by setting the fields to null
        DB::table('quizzes')
            ->where('time_limit', 7)
            ->where('number_of_questions', 10)
            ->update([
                'time_limit' => null,
                'number_of_questions' => null,
            ]);
    }
};
