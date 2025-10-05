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
            'name' => 'Ayong',
            'email' => 'yong@game.com',
            'password' => Hash::make('123'), // You can use 'password' for easy testing
            'money_earned' => 0, // Starts with a lot of money
            'attempts' => 100,
            'steal_level' => 0, // Starts with max steal ability
        ]);

        User::create([
            'name' => 'Wei',
            'email' => 'wei@game.com',
            'password' => Hash::make('password'),
            'money_earned' => 5000, // Small amount of starting money
            'attempts' => 0, // Used their attempt for the hour
            'steal_level' => 0,
        ]);



    }
}
