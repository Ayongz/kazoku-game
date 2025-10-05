<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class AddPlayerAttempts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:add-player-attempts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        // Define the number of attempts to grant
        $attemptsToGrant = 1;
        
        // 1. Update all users in the database
        $updatedCount = DB::table('users')
                           ->where('attempts', '<', $attemptsToGrant) // Only update if attempts are less than max
                           ->update([
                               'attempts' => $attemptsToGrant,
                               'last_attempt_at' => now(), // Optional: Update the last_attempt_at time
                           ]);

        // 2. Log the operation for tracking
        $this->info("Successfully reset attempts for {$updatedCount} players to {$attemptsToGrant}.");
    }
}
