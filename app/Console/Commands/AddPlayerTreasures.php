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
    protected $description = 'Add 5 treasure to all players every hour (max 20 treasure)';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        // Constants for treasure system
        $treasureToAdd = 5;
        $baseMexTreasure = 20;
        
        $this->info('Starting hourly treasure addition...');
        
        // Get all users and their current treasure
        $users = User::all();
        $updatedCount = 0;
        $skippedCount = 0;
        
        foreach ($users as $user) {
            $currentTreasure = $user->treasure ?? 0;
            
            // Calculate max treasure based on treasure multiplier level
            // Base: 20, Level 1: 25, Level 2: 30, ..., Level 10: 70
            $maxTreasure = $baseMexTreasure + ($user->treasure_multiplier_level * 5);
            
            if ($currentTreasure >= $maxTreasure) {
                // User already at max treasure, skip
                $skippedCount++;
                continue;
            }
            
            // Calculate new treasure (add 5 but cap at user's max)
            $newTreasure = min($currentTreasure + $treasureToAdd, $maxTreasure);
            
            // Update user treasure
            $user->update([
                'treasure' => $newTreasure,
                'last_attempt_at' => now(),
            ]);
            
            $updatedCount++;
            
            $this->line("User {$user->name} (ID: {$user->id}): {$currentTreasure} → {$newTreasure} treasure (max: {$maxTreasure})");
        }
        
        // Summary report
        $this->info("=== Hourly Treasure Addition Complete ===");
        $this->info("Players updated: {$updatedCount}");
        $this->info("Players skipped (already at max): {$skippedCount}");
        $this->info("Total players processed: " . ($updatedCount + $skippedCount));
        $this->info("Treasure added per player: {$treasureToAdd}");
        $this->info("Maximum treasure cap: {$baseMexTreasure} + (multiplier level × 5)");
        
        // Log to Laravel log for monitoring
        logger("Hourly treasure added: {$updatedCount} players updated, {$skippedCount} players skipped");
    }
}
