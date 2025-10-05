<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\GameSetting;

class GameController extends Controller
{
    // Game Constants
    const MIN_EARN_AMOUNT = 1000;      // Minimum IDR earned per attempt
    const MAX_EARN_AMOUNT = 10000;     // Maximum IDR earned per attempt
    const MAX_STEAL_LEVEL = 5;         // Maximum steal level
    const BASE_STEAL_COST = 5000;      // Base cost for first steal upgrade

    /**
     * Display the game dashboard
     */
    public function index()
    {
        $user = Auth::user();
        
        // Get or create game settings with 0 initial prize pool
        $gameSettings = GameSetting::first();
        if (!$gameSettings) {
            $gameSettings = GameSetting::create([
                'global_prize_pool' => 0 // Start with 0 prize pool
            ]);
        }

        return view('game.dashboard', [
            'user' => $user,
            'globalPrizePool' => number_format($gameSettings->global_prize_pool, 0, ',', '.'),
        ]);
    }

    /**
     * Handle earning money attempt
     */
    public function earnMoney(Request $request)
    {
        $user = Auth::user();

        // Check if user has attempts left
        if ($user->attempts <= 0) {
            return redirect()->route('game.dashboard')
                ->with('error', 'You have no attempts left! Wait for the hourly reset.');
        }

        // Generate random money amount between min and max
        $earnedAmount = rand(self::MIN_EARN_AMOUNT, self::MAX_EARN_AMOUNT);

        // Calculate prize pool contribution (5% of earned amount)
        $prizePoolContribution = $earnedAmount * 0.05;
        $playerReceives = $earnedAmount - $prizePoolContribution;

        // Update user data (player receives 95% of earned amount)
        $user->money_earned += $playerReceives;
        $user->attempts -= 1;
        $user->save();

        // Update global prize pool (add 5% of earned amount)
        $gameSettings = GameSetting::first();
        if ($gameSettings) {
            $gameSettings->global_prize_pool += $prizePoolContribution;
            $gameSettings->save();
        }

        return redirect()->route('game.dashboard')
            ->with('success', "Great work! You earned IDR " . number_format($playerReceives, 0, ',', '.') . 
                   " (IDR " . number_format($prizePoolContribution, 0, ',', '.') . " contributed to prize pool)!");
    }

    /**
     * Handle steal ability purchase
     */
    public function purchaseSteal(Request $request)
    {
        $user = Auth::user();

        // Check if already at max level
        if ($user->steal_level >= self::MAX_STEAL_LEVEL) {
            return redirect()->route('game.dashboard')
                ->with('error', 'You are already at maximum steal level!');
        }

        // Calculate upgrade cost
        $upgradeCost = self::BASE_STEAL_COST * ($user->steal_level + 1);

        // Check if user has enough money
        if ($user->money_earned < $upgradeCost) {
            return redirect()->route('game.dashboard')
                ->with('error', 'Not enough money for this upgrade! Need IDR ' . number_format($upgradeCost, 0, ',', '.'));
        }

        // Process upgrade
        $user->money_earned -= $upgradeCost;
        $user->steal_level += 1;
        $user->save();

        return redirect()->route('game.dashboard')
            ->with('success', "Successfully upgraded steal level to {$user->steal_level}!");
    }

    /**
     * Handle steal attempt
     */
    public function executeSteal(Request $request)
    {
        $user = Auth::user();

        // Check if user has steal ability
        if ($user->steal_level <= 0) {
            return redirect()->route('game.dashboard')
                ->with('error', 'You need to purchase steal ability first!');
        }

        // Calculate success chance based on steal level (20% per level)
        $successChance = min($user->steal_level * 20, 80); // Max 80% success rate
        $isSuccess = rand(1, 100) <= $successChance;

        if ($isSuccess) {
            // Successful steal - earn based on steal level
            $stolenAmount = rand(
                self::MIN_EARN_AMOUNT * $user->steal_level,
                self::MAX_EARN_AMOUNT * $user->steal_level
            );

            $user->money_earned += $stolenAmount;
            $user->save();

            // Reduce global prize pool
            $gameSettings = GameSetting::first();
            if ($gameSettings && $gameSettings->global_prize_pool >= $stolenAmount) {
                $gameSettings->global_prize_pool -= $stolenAmount;
                $gameSettings->save();
            }

            return redirect()->route('game.dashboard')
                ->with('success', "Heist successful! You stole IDR " . number_format($stolenAmount, 0, ',', '.') . "!");
        } else {
            return redirect()->route('game.dashboard')
                ->with('error', 'Heist failed! Better luck next time.');
        }
    }
}
