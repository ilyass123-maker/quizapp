<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('quizzes', function (Blueprint $table) {
            $table->integer('time_limit')->nullable();  // Make sure this is nullable
            $table->integer('number_of_questions')->nullable();
            $table->unsignedBigInteger('teacher_id')->nullable();  // Assuming you have a relationship with teachers
        });
    }

    public function down()
    {
        Schema::table('quizzes', function (Blueprint $table) {
            $table->dropColumn('time_limit');
            $table->dropColumn('number_of_questions');
            $table->dropColumn('teacher_id');
        });
    }
};
