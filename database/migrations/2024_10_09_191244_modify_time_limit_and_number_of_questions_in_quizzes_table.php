<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('quizzes', function (Blueprint $table) {
            $table->integer('time_limit')->nullable()->change();
            $table->integer('number_of_questions')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('quizzes', function (Blueprint $table) {
            $table->integer('time_limit')->nullable(false)->change();
            $table->integer('number_of_questions')->nullable(false)->change();
        });
    }
};
