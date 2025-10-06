<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StoreController extends Controller
{
    // Store Constants
    const MAX_STEAL_LEVEL = 5;         // Maximum steal level
    const MAX_AUTO_EARNING_LEVEL = 20; // Maximum auto earning level
    const MAX_TREASURE_MULTIPLIER_LEVEL = 10; // Maximum treasure multiplier level
    const MAX_LUCKY_STRIKES_LEVEL = 5; // Maximum lucky strikes level
    const MAX_COUNTER_ATTACK_LEVEL = 5; // Maximum counter attack level
    const MAX_INTIMIDATION_LEVEL = 5; // Maximum intimidation level
    const MAX_FAST_RECOVERY_LEVEL = 5; // Maximum fast recovery level
    const MAX_TREASURE_RARITY_LEVEL = 7; // Maximum treasure rarity level
    const BASE_STEAL_COST = 15000;      // Base cost for steal upgrade
    const BASE_AUTO_EARNING_COST = 15000; // Base cost for auto earning upgrade
    const BASE_TREASURE_MULTIPLIER_COST = 15000; // Base cost for treasure multiplier upgrade
    const BASE_LUCKY_STRIKES_COST = 15000; // Base cost for lucky strikes upgrade
    const BASE_COUNTER_ATTACK_COST = 40000; // Base cost for counter attack upgrade
    const BASE_INTIMIDATION_COST = 22000; // Base cost for intimidation upgrade
    const BASE_FAST_RECOVERY_COST = 30000; // Base cost for fast recovery upgrade
    const BASE_TREASURE_RARITY_COST = 50000; // Base cost for treasure rarity upgrade
    const SHIELD_COST = 10000;          // Cost for shield protection
    const SHIELD_DURATION_HOURS = 3;   // Shield duration in hours

    /**
     * Display the store page
     */
    public function index()
    {
        $user = Auth::user();

        // Calculate upgrade costs
        $stealUpgradeCost = self::BASE_STEAL_COST * ($user->steal_level + 1);
        $autoEarningUpgradeCost = self::BASE_AUTO_EARNING_COST * ($user->auto_earning_level + 1);
        $treasureMultiplierUpgradeCost = self::BASE_TREASURE_MULTIPLIER_COST * ($user->treasure_multiplier_level + 1);
        $luckyStrikesUpgradeCost = self::BASE_LUCKY_STRIKES_COST * ($user->lucky_strikes_level + 1);
        $counterAttackUpgradeCost = self::BASE_COUNTER_ATTACK_COST * ($user->counter_attack_level + 1);
        $intimidationUpgradeCost = self::BASE_INTIMIDATION_COST * ($user->intimidation_level + 1);
        $fastRecoveryUpgradeCost = self::BASE_FAST_RECOVERY_COST * ($user->fast_recovery_level + 1);
        $treasureRarityUpgradeCost = self::BASE_TREASURE_RARITY_COST * ($user->treasure_rarity_level + 1);
        
        // Check if shield is currently active
        $isShieldActive = $user->shield_expires_at && $user->shield_expires_at > now();

        return view('game.store', [
            'user' => $user,
            'maxStealLevel' => self::MAX_STEAL_LEVEL,
            'maxAutoEarningLevel' => self::MAX_AUTO_EARNING_LEVEL,
            'maxTreasureMultiplierLevel' => self::MAX_TREASURE_MULTIPLIER_LEVEL,
            'maxLuckyStrikesLevel' => self::MAX_LUCKY_STRIKES_LEVEL,
            'maxCounterAttackLevel' => self::MAX_COUNTER_ATTACK_LEVEL,
            'maxIntimidationLevel' => self::MAX_INTIMIDATION_LEVEL,
            'maxFastRecoveryLevel' => self::MAX_FAST_RECOVERY_LEVEL,
            'maxTreasureRarityLevel' => self::MAX_TREASURE_RARITY_LEVEL,
            'stealUpgradeCost' => $stealUpgradeCost,
            'autoEarningUpgradeCost' => $autoEarningUpgradeCost,
            'treasureMultiplierUpgradeCost' => $treasureMultiplierUpgradeCost,
            'luckyStrikesUpgradeCost' => $luckyStrikesUpgradeCost,
            'counterAttackUpgradeCost' => $counterAttackUpgradeCost,
            'intimidationUpgradeCost' => $intimidationUpgradeCost,
            'fastRecoveryUpgradeCost' => $fastRecoveryUpgradeCost,
            'treasureRarityUpgradeCost' => $treasureRarityUpgradeCost,
            'autoEarningUpgradeCost' => $autoEarningUpgradeCost,
            'shieldCost' => self::SHIELD_COST,
            'shieldDurationHours' => self::SHIELD_DURATION_HOURS,
            'isShieldActive' => $isShieldActive,
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

    /**
     * Handle shield purchase
     */
    public function purchaseShield(Request $request)
    {
        $user = Auth::user();

        // Check if shield is already active
        if ($user->shield_expires_at && $user->shield_expires_at > now()) {
            return redirect()->route('store.index')
                ->with('error', 'Shield is already active! Wait for it to expire before purchasing a new one.');
        }

        // Check if user has enough money
        if ($user->money_earned < self::SHIELD_COST) {
            return redirect()->route('store.index')
                ->with('error', 'Not enough money for shield! Need IDR ' . number_format(self::SHIELD_COST, 0, ',', '.'));
        }

        // Process shield purchase
        $user->money_earned -= self::SHIELD_COST;
        $user->shield_expires_at = now()->addHours(self::SHIELD_DURATION_HOURS);
        $user->save();

        return redirect()->route('store.index')
            ->with('success', "Shield activated! You are protected from theft for " . self::SHIELD_DURATION_HOURS . " hours.");
    }

    /**
     * Handle treasure multiplier purchase
     */
    public function purchaseTreasureMultiplier(Request $request)
    {
        $user = Auth::user();

        // Check if already at max level
        if ($user->treasure_multiplier_level >= self::MAX_TREASURE_MULTIPLIER_LEVEL) {
            return redirect()->route('store.index')
                ->with('error', 'You are already at maximum treasure multiplier level!');
        }

        // Calculate upgrade cost
        $upgradeCost = self::BASE_TREASURE_MULTIPLIER_COST * ($user->treasure_multiplier_level + 1);

        // Check if user has enough money
        if ($user->money_earned < $upgradeCost) {
            return redirect()->route('store.index')
                ->with('error', 'Not enough money for treasure multiplier upgrade! Need IDR ' . number_format($upgradeCost, 0, ',', '.'));
        }

        // Process upgrade
        $user->money_earned -= $upgradeCost;
        $user->treasure_multiplier_level += 1;
        $user->save();

        return redirect()->route('store.index')
            ->with('success', "Successfully upgraded treasure multiplier to level {$user->treasure_multiplier_level}!");
    }

    /**
     * Handle lucky strikes purchase
     */
    public function purchaseLuckyStrikes(Request $request)
    {
        $user = Auth::user();

        // Check if already at max level
        if ($user->lucky_strikes_level >= self::MAX_LUCKY_STRIKES_LEVEL) {
            return redirect()->route('store.index')
                ->with('error', 'You are already at maximum lucky strikes level!');
        }

        // Calculate upgrade cost
        $upgradeCost = self::BASE_LUCKY_STRIKES_COST * ($user->lucky_strikes_level + 1);

        // Check if user has enough money
        if ($user->money_earned < $upgradeCost) {
            return redirect()->route('store.index')
                ->with('error', 'Not enough money for lucky strikes upgrade! Need IDR ' . number_format($upgradeCost, 0, ',', '.'));
        }

        // Process upgrade
        $user->money_earned -= $upgradeCost;
        $user->lucky_strikes_level += 1;
        $user->save();

        return redirect()->route('store.index')
            ->with('success', "Successfully upgraded lucky strikes to level {$user->lucky_strikes_level}!");
    }

    /**
     * Handle counter attack purchase
     */
    public function purchaseCounterAttack(Request $request)
    {
        $user = Auth::user();

        // Check if already at max level
        if ($user->counter_attack_level >= self::MAX_COUNTER_ATTACK_LEVEL) {
            return redirect()->route('store.index')
                ->with('error', 'You are already at maximum counter attack level!');
        }

        // Calculate upgrade cost
        $upgradeCost = self::BASE_COUNTER_ATTACK_COST * ($user->counter_attack_level + 1);

        // Check if user has enough money
        if ($user->money_earned < $upgradeCost) {
            return redirect()->route('store.index')
                ->with('error', 'Not enough money for counter attack upgrade! Need IDR ' . number_format($upgradeCost, 0, ',', '.'));
        }

        // Process upgrade
        $user->money_earned -= $upgradeCost;
        $user->counter_attack_level += 1;
        $user->save();

        return redirect()->route('store.index')
            ->with('success', "Successfully upgraded counter attack to level {$user->counter_attack_level}! Now " . 
                   ($user->counter_attack_level * 20) . "% chance to counter-attack when stolen from!");
    }

    /**
     * Handle intimidation purchase
     */
    public function purchaseIntimidation(Request $request)
    {
        $user = Auth::user();

        // Check if already at max level
        if ($user->intimidation_level >= self::MAX_INTIMIDATION_LEVEL) {
            return redirect()->route('store.index')
                ->with('error', 'You are already at maximum intimidation level!');
        }

        // Calculate upgrade cost
        $upgradeCost = self::BASE_INTIMIDATION_COST * ($user->intimidation_level + 1);

        // Check if user has enough money
        if ($user->money_earned < $upgradeCost) {
            return redirect()->route('store.index')
                ->with('error', 'Not enough money for intimidation upgrade! Need IDR ' . number_format($upgradeCost, 0, ',', '.'));
        }

        // Process upgrade
        $user->money_earned -= $upgradeCost;
        $user->intimidation_level += 1;
        $user->save();

        return redirect()->route('store.index')
            ->with('success', "Successfully upgraded intimidation to level {$user->intimidation_level}! Attackers now have " . 
                   ($user->intimidation_level * 2) . "% lower steal success rate against you!");
    }

    /**
     * Handle fast recovery ability purchase
     */
    public function purchaseFastRecovery(Request $request)
    {
        $user = Auth::user();

        // Check if already at max level
        if ($user->fast_recovery_level >= self::MAX_FAST_RECOVERY_LEVEL) {
            return redirect()->route('store.index')
                ->with('error', 'You are already at maximum fast recovery level!');
        }

        // Calculate upgrade cost
        $upgradeCost = self::BASE_FAST_RECOVERY_COST * ($user->fast_recovery_level + 1);

        // Check if user has enough money
        if ($user->money_earned < $upgradeCost) {
            return redirect()->route('store.index')
                ->with('error', 'Not enough money for fast recovery upgrade! Need IDR ' . number_format($upgradeCost, 0, ',', '.'));
        }

        // Get treasure intervals (60, 55, 50, 45, 40, 30 minutes for levels 0-5)
        $intervals = [60, 55, 50, 45, 40, 30];
        $newInterval = $intervals[$user->fast_recovery_level + 1];

        // Process upgrade
        $user->money_earned -= $upgradeCost;
        $user->fast_recovery_level += 1;
        $user->save();

        return redirect()->route('store.index')
            ->with('success', "Successfully upgraded fast recovery to level {$user->fast_recovery_level}! Treasure now regenerates every {$newInterval} minutes!");
    }

    /**
     * Handle treasure rarity upgrade purchase
     */
    public function purchaseTreasureRarity(Request $request)
    {
        $user = Auth::user();

        // Check if already at max level
        if ($user->treasure_rarity_level >= self::MAX_TREASURE_RARITY_LEVEL) {
            return redirect()->route('store.index')
                ->with('error', 'You are already at maximum treasure rarity level!');
        }

        // Calculate upgrade cost
        $upgradeCost = self::BASE_TREASURE_RARITY_COST * ($user->treasure_rarity_level + 1);

        // Check if user has enough money
        if ($user->money_earned < $upgradeCost) {
            return redirect()->route('store.index')
                ->with('error', 'Not enough money for treasure rarity upgrade! Need IDR ' . number_format($upgradeCost, 0, ',', '.'));
        }

        // Get rarity names for display
        $rarityNames = \App\Models\User::getTreasureRarityNames();
        $newRarityName = $rarityNames[$user->treasure_rarity_level + 1] ?? 'Ultimate';

        // Process upgrade
        $user->money_earned -= $upgradeCost;
        $user->treasure_rarity_level += 1;
        $user->save();

        return redirect()->route('store.index')
            ->with('success', "Successfully upgraded treasure rarity to level {$user->treasure_rarity_level}! Your treasure is now {$newRarityName}!");
    }
}
