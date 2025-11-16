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
            'name' => 'GM',
            'email' => 'gm@game.com',
            'password' => Hash::make('123'),
            'money_earned' => 0,
            'treasure' => 20,
            'is_admin' => true
        ]);

        User::create([
            'name' => 'Wei',
            'email' => 'wei@game.com',
            'password' => Hash::make('123'),
            'money_earned' => 0,
            'treasure' => 20
        ]);
    }
}
