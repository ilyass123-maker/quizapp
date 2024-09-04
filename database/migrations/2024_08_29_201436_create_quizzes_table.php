<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuizzesTable extends Migration
{
    public function up()
    {
        Schema::create('quizzes', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Ensure that this is not duplicated
            $table->string('title')->nullable(); // Example additional column
            $table->timestamps();
        });
    }
    

    public function down()
    {
        Schema::dropIfExists('quizzes');
    }
}
