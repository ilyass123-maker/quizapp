<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Question;

class ScienceQuizSeeder extends Seeder
{
    public function run()
    {
        Question::insert([
            [
                'quiz_id' => 2,
                'text' => 'What is the chemical symbol for water?',
                'type' => 'typing',
                'answers' => json_encode([]),
                'correct' => 'H2O',
            ],
            [
                'quiz_id' => 2,
                'text' => 'Which planet is known as the Red Planet?',
                'type' => 'single-choice',
                'answers' => json_encode(['Earth', 'Mars', 'Venus']),
                'correct' => 'Mars',
            ],
            [
                'quiz_id' => 2,
                'text' => 'Which of the following are elements?',
                'type' => 'multi-choice',
                'answers' => json_encode([
                    ['text' => 'Hydrogen', 'correct' => true],
                    ['text' => 'Salt', 'correct' => false],
                    ['text' => 'Oxygen', 'correct' => true],
                    ['text' => 'Sugar', 'correct' => false]
                ]),
                'correct' => '',
            ],
            [
                'quiz_id' => 2,
                'text' => 'What is the nearest star to Earth?',
                'type' => 'single-choice',
                'answers' => json_encode(['Sun', 'Proxima Centauri', 'Alpha Centauri']),
                'correct' => 'Sun',
            ],
            [
                'quiz_id' => 2,
                'text' => 'What is the powerhouse of the cell?',
                'type' => 'typing',
                'answers' => json_encode([]),
                'correct' => 'Mitochondria',
            ],
            [
                'quiz_id' => 2,
                'text' => 'What gas do plants absorb from the atmosphere?',
                'type' => 'typing',
                'answers' => json_encode([]),
                'correct' => 'Carbon dioxide',
            ],
            [
                'quiz_id' => 2,
                'text' => 'Which of the following are mammals?',
                'type' => 'multi-choice',
                'answers' => json_encode([
                    ['text' => 'Whale', 'correct' => true],
                    ['text' => 'Shark', 'correct' => false],
                    ['text' => 'Elephant', 'correct' => true],
                    ['text' => 'Crocodile', 'correct' => false]
                ]),
                'correct' => '',
            ],
            [
                'quiz_id' => 2,
                'text' => 'What is the chemical formula for table salt?',
                'type' => 'typing',
                'answers' => json_encode([]),
                'correct' => 'NaCl',
            ],
            [
                'quiz_id' => 2,
                'text' => 'What planet is known for having rings?',
                'type' => 'single-choice',
                'answers' => json_encode(['Saturn', 'Jupiter', 'Uranus']),
                'correct' => 'Saturn',
            ],
            [
                'quiz_id' => 2,
                'text' => 'How many bones are in the human body?',
                'type' => 'typing',
                'answers' => json_encode([]),
                'correct' => '206',
            ]
        ]);
    }
}
