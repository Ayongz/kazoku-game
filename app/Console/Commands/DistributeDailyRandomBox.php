<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class DistributeDailyRandomBox extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'game:distribute-daily-randombox';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Give 3 random boxes to every player daily.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🎁 Starting daily random box distribution...');
        $users = User::all();
        $updatedCount = 0;
        foreach ($users as $user) {
            $currentBox = $user->randombox ?? 0;
            $user->randombox = $currentBox + 3;
            $user->save();
            $updatedCount++;
            $this->line("User {$user->name} (ID: {$user->id}): {$currentBox} → {$user->randombox} random boxes");
        }
        $this->info("✅ Distributed 3 random boxes to {$updatedCount} players.");
        $this->info("Next distribution: Tomorrow at 00:00");
    }
}
