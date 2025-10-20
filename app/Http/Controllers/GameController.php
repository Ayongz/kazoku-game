<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Models\User;
use App\Models\GameSetting;
use App\Models\Inventory;
use App\Models\PlayerLog;
use App\Services\ExperienceService;
use DateTime;
use DateTimeZone;

class GameController extends Controller
{
    const FORCE_NIGHT_MODE = false;       // Set to true to force night mode, false to follow actual time
    const FORCE_DAY_MODE = false;        // Set to true to force day mode, false to follow actual time
    
    // Game Constants
    const MIN_EARN_AMOUNT = 500;      // Minimum IDR earned per attempt
    const MAX_EARN_AMOUNT = 5000;     // Maximum IDR earned per attempt
    const MAX_STEAL_LEVEL = 5;         // Maximum steal level
    const MAX_TREASURE_MULTIPLIER_LEVEL = 10; // Maximum treasure multiplier level
    const MAX_LUCKY_STRIKES_LEVEL = 5; // Maximum lucky strikes level
    const MAX_COUNTER_ATTACK_LEVEL = 5; // Maximum counter attack level
    const BASE_STEAL_COST = 10000;      // Base cost for first steal upgrade
    
    // Night-time risk constants (6 PM to 6 AM GMT+7)
    const NIGHT_RISK_LOSS_CHANCE = 25;    // 25% chance to lose money
    const NIGHT_RISK_BONUS_CHANCE = 25;   // 25% chance for 1.5x multiplier
    const NIGHT_RISK_NORMAL_CHANCE = 45;  // 45% chance for normal earnings (reduced to accommodate rare treasure)
    const NIGHT_RARE_TREASURE_CHANCE = 5; // 5% chance to get rare treasure at night
    
    // Class system constants
    const CLASS_UNLOCK_LEVEL = 4;         // Level required for first class selection
    const ADVANCED_CLASS_LEVEL = 8;       // Level required for advanced class
    
    // Basic class constants (Level 4)
    const TREASURE_HUNTER_FREE_TREASURE_CHANCE = 15;  // 15% chance for free treasure
    const PROUD_MERCHANT_BONUS_EARNING = 20;          // 20% additional earnings
    const FORTUNE_GAMBLER_DOUBLE_CHANCE = 15;         // 15% chance to double rewards
    const FORTUNE_GAMBLER_LOSE_CHANCE = 8;            // 8% chance to lose all rewards
    const MOON_GUARDIAN_RANDOM_BOX_CHANCE = 20;       // 20% chance for random box at night
    const DAY_BREAKER_RANDOM_BOX_CHANCE = 20;         // 20% chance for random box at day
    const BOX_COLLECTOR_DOUBLE_BOX_CHANCE = 10;       // 10% chance for 2 random boxes
    const DIVINE_SCHOLAR_BONUS_EXP = 10;              // 10% bonus experience from treasure
    
    // Advanced class constants (Level 8)
    const ADV_TREASURE_HUNTER_FREE_TREASURE_CHANCE = 25;  // 25% chance for free treasure
    const ADV_PROUD_MERCHANT_BONUS_EARNING = 30;          // 30% additional earnings
    const ADV_FORTUNE_GAMBLER_DOUBLE_CHANCE = 25;         // 25% chance to double rewards
    const ADV_FORTUNE_GAMBLER_LOSE_CHANCE = 12;           // 12% chance to lose all rewards
    const ADV_MOON_GUARDIAN_RANDOM_BOX_CHANCE = 30;       // 30% chance for random box at night
    const ADV_DAY_BREAKER_RANDOM_BOX_CHANCE = 30;         // 30% chance for random box at day
    const ADV_BOX_COLLECTOR_DOUBLE_BOX_CHANCE = 15;       // 15% chance for 2 random boxes
    const ADV_DIVINE_SCHOLAR_BONUS_EXP = 20;              // 20% bonus experience from treasure

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
            'globalPrizePool' => $gameSettings->global_prize_pool,
            'isNightTime' => $this->isNightTime(),
        ]);
    }

    /**
     * Handle earning money attempt
     */
    public function earnMoney(Request $request)
    {
        $user = Auth::user();
        
        // Check for treasure opening delay (2 seconds)
        $cacheKey = 'treasure_opened_' . $user->id;
        $lastOpenTime = Cache::get($cacheKey);
        $currentTime = time();
        $delaySeconds = 2;
        
        if ($lastOpenTime !== null) {
            $timeDifference = $currentTime - $lastOpenTime;
            if ($timeDifference < $delaySeconds) {
                $remainingSeconds = $delaySeconds - $timeDifference;
                
                $errorMessage = __('nav.treasure_opening_too_fast', ['seconds' => $remainingSeconds]);
                
                if ($request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => $errorMessage,
                        'treasure' => $user->treasure,
                        'money_earned' => $user->money_earned,
                        'remaining_delay' => $remainingSeconds
                    ], 429); // 429 Too Many Requests
                }
                
                return redirect()->route('game.dashboard')
                    ->with('error', $errorMessage);
            }
        }
        
        // Set the current time as last treasure opening time (expires after 5 seconds for safety)
        Cache::put($cacheKey, $currentTime, 5);

        // Check if user has treasure left
        if ($user->treasure <= 0) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'You have no treasure left! Wait for the hourly reset.',
                    'treasure' => $user->treasure,
                    'money_earned' => $user->money_earned
                ], 400);
            }
            
            return redirect()->route('game.dashboard')
                ->with('error', 'You have no treasure left! Wait for the hourly reset.');
        }

        // Generate random money amount between min and max
        $baseEarnedAmount = rand(self::MIN_EARN_AMOUNT, self::MAX_EARN_AMOUNT);

        // Apply Lucky Strikes bonus if available
        $luckyStrikesBonus = "";
        if ($user->lucky_strikes_level > 0) {
            $luckyChance = $user->lucky_strikes_level * 2; // 2%, 4%, 6%, 8%, 10%
            if (rand(1, 100) <= $luckyChance) {
                $baseEarnedAmount *= 2; // Double the money
                $luckyStrikesBonus = " (LUCKY STRIKE 2X!)";
            }
        }

        // Apply night-time risk system (6 PM to 6 AM GMT+7)
        $nightRiskMessage = "";
        $finalEarnedAmount = $baseEarnedAmount;
        $nightRareTreasureGained = false;
        
        if ($this->isNightTime()) {
            $nightRisk = $this->applyNightTimeRisk($baseEarnedAmount);
            $finalEarnedAmount = $nightRisk['amount'];
            $nightRiskMessage = " " . $nightRisk['message'];
            
            // Check if rare treasure was gained from night bonus
            if (isset($nightRisk['rare_treasure_gained']) && $nightRisk['rare_treasure_gained']) {
                $user->rare_treasures = ($user->rare_treasures ?? 0) + 1;
                $nightRareTreasureGained = true;
            }
        }

        // Apply class abilities that affect earnings
        $classMessages = [];
        
        // Proud Merchant class ability - bonus earnings
        if ($user->selected_class === 'proud_merchant' && $finalEarnedAmount > 0) {
            $bonusPercentage = $user->has_advanced_class ? 
                self::ADV_PROUD_MERCHANT_BONUS_EARNING : 
                self::PROUD_MERCHANT_BONUS_EARNING;
            
            $bonusAmount = floor($finalEarnedAmount * ($bonusPercentage / 100));
            $finalEarnedAmount += $bonusAmount;
            $classMessages[] = "💼 Merchant Bonus: +IDR " . number_format($bonusAmount, 0, ',', '.');
        }
        
        // Fortune Gambler class ability - risk/reward
        if ($user->selected_class === 'fortune_gambler' && $finalEarnedAmount > 0) {
            $gamblerResult = $this->applyFortuneGamblerAbility($user, $finalEarnedAmount);
            $finalEarnedAmount = $gamblerResult['amount'];
            if ($gamblerResult['message']) {
                $classMessages[] = $gamblerResult['message'];
            }
        }

        // Calculate prize pool contribution and player receives amount
        if ($finalEarnedAmount > 0) {
            // Positive earnings - contribute to prize pool
            $prizePoolContribution = $finalEarnedAmount * 0.10;
            $playerReceives = $finalEarnedAmount - $prizePoolContribution;
        } else {
            // Loss scenario - no prize pool contribution, player loses money directly
            $prizePoolContribution = 0;
            $playerReceives = $finalEarnedAmount; // This will be negative
        }

        // Update user money (can be positive or negative)
        $user->money_earned += $playerReceives;
        
        // Ensure money doesn't go below 0
        if ($user->money_earned < 0) {
            $user->money_earned = 0;
        }
        
        // Add experience for opening treasure
        $expGained = ExperienceService::getExpFromTreasure($user->level);
        
        // Apply Divine Scholar bonus experience
        if ($user->selected_class === 'divine_scholar') {
            $bonusPercentage = $user->has_advanced_class ? 
                self::ADV_DIVINE_SCHOLAR_BONUS_EXP : 
                self::DIVINE_SCHOLAR_BONUS_EXP;
            
            $bonusExp = floor($expGained * ($bonusPercentage / 100));
            $expGained += $bonusExp;
            $classMessages[] = "📜 Scholar's Wisdom: +{$bonusExp} bonus EXP!";
        }
        
        $user->experience += $expGained;
        
        // Check for level up
        $levelUpCheck = ExperienceService::checkLevelUp($user->experience, $user->level);
        $levelUpMessage = "";
        if ($levelUpCheck['shouldLevelUp']) {
            $oldLevel = $user->level;
            $user->level = $levelUpCheck['newLevel'];
            $levelUpMessage = " 🎉 LEVEL UP! " . $oldLevel . " → " . $user->level;
            
            // Special message for reaching level 2 (auto-click unlock)
            if ($user->level >= 2 && $oldLevel < 2) {
                $levelUpMessage .= " (Auto-Click Unlocked!)";
            }
        }
        
        // Apply Treasure Efficiency (chance to not consume treasure)
        $treasureConsumed = true;
        
        // Treasure Hunter free attempt ability
        if ($user->selected_class === 'treasure_hunter') {
            $treasureHunterResult = $this->applyTreasureHunterFreeAttempt($user);
            if ($treasureHunterResult['success']) {
                $treasureConsumed = false;
                $classMessages[] = $treasureHunterResult['message'];
            }
        }
        
        // Regular treasure efficiency bonus
        if ($treasureConsumed && $user->treasure_multiplier_level > 0) {
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
        
        // Moon Guardian night-time random box ability
        if ($user->selected_class === 'moon_guardian' && $this->isNightTime()) {
            $moonGuardianResult = $this->applyMoonGuardianAbility($user);
            if ($moonGuardianResult['success']) {
                $classMessages[] = $moonGuardianResult['message'];
            }
        }
        
        // Day Breaker day-time random box ability  
        if ($user->selected_class === 'day_breaker' && !$this->isNightTime()) {
            $dayBreakerResult = $this->applyDayBreakerAbility($user);
            if ($dayBreakerResult['success']) {
                $classMessages[] = $dayBreakerResult['message'];
            }
        }
        
        // Box Collector double random box ability
        if ($user->selected_class === 'box_collector') {
            $boxCollectorResult = $this->applyBoxCollectorAbility($user);
            if ($boxCollectorResult['success']) {
                $classMessages[] = $boxCollectorResult['message'];
            }
        }
        
        $user->save();

        // Update global prize pool (only add contribution if there's a positive contribution)
        $gameSettings = GameSetting::first();
        if ($gameSettings && $prizePoolContribution > 0) {
            $gameSettings->global_prize_pool += $prizePoolContribution;
            $gameSettings->save();
        }

        // Create success message based on earnings result
        $classMessageString = !empty($classMessages) ? " " . implode(" ", $classMessages) : "";
        
        if ($playerReceives >= 0) {
            $successMessage = "Great work! You earned IDR " . number_format($playerReceives, 0, ',', '.') . 
                             ($prizePoolContribution > 0 ? " (IDR " . number_format($prizePoolContribution, 0, ',', '.') . " contributed to prize pool)" : "") . 
                             " [+" . $expGained . " EXP]" . $luckyStrikesBonus . $levelUpMessage . $randomBoxMessage . $nightRiskMessage . $classMessageString;
        } else {
            $successMessage = "You lost IDR " . number_format(abs($playerReceives), 0, ',', '.') . 
                             " [+" . $expGained . " EXP]" . $levelUpMessage . $randomBoxMessage . $nightRiskMessage . $classMessageString;
        }

        // Create log entry for treasure opening
        $additionalData = [
            'base_earned' => $baseEarnedAmount,
            'final_earned' => $finalEarnedAmount,
            'night_mode' => $this->isNightTime(),
            'night_rare_treasure_gained' => $nightRareTreasureGained,
            'class_bonuses' => $classMessages,
            'treasure_consumed' => $treasureConsumed,
            'random_box_gained' => !empty($randomBoxMessage),
            'level_up' => $levelUpCheck['shouldLevelUp']
        ];

        PlayerLog::createLog(
            userId: $user->id,
            actionType: 'treasure_open',
            description: strip_tags($successMessage),
            moneyChange: $playerReceives,
            treasureChange: $treasureConsumed ? -1 : 0,
            rareTreasureChange: $nightRareTreasureGained ? 1 : 0,
            randomBoxChange: !empty($randomBoxMessage) ? 1 : 0,
            experienceGained: $expGained,
            additionalData: $additionalData,
            isSuccess: $playerReceives >= 0
        );

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
                'total_earned_amount' => $finalEarnedAmount,
                'treasure_remaining' => $user->treasure,
                'max_treasure_capacity' => 20 + ($user->treasure_multiplier_level * 5),
                'treasure_multiplier_level' => $user->treasure_multiplier_level,
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
     * Open a rare treasure
     */
    public function openRareTreasure(Request $request)
    {
        $user = Auth::user();
        
        // Check for treasure opening delay (2 seconds) - same mechanism as regular treasure
        $cacheKey = 'treasure_opened_' . $user->id;
        $lastOpenTime = Cache::get($cacheKey);
        $currentTime = time();
        $delaySeconds = 2;
        
        if ($lastOpenTime !== null) {
            $timeDifference = $currentTime - $lastOpenTime;
            if ($timeDifference < $delaySeconds) {
                $remainingSeconds = $delaySeconds - $timeDifference;
                
                $errorMessage = __('nav.treasure_opening_too_fast', ['seconds' => $remainingSeconds]);
                
                if ($request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => $errorMessage,
                        'remaining_delay' => $remainingSeconds
                    ], 429); // 429 Too Many Requests
                }
                
                return redirect()->route('game.dashboard')
                    ->with('error', $errorMessage);
            }
        }
        
        // Set the current time as last treasure opening time (expires after 5 seconds for safety)
        Cache::put($cacheKey, $currentTime, 5);

        // Check if user has rare treasures
        if (($user->rare_treasures ?? 0) <= 0) {
            return redirect()->route('game.dashboard')
                ->with('error', __('nav.no_rare_treasures'));
        }

        // Rare treasures give 5-6x normal treasure rewards
        $baseReward = rand(self::MIN_EARN_AMOUNT, self::MAX_EARN_AMOUNT);
        $rareMultiplier = rand(5, 6); // 5-6x multiplier
        $moneyEarned = $baseReward * $rareMultiplier;

        // Apply class bonuses if applicable
        if ($user->selected_class === 'proud_merchant') {
            $bonus = $user->has_advanced_class ? self::ADV_PROUD_MERCHANT_BONUS_EARNING : self::PROUD_MERCHANT_BONUS_EARNING;
            $moneyEarned = intval($moneyEarned * (1 + $bonus / 100));
        }

        // Consume rare treasure
        $user->rare_treasures -= 1;
        $user->money_earned += $moneyEarned;

        // Give experience (double exp for rare treasures)
        $expGained = rand(5, 15) * 2;
        $user->experience += $expGained;

        // Check for level up
        $levelUpCheck = ExperienceService::checkLevelUp($user->experience, $user->level);
        $levelUpMessage = "";
        if ($levelUpCheck['shouldLevelUp']) {
            $oldLevel = $user->level;
            $user->level = $levelUpCheck['newLevel'];
            $levelUpMessage = " 🎉 LEVEL UP! " . $oldLevel . " → " . $user->level;
        }

        $user->save();

        // Create success message
        $successMessage = "🌟 Rare Treasure Opened! You received IDR " . number_format($moneyEarned) . 
                         " (+" . $expGained . " EXP)" . $levelUpMessage;

        // Create log entry for rare treasure opening
        $additionalData = [
            'base_reward' => $baseReward,
            'rare_multiplier' => $rareMultiplier,
            'money_earned' => $moneyEarned,
            'level_up' => $levelUpCheck['shouldLevelUp'],
            'class_bonus_applied' => $user->selected_class === 'proud_merchant'
        ];

        PlayerLog::createLog(
            userId: $user->id,
            actionType: 'rare_treasure_open',
            description: strip_tags($successMessage),
            moneyChange: $moneyEarned,
            treasureChange: 0,
            rareTreasureChange: -1,
            experienceGained: $expGained,
            additionalData: $additionalData,
            isSuccess: true
        );

        return redirect()->route('game.dashboard')
            ->with('success', $successMessage);
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
    
    /**
     * Check if current time is during night hours (6 PM to 6 AM GMT+7)
     * Can be overridden by FORCE_NIGHT_MODE constant for testing
     */
    private function isNightTime(): bool
    {
        // If FORCE_DAY_MODE is enabled, always return false (day mode)
        if (self::FORCE_DAY_MODE) {
            return false;
        }
        
        // If FORCE_NIGHT_MODE is enabled, always return true (night mode)
        if (self::FORCE_NIGHT_MODE) {
            return true;
        }
        
        // Get current time in GMT+7 timezone
        $gmt7Time = now()->setTimezone('Asia/Bangkok'); // GMT+7
        $currentHour = $gmt7Time->hour;
        
        // Night time is from 18:00 (6 PM) to 06:00 (6 AM)
        return $currentHour >= 18 || $currentHour < 6;
    }
    
    /**
     * Apply night-time risk to earnings
     */
    private function applyNightTimeRisk(int $baseAmount): array
    {
        $roll = rand(1, 100);
        
        // 5% chance - Get rare treasure (highest priority)
        if ($roll <= self::NIGHT_RARE_TREASURE_CHANCE) {
            return [
                'amount' => $baseAmount,
                'type' => 'rare_treasure',
                'message' => '🌟 NIGHT TREASURE: Found a rare treasure in the darkness!',
                'rare_treasure_gained' => true
            ];
        } elseif ($roll <= (self::NIGHT_RARE_TREASURE_CHANCE + self::NIGHT_RISK_LOSS_CHANCE)) {
            // 25% chance - Lose money instead of earning
            $lossAmount = $baseAmount;
            return [
                'amount' => -$lossAmount,
                'type' => 'loss',
                'message' => '🌙 NIGHT RISK: Lost IDR ' . number_format($lossAmount, 0, ',', '.') . ' in the darkness!'
            ];
        } elseif ($roll <= (self::NIGHT_RARE_TREASURE_CHANCE + self::NIGHT_RISK_LOSS_CHANCE + self::NIGHT_RISK_BONUS_CHANCE)) {
            // 25% chance - Get 1.5x multiplier
            $bonusAmount = floor($baseAmount * 1.5);
            return [
                'amount' => $bonusAmount,
                'type' => 'bonus',
                'message' => '🌙 NIGHT BONUS: Earned 1.5x IDR ' . number_format($bonusAmount, 0, ',', '.') . ' under the moonlight!'
            ];
        } else {
            // 45% chance - Normal earnings (reduced from 50% to accommodate rare treasure)
            return [
                'amount' => $baseAmount,
                'type' => 'normal',
                'message' => '🌙 Night treasure opened normally.'
            ];
        }
    }

    /**
     * Apply Fortune Gambler class ability
     */
    private function applyFortuneGamblerAbility($user, $amount): array
    {
        $doubleChance = $user->has_advanced_class ?
            self::ADV_FORTUNE_GAMBLER_DOUBLE_CHANCE :
            self::FORTUNE_GAMBLER_DOUBLE_CHANCE;
            
        $loseChance = $user->has_advanced_class ?
            self::ADV_FORTUNE_GAMBLER_LOSE_CHANCE :
            self::FORTUNE_GAMBLER_LOSE_CHANCE;

        $rand = mt_rand(1, 100);
        
        if ($rand <= $doubleChance) {
            return [
                'amount' => $amount * 2,
                'message' => "🎰 Gambler's Luck: Double earnings!"
            ];
        } elseif ($rand <= ($doubleChance + $loseChance)) {
            return [
                'amount' => 0,
                'message' => "🎰 Gambler's Risk: Lost everything!"
            ];
        }
        
        return [
            'amount' => $amount,
            'message' => ""
        ];
    }

    /**
     * Apply Treasure Hunter free attempt ability
     */
    private function applyTreasureHunterFreeAttempt($user): array
    {
        $freeChance = $user->has_advanced_class ?
            self::ADV_TREASURE_HUNTER_FREE_TREASURE_CHANCE :
            self::TREASURE_HUNTER_FREE_TREASURE_CHANCE;
            
        $rand = mt_rand(1, 100);
        
        if ($rand <= $freeChance) {
            return [
                'success' => true,
                'message' => "🗝️ Treasure Hunter: Free treasure attempt!"
            ];
        }
        
        return [
            'success' => false,
            'message' => ""
        ];
    }

    /**
     * Apply Moon Guardian night-time random box ability
     */
    private function applyMoonGuardianAbility($user): array
    {
        $randomBoxChance = $user->has_advanced_class ?
            self::ADV_MOON_GUARDIAN_RANDOM_BOX_CHANCE :
            self::MOON_GUARDIAN_RANDOM_BOX_CHANCE;
            
        $rand = mt_rand(1, 100);
        
        if ($rand <= $randomBoxChance) {
            // Add a random box to inventory
            $this->addRandomBoxToInventory($user->id);
            return [
                'success' => true,
                'message' => "🌙 Moon Guardian: Night blessing grants a random box!"
            ];
        }
        
        return [
            'success' => false,
            'message' => ""
        ];
    }

    /**
     * Apply Day Breaker day-time random box ability
     */
    private function applyDayBreakerAbility($user): array
    {
        $randomBoxChance = $user->has_advanced_class ?
            self::ADV_DAY_BREAKER_RANDOM_BOX_CHANCE :
            self::DAY_BREAKER_RANDOM_BOX_CHANCE;
            
        $rand = mt_rand(1, 100);
        
        if ($rand <= $randomBoxChance) {
            // Add a random box to inventory
            $this->addRandomBoxToInventory($user->id);
            return [
                'success' => true,
                'message' => "☀️ Day Breaker: Solar power grants a random box!"
            ];
        }
        
        return [
            'success' => false,
            'message' => ""
        ];
    }

    /**
     * Apply Box Collector double random box ability
     */
    private function applyBoxCollectorAbility($user): array
    {
        $doubleBoxChance = $user->has_advanced_class ?
            self::ADV_BOX_COLLECTOR_DOUBLE_BOX_CHANCE :
            self::BOX_COLLECTOR_DOUBLE_BOX_CHANCE;
            
        $rand = mt_rand(1, 100);
        
        if ($rand <= $doubleBoxChance) {
            // Add 2 random boxes to inventory
            $this->addRandomBoxToInventory($user->id);
            $this->addRandomBoxToInventory($user->id);
            return [
                'success' => true,
                'message' => "📦 Box Collector: Found 2 bonus random boxes!"
            ];
        }
        
        return [
            'success' => false,
            'message' => ""
        ];
    }

    /**
     * Add random box to user inventory
     */
    private function addRandomBoxToInventory($userId): void
    {
        $inventory = Inventory::firstOrCreate(
            ['user_id' => $userId, 'item_type' => 'random_box'],
            ['quantity' => 0]
        );
        
        $inventory->increment('quantity');
    }

    /**
     * Show class selection page
     */
    public function showClassSelection()
    {
        $user = Auth::user();
        
        if (!$user->canSelectClass()) {
            return redirect()->route('game.dashboard')
                ->with('error', 'You cannot select a class at this time.');
        }
        
        $availableClasses = $user->getAvailableClasses();
        
        return view('game.class-selection', compact('user', 'availableClasses'));
    }

    /**
     * Handle class selection
     */
    public function selectClass(Request $request)
    {
        $user = Auth::user();
        
        if (!$user->canSelectClass()) {
            return redirect()->route('game.dashboard')
                ->with('error', 'You cannot select a class at this time.');
        }
        
        $request->validate([
            'class' => 'required|string|in:treasure_hunter,proud_merchant,fortune_gambler,moon_guardian,day_breaker,box_collector,divine_scholar'
        ]);
        
        $className = $request->input('class');
        $availableClasses = $user->getAvailableClasses();
        
        if (!in_array($className, array_keys($availableClasses))) {
            return redirect()->back()
                ->with('error', 'Invalid class selection.');
        }
        
        // Assign the class
        $user->selected_class = $className;
        $user->class_selected_at = now();
        $user->save();
        
        $classDisplayName = $user->getClassDisplayName();
        
        return redirect()->route('game.dashboard')
            ->with('success', "You have become a {$classDisplayName}! Your class abilities are now active.");
    }

    /**
     * Handle class advancement
     */
    public function advanceClass(Request $request)
    {
        $user = Auth::user();
        
        if (!$user->canAdvanceClass()) {
            return redirect()->route('game.dashboard')
                ->with('error', 'You cannot advance your class at this time.');
        }
        
        // Advance to the corresponding advanced class
        $user->has_advanced_class = true;
        $user->save();
        
        $classDisplayName = $user->getClassDisplayName();
        
        return redirect()->route('game.dashboard')
            ->with('success', "Your class has been advanced to {$classDisplayName}! Enhanced abilities are now active.");
    }

    /**
     * Show class path tree with all classes and their benefits
     */
    public function showClassPath()
    {
        $user = Auth::user();
        
        // Get all available classes
        $availableClasses = $user->getAvailableClasses();
        
        // Build class data with backend constants
        $classData = [];
        
        foreach ($availableClasses as $classKey => $classInfo) {
            $classData[$classKey] = $classInfo;
            
            // Add dynamic backend constants for each class
            switch ($classKey) {
                case 'treasure_hunter':
                    $classData[$classKey]['basic_percentage'] = self::TREASURE_HUNTER_FREE_TREASURE_CHANCE;
                    $classData[$classKey]['advanced_percentage'] = self::ADV_TREASURE_HUNTER_FREE_TREASURE_CHANCE;
                    break;
                    
                case 'proud_merchant':
                    $classData[$classKey]['basic_percentage'] = self::PROUD_MERCHANT_BONUS_EARNING;
                    $classData[$classKey]['advanced_percentage'] = self::ADV_PROUD_MERCHANT_BONUS_EARNING;
                    break;
                    
                case 'fortune_gambler':
                    $classData[$classKey]['basic_double_chance'] = self::FORTUNE_GAMBLER_DOUBLE_CHANCE;
                    $classData[$classKey]['basic_lose_chance'] = self::FORTUNE_GAMBLER_LOSE_CHANCE;
                    $classData[$classKey]['advanced_double_chance'] = self::ADV_FORTUNE_GAMBLER_DOUBLE_CHANCE;
                    $classData[$classKey]['advanced_lose_chance'] = self::ADV_FORTUNE_GAMBLER_LOSE_CHANCE;
                    break;
                    
                case 'moon_guardian':
                    $classData[$classKey]['basic_percentage'] = self::MOON_GUARDIAN_RANDOM_BOX_CHANCE;
                    $classData[$classKey]['advanced_percentage'] = self::ADV_MOON_GUARDIAN_RANDOM_BOX_CHANCE;
                    break;
                    
                case 'day_breaker':
                    $classData[$classKey]['basic_percentage'] = self::DAY_BREAKER_RANDOM_BOX_CHANCE;
                    $classData[$classKey]['advanced_percentage'] = self::ADV_DAY_BREAKER_RANDOM_BOX_CHANCE;
                    break;
                    
                case 'box_collector':
                    $classData[$classKey]['basic_percentage'] = self::BOX_COLLECTOR_DOUBLE_BOX_CHANCE;
                    $classData[$classKey]['advanced_percentage'] = self::ADV_BOX_COLLECTOR_DOUBLE_BOX_CHANCE;
                    break;
                    
                case 'divine_scholar':
                    $classData[$classKey]['basic_percentage'] = self::DIVINE_SCHOLAR_BONUS_EXP;
                    $classData[$classKey]['advanced_percentage'] = self::ADV_DIVINE_SCHOLAR_BONUS_EXP;
                    break;
            }
        }
        
        return view('game.class-path', compact('user', 'classData'));
    }
}
