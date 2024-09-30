<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Question;

class HistoryQuizSeeder extends Seeder
{
    public function run()
    {
        Question::insert([
            [
                'quiz_id' => 3,
                'text' => 'Who was the first President of the United States?',
                'type' => 'single-choice',
                'answers' => json_encode(['George Washington', 'Abraham Lincoln', 'Thomas Jefferson']),
                'correct' => 'George Washington',
            ],
            [
                'quiz_id' => 3,
                'text' => 'In which year did World War I begin?',
                'type' => 'typing',
                'answers' => json_encode([]),
                'correct' => '1914',
            ],
            [
                'quiz_id' => 3,
                'text' => 'Which of the following were involved in the Cold War?',
                'type' => 'multi-choice',
                'answers' => json_encode([
                    ['text' => 'USA', 'correct' => true],
                    ['text' => 'Soviet Union', 'correct' => true],
                    ['text' => 'Germany', 'correct' => false],
                    ['text' => 'China', 'correct' => false]
                ]),
                'correct' => '',
            ],
            [
                'quiz_id' => 3,
                'text' => 'What year did the Berlin Wall fall?',
                'type' => 'typing',
                'answers' => json_encode([]),
                'correct' => '1989',
            ],
            [
                'quiz_id' => 3,
                'text' => 'Who discovered America?',
                'type' => 'single-choice',
                'answers' => json_encode(['Christopher Columbus', 'Leif Erikson', 'Ferdinand Magellan']),
                'correct' => 'Christopher Columbus',
            ],
            [
                'quiz_id' => 3,
                'text' => 'Which event started World War II?',
                'type' => 'single-choice',
                'answers' => json_encode([
                    'The assassination of Archduke Franz Ferdinand',
                    'The invasion of Poland',
                    'The bombing of Pearl Harbor'
                ]),
                'correct' => 'The invasion of Poland',
            ],
            [
                'quiz_id' => 3,
                'text' => 'What was the name of the ship that brought the Pilgrims to America?',
                'type' => 'typing',
                'answers' => json_encode([]),
                'correct' => 'Mayflower',
            ],
            [
                'quiz_id' => 3,
                'text' => 'Who was the British Prime Minister during World War II?',
                'type' => 'single-choice',
                'answers' => json_encode(['Winston Churchill', 'Neville Chamberlain', 'Clement Attlee']),
                'correct' => 'Winston Churchill',
            ],
            [
                'quiz_id' => 3,
                'text' => 'What year did the American Civil War end?',
                'type' => 'typing',
                'answers' => json_encode([]),
                'correct' => '1865',
            ],
            [
                'quiz_id' => 3,
                'text' => 'Which country gifted the Statue of Liberty to the United States?',
                'type' => 'single-choice',
                'answers' => json_encode(['France', 'Germany', 'Canada']),
                'correct' => 'France',
            ]
        ]);
    }
}
