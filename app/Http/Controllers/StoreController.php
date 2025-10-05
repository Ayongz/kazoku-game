<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StoreController extends Controller
{
    // Store Constants
    const MAX_STEAL_LEVEL = 5;         // Maximum steal level
    const MAX_AUTO_EARNING_LEVEL = 20; // Maximum auto earning level
    const BASE_STEAL_COST = 5000;      // Base cost for steal upgrade
    const BASE_AUTO_EARNING_COST = 10000; // Base cost for auto earning upgrade

    /**
     * Display the store page
     */
    public function index()
    {
        $user = Auth::user();

        // Calculate upgrade costs
        $stealUpgradeCost = self::BASE_STEAL_COST * ($user->steal_level + 1);
        $autoEarningUpgradeCost = self::BASE_AUTO_EARNING_COST * ($user->auto_earning_level + 1);

        return view('game.store', [
            'user' => $user,
            'maxStealLevel' => self::MAX_STEAL_LEVEL,
            'maxAutoEarningLevel' => self::MAX_AUTO_EARNING_LEVEL,
            'stealUpgradeCost' => $stealUpgradeCost,
            'autoEarningUpgradeCost' => $autoEarningUpgradeCost,
        ]);
    }

    /**
     * Handle steal ability purchase
     */
    public function purchaseSteal(Request $request)
    {
        $user = Auth::user();

        // Check if already at max level
        if ($user->steal_level >= self::MAX_STEAL_LEVEL) {
            return redirect()->route('store.index')
                ->with('error', 'You are already at maximum steal level!');
        }

        // Calculate upgrade cost
        $upgradeCost = self::BASE_STEAL_COST * ($user->steal_level + 1);

        // Check if user has enough money
        if ($user->money_earned < $upgradeCost) {
            return redirect()->route('store.index')
                ->with('error', 'Not enough money for steal upgrade! Need IDR ' . number_format($upgradeCost, 0, ',', '.'));
        }

        // Process upgrade
        $user->money_earned -= $upgradeCost;
        $user->steal_level += 1;
        $user->save();

        return redirect()->route('store.index')
            ->with('success', "Successfully upgraded steal level to {$user->steal_level}!");
    }

    /**
     * Handle auto earning ability purchase
     */
    public function purchaseAutoEarning(Request $request)
    {
        $user = Auth::user();

        // Check if already at max level
        if ($user->auto_earning_level >= self::MAX_AUTO_EARNING_LEVEL) {
            return redirect()->route('store.index')
                ->with('error', 'You are already at maximum auto earning level!');
        }

        // Calculate upgrade cost
        $upgradeCost = self::BASE_AUTO_EARNING_COST * ($user->auto_earning_level + 1);

        // Check if user has enough money
        if ($user->money_earned < $upgradeCost) {
            return redirect()->route('store.index')
                ->with('error', 'Not enough money for auto earning upgrade! Need IDR ' . number_format($upgradeCost, 0, ',', '.'));
        }

        // Process upgrade
        $user->money_earned -= $upgradeCost;
        $user->auto_earning_level += 1;
        $user->save();

        return redirect()->route('store.index')
            ->with('success', "Successfully upgraded auto earning level to {$user->auto_earning_level}! You now earn " . 
                   ($user->auto_earning_level * 0.05) . "% of your money every hour!");
    }
}
