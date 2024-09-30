<?php

namespace Database\Seeders;
use App\Models\Quiz;
use Illuminate\Database\Seeder;
use App\Models\Question;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            MathQuizSeeder::class,
            ScienceQuizSeeder::class,
            HistoryQuizSeeder::class,
            

        ]);
    }
    
}
