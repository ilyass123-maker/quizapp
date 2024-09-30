<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use App\Models\Quiz;

class UpdateExistingQuizzesWithTeacherId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Find the teacher by email
        $teacher = User::where('email', 'teacher@example.com')->first();

        // If the teacher exists, update the quizzes
        if ($teacher) {
            // Assign the teacher_id to all existing quizzes
            Quiz::whereNull('teacher_id')->update(['teacher_id' => $teacher->id]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Optionally, you can revert the teacher_id field to null for existing quizzes
        Quiz::where('teacher_id', function($query) {
            $query->select('id')->from('users')->where('email', 'teacher@example.com');
        })->update(['teacher_id' => null]);
    }
}
