<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\GameSetting;
use Illuminate\Support\Facades\DB;

class DistributePrizePool extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'game:distribute-prize';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Distribute daily prize pool to top 3 richest players (50%/30%/20% split) and reset pool to 0';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🏆 Starting Daily Prize Pool Distribution...');
        
        // Get current game settings
        $gameSettings = GameSetting::first();
        
        if (!$gameSettings || $gameSettings->global_prize_pool <= 0) {
            $this->warn('⚠️  No prize pool to distribute (current: IDR 0)');
            return;
        }
        
        $prizePool = $gameSettings->global_prize_pool;
        $this->info("💰 Current Prize Pool: IDR " . number_format($prizePool, 0, ',', '.'));
        
        // Find the top 3 players with the highest money_earned
        $topPlayers = User::orderBy('money_earned', 'desc')->take(3)->get();
        
        if ($topPlayers->count() === 0) {
            $this->error('❌ No players found in the database');
            return;
        }
        
        // Prize distribution percentages
        $distributionRates = [
            1 => 0.50, // 1st place: 50%
            2 => 0.30, // 2nd place: 30%
            3 => 0.20, // 3rd place: 20%
        ];
        
        $this->info("🎯 Top 3 Richest Players:");
        foreach ($topPlayers as $index => $player) {
            $position = $index + 1;
            $this->info("#{$position}: {$player->name} (ID: {$player->id}) - IDR " . number_format($player->money_earned, 0, ',', '.'));
        }
        
        // Calculate prize amounts
        $distributions = [];
        foreach ($topPlayers as $index => $player) {
            $position = $index + 1;
            $rate = $distributionRates[$position];
            $prizeAmount = $prizePool * $rate;
            
            $distributions[] = [
                'player' => $player,
                'position' => $position,
                'amount' => $prizeAmount,
                'percentage' => $rate * 100
            ];
        }
        
        // Use database transaction for consistency
        DB::transaction(function () use ($distributions, $gameSettings) {
            // Award prizes to top 3 players
            foreach ($distributions as $distribution) {
                $player = $distribution['player'];
                $amount = $distribution['amount'];
                
                $player->money_earned += $amount;
                $player->save();
            }
            
            // Reset prize pool to 0
            $gameSettings->global_prize_pool = 0;
            $gameSettings->save();
        });
        
        $this->info("✅ Prize pool distributed successfully!");
        
        // Display distribution results
        foreach ($distributions as $distribution) {
            $player = $distribution['player'];
            $position = $distribution['position'];
            $amount = $distribution['amount'];
            $percentage = $distribution['percentage'];
            
            $positionEmoji = $position === 1 ? '🥇' : ($position === 2 ? '🥈' : '🥉');
            $this->info("{$positionEmoji} #{$position}: {$player->name} received IDR " . number_format($amount, 0, ',', '.') . " ({$percentage}%)");
            $this->info("💰 New Total: IDR " . number_format($player->money_earned, 0, ',', '.'));
        }
        
        $this->info("🔄 Prize pool reset to IDR 0");
        
        // Log the distribution for tracking
        $logEntries = [];
        foreach ($distributions as $distribution) {
            $player = $distribution['player'];
            $amount = $distribution['amount'];
            $position = $distribution['position'];
            $logEntries[] = "#{$position}: {$player->name} (ID: {$player->id}) - IDR " . number_format($amount, 0, ',', '.');
        }
        logger("Daily prize pool distributed (Total: IDR " . number_format($prizePool, 0, ',', '.') . ") - " . implode(', ', $logEntries));
        
        // Display summary
        $this->info("=== Daily Prize Distribution Summary ===");
        $this->info("Total Prize Pool: IDR " . number_format($prizePool, 0, ',', '.'));
        $this->info("Winners: " . $topPlayers->count() . " players");
        $this->info("Distribution Date: " . now()->format('Y-m-d H:i:s'));
        $this->info("Next Distribution: Tomorrow at 00:00");
    }
}
