<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Seed a teacher
        User::create([
            'name' => 'Teacher Name',
            'email' => 'teacher@example.com',
            'password' => Hash::make('password'), // replace with a secure password
            'type' => 'teacher',
        ]);

        // Seed a student
        User::create([
            'name' => 'Student Name',
            'email' => 'student@example.com',
            'password' => Hash::make('password'), // replace with a secure password
            'type' => 'student',
        ]);
    }
}
