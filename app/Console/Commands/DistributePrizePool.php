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
    protected $description = 'Distribute daily prize pool to the richest player and reset pool to 0';

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
        
        // Find the player with the highest money_earned
        $richestPlayer = User::orderBy('money_earned', 'desc')->first();
        
        if (!$richestPlayer) {
            $this->error('❌ No players found in the database');
            return;
        }
        
        $this->info("🎯 Richest Player: {$richestPlayer->name} (ID: {$richestPlayer->id})");
        $this->info("💵 Current Money: IDR " . number_format($richestPlayer->money_earned, 0, ',', '.'));
        
        // Use database transaction for consistency
        DB::transaction(function () use ($richestPlayer, $gameSettings, $prizePool) {
            // Award prize pool to richest player
            $richestPlayer->money_earned += $prizePool;
            $richestPlayer->save();
            
            // Reset prize pool to 0
            $gameSettings->global_prize_pool = 0;
            $gameSettings->save();
        });
        
        $this->info("✅ Prize pool distributed successfully!");
        $this->info("🎉 {$richestPlayer->name} received IDR " . number_format($prizePool, 0, ',', '.'));
        $this->info("💰 New Total Money: IDR " . number_format($richestPlayer->money_earned, 0, ',', '.'));
        $this->info("🔄 Prize pool reset to IDR 0");
        
        // Log the distribution for tracking
        logger("Daily prize pool distributed: IDR {$prizePool} awarded to {$richestPlayer->name} (ID: {$richestPlayer->id})");
        
        // Display summary
        $this->info("=== Daily Prize Distribution Summary ===");
        $this->info("Winner: {$richestPlayer->name}");
        $this->info("Prize Amount: IDR " . number_format($prizePool, 0, ',', '.'));
        $this->info("Distribution Date: " . now()->format('Y-m-d H:i:s'));
        $this->info("Next Distribution: Tomorrow at 00:00");
    }
}
