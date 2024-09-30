<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateQuestionsTableAddAnswersAndCorrect extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('questions', function (Blueprint $table) {
            // Only add 'answers' column if it doesn't exist
            if (!Schema::hasColumn('questions', 'answers')) {
                $table->json('answers')->nullable()->after('type');
            }

            // Only add 'correct' column if it doesn't exist
            if (!Schema::hasColumn('questions', 'correct')) {
                $table->json('correct')->nullable()->after('answers');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('questions', function (Blueprint $table) {
            if (Schema::hasColumn('questions', 'answers')) {
                $table->dropColumn('answers');
            }

            if (Schema::hasColumn('questions', 'correct')) {
                $table->dropColumn('correct');
            }
        });
    }
}
