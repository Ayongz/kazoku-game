<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\GameSetting;
use App\Models\PlayerLog;
use Carbon\Carbon;

class GamblingController extends Controller
{
    const BASE_BET_AMOUNT = 3000;
    const BET_INCREASE_PER_LEVEL = 1000;
    const BASE_DAILY_ATTEMPTS = 20;
    const ATTEMPTS_INCREASE_PER_LEVEL = 2;
    const EXP_PER_GAME = 10;
    const EXP_TO_NEXT_LEVEL = 100;
    const FUSION_COST = 1000;
    const FUSION_SUCCESS_RATE = 35;
    const WINNER_CONTRIBUTION_RATE = 20; // 20% to global prize pool

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display the gambling hall
     */
    public function index()
    {
        $user = auth()->user();
        
        // Initialize gambling fields if they don't exist
        if (is_null($user->gambling_level)) {
            $user->gambling_level = 1;
            $user->gambling_exp = 0;
            $user->gambling_attempts_today = 0;
            $user->last_gambling_reset = now();
            $user->rare_treasures = 0;
            $user->save();
        }
        
        $gamblingLevel = $user->gambling_level;
        $maxBetAmount = self::BASE_BET_AMOUNT + (($gamblingLevel - 1) * 1000);
        $maxDailyAttempts = self::BASE_DAILY_ATTEMPTS + (($gamblingLevel - 1) * 2);
        $remainingAttempts = $maxDailyAttempts - $user->gambling_attempts_today;
        
        // Check if user can gamble (has money and attempts)
        $canGamble = $user->money_earned >= self::BASE_BET_AMOUNT && $remainingAttempts > 0;
        
        return view('gambling.hall', compact(
            'user',
            'gamblingLevel',
            'maxBetAmount',
            'maxDailyAttempts',
            'remainingAttempts',
            'canGamble'
        ));
    }

    /**
     * Play dice duel game
     */
    public function diceDuel(Request $request)
    {
        $user = Auth::user();
        
        // Check if user has gambling attempts left
        if ($user->gambling_attempts_today >= $this->getMaxDailyAttempts($user)) {
            return redirect()->back()->with('error', __('gambling.no_attempts_left'));
        }
        
        $betAmount = $request->input('bet_amount', self::BASE_BET_AMOUNT);
        
        // Validate bet
        $validation = $this->validateBet($user, $betAmount);
        if (!$validation['success']) {
            return redirect()->back()->with('error', $validation['message']);
        }

        // Roll dice
        $playerRoll = rand(1, 6);
        $aiRoll = rand(1, 6);
        $playerWins = $playerRoll > $aiRoll;
        
        // Process game result
        $result = $this->processGameResult($user, $betAmount, $playerWins, 'gambling_dice');
        
        // Create result message
        $diceResult = __('gambling.dice_result', [
            'player_roll' => $playerRoll,
            'house_roll' => $aiRoll
        ]);
        
        if ($playerWins) {
            $message = __('gambling.you_won') . ' ' . $diceResult . ' +IDR ' . number_format($betAmount);
        } else {
            $message = __('gambling.you_lost') . ' ' . $diceResult . ' -IDR ' . number_format($betAmount);
        }
        
        // Add experience message
        if (isset($result['exp_gained'])) {
            $message .= ' | ' . __('gambling.experience_gained', ['exp' => $result['exp_gained']]);
        }
        
        // Add level up message
        if (isset($result['level_up'])) {
            $message .= ' | ' . __('gambling.level_up', ['level' => $result['level_up']]);
        }
        
        return redirect()->back()->with($playerWins ? 'success' : 'lose', $message);
    }

    /**
     * Play treasure fusion gamble
     */
    public function treasureFusion(Request $request)
    {
        $user = Auth::user();
        
        // Check attempts first before any processing
        if ($user->gambling_attempts_today >= $this->getMaxDailyAttempts($user)) {
            return redirect()->back()->with('error', __('gambling.no_attempts_left'));
        }
        
        // Check if user has at least 3 treasures and fusion cost
        if ($user->treasure < 3) {
            return redirect()->back()->with('error', __('gambling.need_treasures'));
        }
        
        if ($user->money_earned < self::FUSION_COST) {
            return redirect()->back()->with('error', __('gambling.need_money'));
        }

        // Process fusion
        $success = rand(1, 100) <= self::FUSION_SUCCESS_RATE;
        
        // Deduct cost and treasures
        $user->money_earned -= self::FUSION_COST;
        $user->treasure -= 3;
        
        if ($success) {
            $user->rare_treasures += 1;
            $message = __('gambling.fusion_success') . ' +1 ' . __('gambling.rare_treasure');
            $messageType = 'success';
        } else {
            $message = __('gambling.fusion_failed');
            $messageType = 'lose';
        }
        
        // Add gambling exp and increment attempts
        $expResult = $this->addGamblingExp($user);
        $user->gambling_attempts_today += 1;
        $user->save();

        // Create log entry for treasure fusion
        $description = $success 
            ? "Treasure fusion successful: Gained 1 rare treasure (Cost: IDR " . number_format(self::FUSION_COST) . ", 3 treasures)"
            : "Treasure fusion failed: Lost IDR " . number_format(self::FUSION_COST) . " and 3 treasures";

        PlayerLog::createLog(
            userId: $user->id,
            actionType: 'treasure_fusion',
            description: $description,
            moneyChange: -self::FUSION_COST,
            treasureChange: -3,
            rareTreasureChange: $success ? 1 : 0,
            experienceGained: $expResult['exp_gained'],
            additionalData: [
                'fusion_success' => $success,
                'fusion_cost' => self::FUSION_COST,
                'treasures_used' => 3,
                'gambling_level' => $user->gambling_level,
                'level_up' => $expResult['level_up'] ?? null
            ],
            isSuccess: $success
        );
        
        $message .= ' ' . __('gambling.experience_gained', ['exp' => self::EXP_PER_GAME]);
        if (isset($expResult['level_up'])) {
            $message .= ' ' . __('gambling.level_up', ['level' => $expResult['level_up']]);
        }
        
        return redirect()->back()->with($messageType, $message);
    }

    /**
     * Play card flip game
     */
    public function cardFlip(Request $request)
    {
        $user = Auth::user();
        
        // Check if user has gambling attempts left
        $maxDailyAttempts = self::BASE_DAILY_ATTEMPTS + (($user->gambling_level - 1) * 2);
        $remainingAttempts = $maxDailyAttempts - $user->gambling_attempts_today;
        
        if ($remainingAttempts <= 0) {
            return redirect()->back()->with('error', __('gambling.no_attempts_left'));
        }
        
        $betAmount = $request->input('bet_amount', self::BASE_BET_AMOUNT);
        
        // Validate bet
        $validation = $this->validateBet($user, $betAmount);
        if (!$validation['success']) {
            return redirect()->back()->with('error', $validation['message']);
        }

        // Draw cards (1-13, where 1=Ace, 11=Jack, 12=Queen, 13=King)
        $playerCard = rand(1, 13);
        $aiCard = rand(1, 13);
        $playerWins = $playerCard > $aiCard;
        
        // Process game result
        $result = $this->processGameResult($user, $betAmount, $playerWins, 'gambling_card');
        
        $playerCardName = $this->getCardName($playerCard);
        $aiCardName = $this->getCardName($aiCard);
        
        // Create result message
        $cardResult = __('gambling.card_result', [
            'player_card' => $playerCardName,
            'house_card' => $aiCardName
        ]);
        
        if ($playerWins) {
            $message = __('gambling.you_won') . ' ' . $cardResult . ' +IDR ' . number_format($betAmount);
        } else {
            $message = __('gambling.you_lost') . ' ' . $cardResult . ' -IDR ' . number_format($betAmount);
        }
        
        // Add experience message
        if (isset($result['exp_gained'])) {
            $message .= ' | ' . __('gambling.experience_gained', ['exp' => $result['exp_gained']]);
        }
        
        // Add level up message
        if (isset($result['level_up'])) {
            $message .= ' | ' . __('gambling.level_up', ['level' => $result['level_up']]);
        }
        
        return redirect()->back()->with($playerWins ? 'success' : 'lose', $message);
    }

    /**
     * Validate betting requirements
     */
    private function validateBet($user, $betAmount)
    {
        if ($betAmount < self::BASE_BET_AMOUNT) {
            return ['success' => false, 'message' => 'Minimum bet is IDR ' . number_format(self::BASE_BET_AMOUNT)];
        }
        
        if ($betAmount > $this->getMaxBetAmount($user)) {
            return ['success' => false, 'message' => 'Maximum bet for your level is IDR ' . number_format($this->getMaxBetAmount($user))];
        }
        
        if ($user->money_earned < $betAmount) {
            return ['success' => false, 'message' => 'Insufficient money to place this bet.'];
        }
        
        if ($user->gambling_attempts_today >= $this->getMaxDailyAttempts($user)) {
            return ['success' => false, 'message' => 'You have used all your gambling attempts for today.'];
        }
        
        return ['success' => true];
    }

    /**
     * Process game result (win/loss)
     */
    private function processGameResult($user, $betAmount, $playerWins, $gameType = 'gambling_dice')
    {
        $moneyChange = 0;
        
        if ($playerWins) {
            // Player wins - add money and contribute to prize pool
            $winnings = $betAmount;
            $contribution = intval($winnings * (self::WINNER_CONTRIBUTION_RATE / 100));
            
            $user->money_earned += $winnings - $contribution;
            $moneyChange = $winnings - $contribution;
            
            // Add to global prize pool
            $gameSettings = GameSetting::first();
            if ($gameSettings) {
                $gameSettings->global_prize_pool += $contribution;
                $gameSettings->save();
            }
        } else {
            // Player loses
            $user->money_earned -= $betAmount;
            $moneyChange = -$betAmount;
        }
        
        // Add gambling exp and update attempts
        $expResult = $this->addGamblingExp($user);
        $user->gambling_attempts_today += 1;
        $user->save();

        // Create log entry for gambling
        $description = $playerWins 
            ? "Won gambling game: +IDR " . number_format($moneyChange) . " (Bet: IDR " . number_format($betAmount) . ")"
            : "Lost gambling game: -IDR " . number_format($betAmount) . " (Bet amount)";

        PlayerLog::createLog(
            userId: $user->id,
            actionType: $gameType,
            description: $description,
            moneyChange: $moneyChange,
            experienceGained: $expResult['exp_gained'],
            additionalData: [
                'bet_amount' => $betAmount,
                'player_wins' => $playerWins,
                'gambling_level' => $user->gambling_level,
                'level_up' => $expResult['level_up'] ?? null
            ],
            isSuccess: $playerWins
        );
        
        return array_merge(['player_wins' => $playerWins], $expResult);
    }

    /**
     * Add gambling experience and level up if needed
     */
    private function addGamblingExp($user)
    {
        $oldLevel = $user->gambling_level;
        $user->gambling_exp += self::EXP_PER_GAME;
        
        $leveledUp = false;
        while ($user->gambling_exp >= self::EXP_TO_NEXT_LEVEL) {
            $user->gambling_exp -= self::EXP_TO_NEXT_LEVEL;
            $user->gambling_level += 1;
            $leveledUp = true;
        }
        
        $result = ['exp_gained' => self::EXP_PER_GAME];
        if ($leveledUp) {
            $result['level_up'] = $user->gambling_level;
        }
        
        return $result;
    }

    /**
     * Get maximum bet amount for user's gambling level
     */
    private function getMaxBetAmount($user)
    {
        return self::BASE_BET_AMOUNT + (($user->gambling_level - 1) * self::BET_INCREASE_PER_LEVEL);
    }

    /**
     * Get maximum daily attempts for user's gambling level
     */
    private function getMaxDailyAttempts($user)
    {
        return self::BASE_DAILY_ATTEMPTS + (($user->gambling_level - 1) * self::ATTEMPTS_INCREASE_PER_LEVEL);
    }

    /**
     * Get remaining gambling attempts for today
     */
    private function getRemainingAttempts($user)
    {
        $maxAttempts = $this->getMaxDailyAttempts($user);
        return $maxAttempts - $user->gambling_attempts_today;
    }

    /**
     * Check if user can gamble
     */
    private function canGamble($user)
    {
        return $user->money_earned >= self::BASE_BET_AMOUNT && 
               $user->gambling_attempts_today < $this->getMaxDailyAttempts($user);
    }

    /**
     * Get card name for display
     */
    private function getCardName($cardValue)
    {
        $names = [
            1 => 'Ace (1)',
            2 => '2',
            3 => '3', 
            4 => '4',
            5 => '5',
            6 => '6',
            7 => '7',
            8 => '8',
            9 => '9',
            10 => '10',
            11 => 'Jack (11)',
            12 => 'Queen (12)',
            13 => 'King (13)'
        ];
        
        return $names[$cardValue];
    }
}
