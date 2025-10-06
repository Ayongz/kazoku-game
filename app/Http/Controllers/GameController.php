<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\GameSetting;
use App\Services\ExperienceService;

class GameController extends Controller
{
    // Game Constants
    const MIN_EARN_AMOUNT = 100;      // Minimum IDR earned per attempt
    const MAX_EARN_AMOUNT = 2000;     // Maximum IDR earned per attempt
    const MAX_STEAL_LEVEL = 5;         // Maximum steal level
    const MAX_TREASURE_MULTIPLIER_LEVEL = 10; // Maximum treasure multiplier level
    const MAX_LUCKY_STRIKES_LEVEL = 5; // Maximum lucky strikes level
    const MAX_COUNTER_ATTACK_LEVEL = 5; // Maximum counter attack level
    const BASE_STEAL_COST = 10000;      // Base cost for first steal upgrade

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

        // Check if user has treasure left
        if ($user->treasure <= 0) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'You have no treasure left! Wait for the hourly reset.',
                    'treasure' => $user->treasure,
                    'money_earned' => $user->money_earned
                ], 2000);
            }
            
            return redirect()->route('game.dashboard')
                ->with('error', 'You have no treasure left! Wait for the hourly reset.');
        }

        // Generate random money amount between min and max
        $earnedAmount = rand(self::MIN_EARN_AMOUNT, self::MAX_EARN_AMOUNT);

        // Apply Lucky Strikes bonus if available
        $luckyStrikesBonus = "";
        if ($user->lucky_strikes_level > 0) {
            $luckyChance = $user->lucky_strikes_level * 2; // 2%, 4%, 6%, 8%, 10%
            if (rand(1, 100) <= $luckyChance) {
                $earnedAmount *= 2; // Double the money
                $luckyStrikesBonus = " (LUCKY STRIKE 2X!)";
            }
        }

        // Calculate prize pool contribution (10% of earned amount)
        $prizePoolContribution = $earnedAmount * 0.10;
        $playerReceives = $earnedAmount - $prizePoolContribution;

        // Update user data (player receives 95% of earned amount)
        $user->money_earned += $playerReceives;
        
        // Add experience for opening treasure
        $expGained = ExperienceService::getExpFromTreasure($user->level);
        $user->experience += $expGained;
        
        // Check for level up
        $levelUpCheck = ExperienceService::checkLevelUp($user->experience, $user->level);
        $levelUpMessage = "";
        if ($levelUpCheck['shouldLevelUp']) {
            $oldLevel = $user->level;
            $user->level = $levelUpCheck['newLevel'];
            $levelUpMessage = " 🎉 LEVEL UP! " . $oldLevel . " → " . $user->level;
            
            // Special message for reaching level 5 (auto-click unlock)
            if ($user->level >= 5 && $oldLevel < 5) {
                $levelUpMessage .= " (Auto-Click Unlocked!)";
            }
        }
        
        // Apply Treasure Efficiency (chance to not consume treasure)
        $treasureConsumed = true;
        if ($user->treasure_multiplier_level > 0) {
            $efficiencyChance = $user->treasure_multiplier_level * 2; // 2%, 4%, 6%, etc.
            if (rand(1, 100) <= $efficiencyChance) {
                $treasureConsumed = false;
                $luckyStrikesBonus .= " (TREASURE SAVED!)";
            }
        }
        
        if ($treasureConsumed) {
            $user->treasure -= 1;
        }
        
        // Check for random box based on treasure rarity level
        $randomBoxMessage = "";
        if ($user->treasure_rarity_level > 0) {
            if ($user->rollForRandomBox()) {
                // User gets a random box!
                $user->randombox = ($user->randombox ?? 0) + 1;
                $randomBoxMessage = " 🎁 BONUS: Received 1 Random Box!";
            }
        }
        
        $user->save();

        // Update global prize pool (add 5% of earned amount)
        $gameSettings = GameSetting::first();
        if ($gameSettings) {
            $gameSettings->global_prize_pool += $prizePoolContribution;
            $gameSettings->save();
        }

        $successMessage = "Great work! You earned IDR " . number_format($playerReceives, 0, ',', '.') . 
                         " (IDR " . number_format($prizePoolContribution, 0, ',', '.') . " contributed to prize pool)" . 
                         " [+" . $expGained . " EXP]" . $luckyStrikesBonus . $levelUpMessage . $randomBoxMessage;

        // Auto-attempt steal if user has steal ability
        $stealMessage = "";
        if ($user->steal_level > 0) {
            $stealResult = $this->attemptAutoSteal($user);
            if ($stealResult['success']) {
                $stealMessage = " + " . $stealResult['message'];
            }
        }

        // Handle AJAX requests
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $successMessage . $stealMessage,
                'earned_amount' => $playerReceives,
                'prize_pool_contribution' => $prizePoolContribution,
                'total_earned_amount' => $earnedAmount,
                'treasure_remaining' => $user->treasure,
                'total_money' => $user->money_earned,
                'formatted_money' => number_format($user->money_earned, 0, ',', '.'),
                'global_prize_pool' => $gameSettings ? $gameSettings->global_prize_pool : 0,
                'formatted_global_prize_pool' => $gameSettings ? number_format($gameSettings->global_prize_pool, 0, ',', '.') : '0',
                'experience_gained' => $expGained,
                'total_experience' => $user->experience,
                'current_level' => $user->level,
                'level_up' => $levelUpCheck['shouldLevelUp'],
                'exp_to_next_level' => ExperienceService::getExpToNextLevel($user->experience, $user->level),
                'exp_progress_percentage' => ExperienceService::getExpProgressPercentage($user->experience, $user->level),
                'random_box_gained' => !empty($randomBoxMessage),
                'random_box_chance' => $user->getRandomBoxChance(),
                'total_random_boxes' => $user->randombox ?? 0
            ]);
        }

        // Handle regular form submission
        return redirect()->route('game.dashboard')
            ->with('success', $successMessage . $stealMessage);
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

        // Find potential targets (other users with money, excluding current user)
        $potentialTargets = User::where('id', '!=', $user->id)
            ->where('money_earned', '>', 0)
            ->get();

        if ($potentialTargets->isEmpty()) {
            return redirect()->route('game.dashboard')
                ->with('error', 'No targets available to steal from! All other players have 0 money.');
        }

        // Select a random target
        $target = $potentialTargets->random();

        // Check if target has active shield protection
        if ($target->shield_expires_at && $target->shield_expires_at > now()) {
            return redirect()->route('game.dashboard')
                ->with('error', "{$target->name} is protected by a shield! Your steal attempt was blocked. (Found {$potentialTargets->count()} potential targets)");
        }

        // Calculate success chance based on steal level 
        $successChance = $user->steal_level * 5;
        $randomRoll = rand(1, 100);
        $isSuccess = $randomRoll <= $successChance;

        if ($isSuccess) {
            // Calculate steal amount (1-5% of target's money, based on steal level)
            $stealPercentage = min(1 + ($user->steal_level * 0.8), 5); // 1% to 5% max
            $maxStealAmount = ($target->money_earned * $stealPercentage) / 100;
            
            // Random amount within the calculated range
            $stolenAmount = rand(
                max(self::MIN_EARN_AMOUNT, $maxStealAmount * 0.5),
                max(self::MIN_EARN_AMOUNT, $maxStealAmount)
            );

            // Ensure we don't steal more than target has
            $stolenAmount = min($stolenAmount, $target->money_earned);

            // Transfer money from target to attacker
            $target->money_earned -= $stolenAmount;
            $user->money_earned += $stolenAmount;
            
            $target->save();
            $user->save();

            return redirect()->route('game.dashboard')
                ->with('success', "Heist successful! You stole IDR " . number_format($stolenAmount, 0, ',', '.') . " from {$target->name}!");
        } else {
            return redirect()->route('game.dashboard')
                ->with('error', "Heist failed! Target: {$target->name} (IDR " . number_format($target->money_earned, 0, ',', '.') . "). Rolled {$randomRoll}, needed ≤{$successChance}. Found {$potentialTargets->count()} total targets.");
        }
    }

    /**
     * Attempt automatic steal when earning money
     */
    private function attemptAutoSteal($user)
    {
        // Find potential targets (other users with money, excluding current user)
        $potentialTargets = User::where('id', '!=', $user->id)
            ->where('money_earned', '>', 0)
            ->get();

        if ($potentialTargets->isEmpty()) {
            return ['success' => false, 'message' => 'No steal targets available'];
        }

        // Select a random target
        $target = $potentialTargets->random();

        // Check if target has active shield protection
        if ($target->shield_expires_at && $target->shield_expires_at > now()) {
            return ['success' => false, 'message' => 'Target is shielded'];
        }

        // Calculate success chance based on steal level
        $successChance = $user->steal_level * 5; // 5%, 10%, 15%, 20%, 25%
        
        // Apply intimidation effect - target's intimidation reduces attacker's success chance
        if ($target->intimidation_level > 0) {
            $intimidationReduction = $target->intimidation_level * 2; // 2%, 4%, 6%, 8%, 10%
            $successChance = max(0, $successChance - $intimidationReduction);
        }
        
        $randomRoll = rand(1, 100);
        $isSuccess = $randomRoll <= $successChance;

        if ($isSuccess) {
            // Calculate steal amount (1-5% of target's money, based on steal level)
            $stealPercentage = min(1 + ($user->steal_level * 0.8), 5); // 1% to 5% max
            $maxStealAmount = ($target->money_earned * $stealPercentage) / 100;
            
            // Random amount within the calculated range
            $stolenAmount = rand(
                max(self::MIN_EARN_AMOUNT, $maxStealAmount * 0.5),
                max(self::MIN_EARN_AMOUNT, $maxStealAmount)
            );

            // Ensure we don't steal more than target has
            $stolenAmount = min($stolenAmount, $target->money_earned);

            // Apply Lucky Strikes bonus to stolen amount
            $luckyStealBonus = "";
            if ($user->lucky_strikes_level > 0) {
                $luckyChance = $user->lucky_strikes_level * 2; // 2%, 4%, 6%, 8%, 10%
                if (rand(1, 100) <= $luckyChance) {
                    $stolenAmount *= 2; // Double the stolen money
                    $luckyStealBonus = " (LUCKY STEAL 2X!)";
                }
            }

            // Transfer money from target to attacker
            $target->money_earned -= $stolenAmount;
            $user->money_earned += $stolenAmount;
            
            $target->save();
            $user->save();

            // Check for counter-attack from target
            $counterAttackMessage = "";
            if ($target->counter_attack_level > 0) {
                $counterResult = $this->attemptCounterAttack($target, $user);
                if ($counterResult['success']) {
                    $counterAttackMessage = " | " . $counterResult['message'];
                }
            }

            return [
                'success' => true, 
                'message' => "BONUS: Stole IDR " . number_format($stolenAmount, 0, ',', '.') . " from {$target->name}!" . $luckyStealBonus . $counterAttackMessage
            ];
        } else {
            return ['success' => false, 'message' => 'Steal attempt failed'];
        }
    }

    /**
     * Attempt counter-attack when player is stolen from
     */
    private function attemptCounterAttack($defender, $attacker)
    {
        // Calculate counter-attack success chance (20% per level)
        $counterChance = $defender->counter_attack_level * 20; // 20%, 40%, 60%, 80%, 100%
        $randomRoll = rand(1, 100);
        $isCounterSuccess = $randomRoll <= $counterChance;

        if ($isCounterSuccess && $attacker->money_earned > 0) {
            // Calculate counter-steal amount (similar to normal steal but slightly less)
            $counterStealPercentage = min(0.5 + ($defender->counter_attack_level * 0.5), 3); // 0.5% to 3% max
            $maxCounterStealAmount = ($attacker->money_earned * $counterStealPercentage) / 100;
            
            // Random amount within the calculated range
            $counterStolenAmount = rand(
                max(self::MIN_EARN_AMOUNT * 0.5, $maxCounterStealAmount * 0.5),
                max(self::MIN_EARN_AMOUNT * 0.5, $maxCounterStealAmount)
            );

            // Ensure we don't steal more than attacker has
            $counterStolenAmount = min($counterStolenAmount, $attacker->money_earned);

            // Transfer money back from attacker to defender
            $attacker->money_earned -= $counterStolenAmount;
            $defender->money_earned += $counterStolenAmount;
            
            $attacker->save();
            $defender->save();

            return [
                'success' => true,
                'message' => "COUNTER-ATTACK! {$defender->name} stole back IDR " . number_format($counterStolenAmount, 0, ',', '.') . "!"
            ];
        } else {
            return ['success' => false, 'message' => 'Counter-attack failed'];
        }
    }
}
