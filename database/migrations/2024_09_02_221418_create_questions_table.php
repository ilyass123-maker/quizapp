<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionsTable extends Migration
{
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->text('text'); // The question text
            $table->enum('type', ['single-choice', 'multi-choice', 'typing']); // The type of question
            $table->json('answers')->nullable(); // The possible answers (stored as JSON)
            $table->string('correct')->nullable(); // The correct answer(s)
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('questions');
    }
}
