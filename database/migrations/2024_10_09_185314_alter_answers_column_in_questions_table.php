<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterAnswersColumnInQuestionsTable extends Migration
{
    public function up()
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->text('answers')->change();  // Change answers column to TEXT
        });
    }

    public function down()
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->string('answers')->change();  // Revert back if needed
        });
    }
}
