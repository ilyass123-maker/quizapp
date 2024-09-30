<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateQuestionsTable extends Migration
{
    public function up()
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->string('type')->after('text'); // Add question type column
            $table->text('answers')->nullable()->change(); // Ensure answers can be nullable
            $table->text('correct')->nullable()->change(); // Ensure correct can be nullable
        });
    }

    public function down()
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->dropColumn('type');
            $table->string('answers')->change(); // Revert changes if needed
            $table->string('correct')->change(); // Revert changes if needed
        });
    }
}
