<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Carbon\Carbon;

class ResetDailyGamblingAttempts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gambling:reset-daily-attempts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset daily gambling attempts for all players to their maximum based on gambling level';

    /**
     * Gambling constants (same as in GamblingController)
     */
    const BASE_DAILY_ATTEMPTS = 20;
    const ATTEMPTS_INCREASE_PER_LEVEL = 2;

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting daily gambling attempts reset...');
        
        // Get all users with gambling data
        $users = User::whereNotNull('gambling_level')->get();
        
        $resetCount = 0;
        $timezone = 'Asia/Jakarta'; // GMT+7
        $now = Carbon::now($timezone);
        
        foreach ($users as $user) {
            // Calculate max attempts for this user's gambling level
            $maxAttempts = self::BASE_DAILY_ATTEMPTS + (($user->gambling_level - 1) * self::ATTEMPTS_INCREASE_PER_LEVEL);
            
            // Reset attempts to 0 (fresh start - no attempts used yet)
            $oldAttempts = $user->gambling_attempts_today;
            $user->gambling_attempts_today = 0;
            $user->last_gambling_reset = $now;
            $user->save();
            
            $resetCount++;
            
            $this->line("Reset user {$user->name} (Level {$user->gambling_level}): {$oldAttempts} -> 0 used, {$maxAttempts} available");
        }
        
        $this->info("Successfully reset gambling attempts for {$resetCount} users at {$now->format('Y-m-d H:i:s')} (GMT+7)");
        $this->info("All users now have fresh daily gambling attempts available.");
        
        return Command::SUCCESS;
    }
}
