<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateQuizzesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('quizzes', function (Blueprint $table) {
            // Remove this if it causes an error
            // $table->string('title')->after('id')->nullable(); 

            // Add this line to add the 'teacher_id' column if it doesn't exist
            if (!Schema::hasColumn('quizzes', 'teacher_id')) {
                $table->unsignedBigInteger('teacher_id')->after('updated_at');
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
        Schema::table('quizzes', function (Blueprint $table) {
            $table->dropColumn('teacher_id');  // Drop the teacher_id column when rolling back the migration
        });
    }
}
