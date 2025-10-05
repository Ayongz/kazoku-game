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
            'money_earned' => 0, // Starts with a lot of money for testing
            'treasure' => 20,
            'steal_level' => 0,
            'auto_earning_level' => 0,
            'treasure_multiplier_level' => 0,
            'lucky_strikes_level' => 0,
        ]);

        User::create([
            'name' => 'Wei',
            'email' => 'wei@game.com',
            'password' => Hash::make('password'),
            'money_earned' => 50000, // Moderate amount of starting money
            'treasure' => 15,
            'steal_level' => 0,
            'auto_earning_level' => 0,
            'treasure_multiplier_level' => 0,
            'lucky_strikes_level' => 0,
        ]);

        User::create([
            'name' => 'TestPlayer',
            'email' => 'test@game.com',
            'password' => Hash::make('password'),
            'money_earned' => 25000, // Some starting money
            'treasure' => 10,
            'steal_level' => 1,
            'auto_earning_level' => 1,
            'treasure_multiplier_level' => 1,
            'lucky_strikes_level' => 1,
        ]);



    }
}
