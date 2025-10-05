<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class AddPlayerAttempts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'game:add-attempts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add 5 attempts to all players every hour (max 20 attempts)';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        // Constants for attempt system
        $attemptsToAdd = 5;
        $maxAttempts = 20;
        
        $this->info('Starting hourly attempt addition...');
        
        // Get all users and their current attempts
        $users = User::all();
        $updatedCount = 0;
        $skippedCount = 0;
        
        foreach ($users as $user) {
            $currentAttempts = $user->attempts ?? 0;
            
            if ($currentAttempts >= $maxAttempts) {
                // User already at max attempts, skip
                $skippedCount++;
                continue;
            }
            
            // Calculate new attempts (add 5 but cap at 20)
            $newAttempts = min($currentAttempts + $attemptsToAdd, $maxAttempts);
            
            // Update user attempts
            $user->update([
                'attempts' => $newAttempts,
                'last_attempt_at' => now(),
            ]);
            
            $updatedCount++;
            
            $this->line("User {$user->name} (ID: {$user->id}): {$currentAttempts} → {$newAttempts} attempts");
        }
        
        // Summary report
        $this->info("=== Hourly Attempt Addition Complete ===");
        $this->info("Players updated: {$updatedCount}");
        $this->info("Players skipped (already at max): {$skippedCount}");
        $this->info("Total players processed: " . ($updatedCount + $skippedCount));
        $this->info("Attempts added per player: {$attemptsToAdd}");
        $this->info("Maximum attempts cap: {$maxAttempts}");
        
        // Log to Laravel log for monitoring
        logger("Hourly attempts added: {$updatedCount} players updated, {$skippedCount} players skipped");
    }
}
