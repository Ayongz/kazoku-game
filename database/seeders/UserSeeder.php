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
            'name' => 'Game Master',
            'email' => 'master@game.com',
            'password' => Hash::make('password'), // You can use 'password' for easy testing
            'money_earned' => 500000, // Starts with a lot of money
            'attempts' => 1,
            'steal_level' => 3, // Starts with max steal ability
        ]);

        User::create([
            'name' => 'Rookie Player',
            'email' => 'rookie@game.com',
            'password' => Hash::make('password'),
            'money_earned' => 5000, // Small amount of starting money
            'attempts' => 0, // Used their attempt for the hour
            'steal_level' => 0,
        ]);



    }
}
