<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Question;

class MathQuizSeeder extends Seeder
{
    public function run()
    {
        Question::insert([
            [
                'quiz_id' => 1,
                'text' => 'What is 5 + 3?',
                'type' => 'single-choice',
                'answers' => json_encode(['6', '7', '8']),
                'correct' => '8',
            ],
            [
                'quiz_id' => 1,
                'text' => 'What is the value of π (Pi)?',
                'type' => 'typing',
                'answers' => json_encode([]),
                'correct' => '3.14',
            ],
            [
                'quiz_id' => 1,
                'text' => 'Which of the following are prime numbers?',
                'type' => 'multi-choice',
                'answers' => json_encode([
                    ['text' => '2', 'correct' => true],
                    ['text' => '4', 'correct' => false],
                    ['text' => '5', 'correct' => true],
                    ['text' => '6', 'correct' => false]
                ]),
                'correct' => '',
            ],
            [
                'quiz_id' => 1,
                'text' => 'Solve: 12 ÷ 4',
                'type' => 'single-choice',
                'answers' => json_encode(['2', '3', '4']),
                'correct' => '3',
            ],
            [
                'quiz_id' => 1,
                'text' => 'What is the square root of 49?',
                'type' => 'single-choice',
                'answers' => json_encode(['6', '7', '8']),
                'correct' => '7',
            ],
            [
                'quiz_id' => 1,
                'text' => 'If x = 3, what is the value of 2x + 5?',
                'type' => 'typing',
                'answers' => json_encode([]),
                'correct' => '11',
            ],
            [
                'quiz_id' => 1,
                'text' => 'Which of the following are even numbers?',
                'type' => 'multi-choice',
                'answers' => json_encode([
                    ['text' => '3', 'correct' => false],
                    ['text' => '8', 'correct' => true],
                    ['text' => '11', 'correct' => false],
                    ['text' => '12', 'correct' => true]
                ]),
                'correct' => '',
            ],
            [
                'quiz_id' => 1,
                'text' => 'What is 9 x 9?',
                'type' => 'single-choice',
                'answers' => json_encode(['72', '81', '90']),
                'correct' => '81',
            ],
            [
                'quiz_id' => 1,
                'text' => 'What is the result of 15 - 7?',
                'type' => 'single-choice',
                'answers' => json_encode(['6', '7', '8']),
                'correct' => '8',
            ],
            [
                'quiz_id' => 1,
                'text' => 'What is the sum of angles in a triangle?',
                'type' => 'typing',
                'answers' => json_encode([]),
                'correct' => '180',
            ]
        ]);
    }
}
