<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTeacherIdToQuizzesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('quizzes', function (Blueprint $table) {
            // Add a foreign key column for teacher_id
            $table->unsignedBigInteger('teacher_id')->nullable();

            // Create a foreign key constraint linking teacher_id to the users table
            $table->foreign('teacher_id')->references('id')->on('users')->onDelete('set null');
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
            // Remove the foreign key constraint first, then drop the teacher_id column
            $table->dropForeign(['teacher_id']);
            $table->dropColumn('teacher_id');
        });
    }
}

