<?php
namespace Database\Seeders;
use Illuminate\database\seeder;
use App\Models\Question;

class QuestionSeeder extends seeder
{
    public function run()
    {
        $questions = [
            [
                'text' => 'What is 5 + 4?',
                'type' => 'single-choice',
                'answers' => json_encode(['7', '8', '9']),
                'correct' => '9',
            ],
            [
                'text' => 'Which of these are fruits?',
                'type' => 'multi-choice',
                'answers' => json_encode([
                    ['text' => 'Apple', 'correct' => true],
                    ['text' => 'Carrot', 'correct' => false],
                    ['text' => 'Banana', 'correct' => true],
                ]),
                'correct' => json_encode(['Apple', 'Banana']),
            ],
            [
                'text' => 'What is the capital of Italy?',
                'type' => 'typing',
                'correct' => 'Rome',
            ],
            [
                'text' => 'What color is the sky on a clear day?',
                'type' => 'single-choice',
                'answers' => json_encode(['Blue', 'Green', 'Yellow']),
                'correct' => 'Blue',
            ],
            [
                'text' => 'Which of these animals can fly?',
                'type' => 'multi-choice',
                'answers' => json_encode([
                    ['text' => 'Dog', 'correct' => false],
                    ['text' => 'Bird', 'correct' => true],
                    ['text' => 'Fish', 'correct' => false],
                ]),
                'correct' => json_encode(['Bird']),
            ],
            [
                'text' => 'What is 7 - 3?',
                'type' => 'single-choice',
                'answers' => json_encode(['3', '4', '5']),
                'correct' => '4',
            ],
            [
                'text' => 'What is the square root of 9?',
                'type' => 'typing',
                'correct' => '3',
            ],
            [
                'text' => 'Which of these are primary colors?',
                'type' => 'multi-choice',
                'answers' => json_encode([
                    ['text' => 'Red', 'correct' => true],
                    ['text' => 'Blue', 'correct' => true],
                    ['text' => 'Purple', 'correct' => false],
                ]),
                'correct' => json_encode(['Red', 'Blue']),
            ],
            [
                'text' => 'What is 2 times 6?',
                'type' => 'single-choice',
                'answers' => json_encode(['10', '12', '14']),
                'correct' => '12',
            ],
            [
                'text' => 'What is the capital of Japan?',
                'type' => 'typing',
                'correct' => 'Tokyo',
            ],
        ];

        foreach ($questions as $question) {
            Question::create($question);
        }
    }
}
