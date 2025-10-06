<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Services\ExperienceService;

class InventoryController extends Controller
{
    /**
     * Display the inventory page
     */
    public function index()
    {
        $user = Auth::user();
        
        return view('game.inventory', [
            'user' => $user,
            'randomBoxCount' => $user->randombox ?? 0
        ]);
    }

    /**
     * Open a random box and return rewards
     */
    public function openRandomBox(Request $request)
    {
        $user = Auth::user();

        // Check if user has random boxes
        if (($user->randombox ?? 0) <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'You don\'t have any random boxes to open!'
            ]);
        }

        // Generate random reward
        $reward = $this->generateRandomReward();
        
        // Apply rewards to user
        $this->applyRewards($user, $reward);
        
        // Decrease random box count
        $user->randombox = ($user->randombox ?? 1) - 1;
        $user->save();

        return response()->json([
            'success' => true,
            'reward' => $reward,
            'remaining_boxes' => $user->randombox ?? 0,
            'message' => 'Random box opened successfully!'
        ]);
    }

    /**
     * Generate random reward based on rarity tiers
     */
    private function generateRandomReward(): array
    {
        $roll = rand(1, 100);
        
        if ($roll <= 5) {
            // Legendary (5% chance)
            return $this->generateLegendaryReward();
        } elseif ($roll <= 30) {
            // Rare (25% chance)
            return $this->generateRareReward();
        } else {
            // Common (70% chance)
            return $this->generateCommonReward();
        }
    }

    /**
     * Generate common tier rewards
     */
    private function generateCommonReward(): array
    {
        $rewards = [];
        $rewardTypes = ['money', 'treasures', 'experience'];
        $selectedType = $rewardTypes[array_rand($rewardTypes)];

        switch ($selectedType) {
            case 'money':
                $amount = rand(1000, 5000);
                $rewards[] = [
                    'type' => 'money',
                    'amount' => $amount,
                    'display' => 'IDR ' . number_format($amount, 0, ',', '.'),
                    'icon' => '💰',
                    'rarity' => 'common'
                ];
                break;
                
            case 'treasures':
                $amount = rand(1, 3);
                $rewards[] = [
                    'type' => 'treasures',
                    'amount' => $amount,
                    'display' => $amount . ' Treasure' . ($amount > 1 ? 's' : ''),
                    'icon' => '💎',
                    'rarity' => 'common'
                ];
                break;
                
            case 'experience':
                $amount = rand(50, 150);
                $rewards[] = [
                    'type' => 'experience',
                    'amount' => $amount,
                    'display' => $amount . ' Experience',
                    'icon' => '⭐',
                    'rarity' => 'common'
                ];
                break;
        }

        return [
            'tier' => 'Common',
            'tier_class' => 'text-secondary',
            'rewards' => $rewards
        ];
    }

    /**
     * Generate rare tier rewards
     */
    private function generateRareReward(): array
    {
        $rewards = [];
        
        // Always give money
        $money = rand(10000, 25000);
        $rewards[] = [
            'type' => 'money',
            'amount' => $money,
            'display' => 'IDR ' . number_format($money, 0, ',', '.'),
            'icon' => '💰',
            'rarity' => 'rare'
        ];
        
        // Random second reward
        $secondRewards = ['treasures', 'experience', 'shield'];
        $secondType = $secondRewards[array_rand($secondRewards)];
        
        switch ($secondType) {
            case 'treasures':
                $amount = rand(3, 6);
                $rewards[] = [
                    'type' => 'treasures',
                    'amount' => $amount,
                    'display' => $amount . ' Treasures',
                    'icon' => '💎',
                    'rarity' => 'rare'
                ];
                break;
                
            case 'experience':
                $amount = rand(200, 400);
                $rewards[] = [
                    'type' => 'experience',
                    'amount' => $amount,
                    'display' => $amount . ' Experience',
                    'icon' => '⭐',
                    'rarity' => 'rare'
                ];
                break;
                
            case 'shield':
                $hours = 2;
                $rewards[] = [
                    'type' => 'shield',
                    'amount' => $hours,
                    'display' => $hours . ' Hour Shield',
                    'icon' => '🛡️',
                    'rarity' => 'rare'
                ];
                break;
        }

        return [
            'tier' => 'Rare',
            'tier_class' => 'text-primary',
            'rewards' => $rewards
        ];
    }

    /**
     * Generate legendary tier rewards
     */
    private function generateLegendaryReward(): array
    {
        $rewards = [];
        
        // Always give big money
        $money = rand(50000, 100000);
        $rewards[] = [
            'type' => 'money',
            'amount' => $money,
            'display' => 'IDR ' . number_format($money, 0, ',', '.'),
            'icon' => '💰',
            'rarity' => 'legendary'
        ];
        
        // Always give treasures
        $treasures = rand(10, 20);
        $rewards[] = [
            'type' => 'treasures',
            'amount' => $treasures,
            'display' => $treasures . ' Treasures',
            'icon' => '💎',
            'rarity' => 'legendary'
        ];
        
        // Bonus reward
        $bonusRewards = ['experience', 'shield', 'randombox'];
        $bonusType = $bonusRewards[array_rand($bonusRewards)];
        
        switch ($bonusType) {
            case 'experience':
                $amount = rand(500, 1000);
                $rewards[] = [
                    'type' => 'experience',
                    'amount' => $amount,
                    'display' => $amount . ' Experience',
                    'icon' => '⭐',
                    'rarity' => 'legendary'
                ];
                break;
                
            case 'shield':
                $hours = 6;
                $rewards[] = [
                    'type' => 'shield',
                    'amount' => $hours,
                    'display' => $hours . ' Hour Shield',
                    'icon' => '🛡️',
                    'rarity' => 'legendary'
                ];
                break;
                
            case 'randombox':
                $amount = rand(1, 2);
                $rewards[] = [
                    'type' => 'randombox',
                    'amount' => $amount,
                    'display' => $amount . ' Bonus Random Box' . ($amount > 1 ? 'es' : ''),
                    'icon' => '🎁',
                    'rarity' => 'legendary'
                ];
                break;
        }

        return [
            'tier' => 'Legendary',
            'tier_class' => 'text-warning',
            'rewards' => $rewards
        ];
    }

    /**
     * Apply rewards to user
     */
    private function applyRewards(User $user, array $rewardData): void
    {
        foreach ($rewardData['rewards'] as $reward) {
            switch ($reward['type']) {
                case 'money':
                    $user->money_earned += $reward['amount'];
                    break;
                    
                case 'treasures':
                    $user->treasure += $reward['amount'];
                    // Cap at max capacity
                    $maxTreasure = 20 + ($user->treasure_multiplier_level * 5);
                    if ($user->treasure > $maxTreasure) {
                        $user->treasure = $maxTreasure;
                    }
                    break;
                    
                case 'experience':
                    $oldLevel = $user->level ?? 1;
                    $user->experience += $reward['amount'];
                    
                    // Check for level up
                    $levelUpCheck = ExperienceService::checkLevelUp($user->experience, $user->level ?? 1);
                    if ($levelUpCheck['shouldLevelUp']) {
                        $user->level = $levelUpCheck['newLevel'];
                    }
                    break;
                    
                case 'shield':
                    $hours = $reward['amount'];
                    $user->shield_expires_at = now()->addHours($hours);
                    break;
                    
                case 'randombox':
                    $user->randombox = ($user->randombox ?? 0) + $reward['amount'];
                    break;
            }
        }
        
        $user->save();
    }
}