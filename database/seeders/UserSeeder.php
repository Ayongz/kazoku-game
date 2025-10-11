<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Yong',
            'email' => 'yong@game.com',
            'password' => Hash::make('123'), // You can use 'password' for easy testing
            'money_earned' => 0, // Starts with a lot of money for testing
            'treasure' => 300,
            'gambling_attempts_today' => 0, // Start with 0 attempts used (20 available)
        ]);

        User::create([
            'name' => 'Wei',
            'email' => 'wei@game.com',
            'password' => Hash::make('123'),
            'money_earned' => 0,
            'treasure' => 300,
            'gambling_attempts_today' => 0,
        ]);

        User::create([
            'name' => 'Lina',
            'email' => 'lina@game.com',
            'password' => Hash::make('123'),
            'money_earned' => 25000, 
            'treasure' => 20,
            'gambling_attempts_today' => 0,
        ]);

        User::create([
            'name' => 'Ma',
            'email' => 'ma@game.com',
            'password' => Hash::make('123'),
            'money_earned' => 15000, 
            'treasure' => 20,
            'gambling_attempts_today' => 0,
        ]);

    }
}
