<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class AddPlayerTreasures extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'game:add-treasure';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add 5 treasure to players based on their Fast Recovery level (60, 55, 50, 45, 40, or 30 minute intervals)';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        // Constants for treasure system
        $treasureToAdd = 5;
        $baseMaxTreasure = 20;
        
        // Fast Recovery intervals in minutes [level 0, 1, 2, 3, 4, 5]
        $fastRecoveryIntervals = [60, 55, 50, 45, 40, 30];
        
        $this->info('Starting Fast Recovery treasure addition check...');
        
        // Get all users and their current treasure
        $users = User::all();
        $updatedCount = 0;
        $skippedCount = 0;
        $notReadyCount = 0;
        
        foreach ($users as $user) {
            $currentTreasure = $user->treasure ?? 0;
            
            // Calculate max treasure based on treasure multiplier level
            // Base: 20, Level 1: 25, Level 2: 30, ..., Level 10: 70
            $maxTreasure = $baseMaxTreasure + ($user->treasure_multiplier_level * 5);
            
            if ($currentTreasure >= $maxTreasure) {
                // User already at max treasure, skip
                $skippedCount++;
                continue;
            }
            
            // Get user's Fast Recovery level (default 0 if null)
            $fastRecoveryLevel = $user->fast_recovery_level ?? 0;
            $intervalMinutes = $fastRecoveryIntervals[$fastRecoveryLevel];
            
            // Check if enough time has passed since last treasure addition
            $lastAttempt = $user->last_attempt_at;
            $now = now();
            
            if ($lastAttempt) {
                $minutesSinceLastAttempt = $lastAttempt->diffInMinutes($now);
                
                if ($minutesSinceLastAttempt < $intervalMinutes) {
                    // Not enough time has passed
                    $notReadyCount++;
                    continue;
                }
            }
            
            // Calculate new treasure (add 5 but cap at user's max)
            $newTreasure = min($currentTreasure + $treasureToAdd, $maxTreasure);
            
            // Update user treasure and last attempt time
            $user->update([
                'treasure' => $newTreasure,
                'last_attempt_at' => $now,
            ]);
            
            $updatedCount++;
            
            $this->line("User {$user->name} (ID: {$user->id}): {$currentTreasure} → {$newTreasure} treasure (Fast Recovery: {$intervalMinutes}min, max: {$maxTreasure})");
        }
        
        // Summary report
        $this->info("=== Fast Recovery Treasure Addition Complete ===");
        $this->info("Players updated: {$updatedCount}");
        $this->info("Players skipped (already at max): {$skippedCount}");
        $this->info("Players not ready (interval not reached): {$notReadyCount}");
        $this->info("Total players processed: " . ($updatedCount + $skippedCount + $notReadyCount));
        $this->info("Treasure added per eligible player: {$treasureToAdd}");
        $this->info("Fast Recovery intervals: " . implode(', ', $fastRecoveryIntervals) . " minutes");
        
        // Log to Laravel log for monitoring
        logger("Fast Recovery treasure check: {$updatedCount} players updated, {$skippedCount} players skipped, {$notReadyCount} players not ready");
    }
}
