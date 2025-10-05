<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\GameSetting;

class ProcessAutoEarning extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'game:process-auto-earning';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process auto earning for players with auto earning ability (0.05% per level per hour)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🤖 Starting Auto Earning Processing...');

        // Get all players with auto earning ability (level 1 or above)
        $autoEarningPlayers = User::where('auto_earning_level', '>', 0)->get();

        if ($autoEarningPlayers->count() === 0) {
            $this->warn('⚠️  No players with auto earning ability found');
            return;
        }

        $this->info("👥 Found {$autoEarningPlayers->count()} players with auto earning ability");

        $totalAutoEarned = 0;
        $processedCount = 0;

        foreach ($autoEarningPlayers as $player) {
            // Calculate auto earning amount (0.05% per level per hour)
            $autoEarningRate = $player->auto_earning_level * 0.05; // 0.05% per level
            $autoEarnAmount = $player->money_earned * ($autoEarningRate / 100);

            // Only process if there's something to earn
            if ($autoEarnAmount > 0) {
                // Calculate prize pool contribution (5% of auto earned amount)
                $prizePoolContribution = $autoEarnAmount * 0.05;
                $playerReceives = $autoEarnAmount - $prizePoolContribution;

                // Update player money
                $player->money_earned += $playerReceives;
                $player->save();

                // Update global prize pool
                $gameSettings = GameSetting::first();
                if ($gameSettings) {
                    $gameSettings->global_prize_pool += $prizePoolContribution;
                    $gameSettings->save();
                }

                $totalAutoEarned += $playerReceives;
                $processedCount++;

                $this->line("💰 {$player->name} (Level {$player->auto_earning_level}): " .
                          "Auto earned IDR " . number_format($playerReceives, 0, ',', '.') .
                          " (Rate: {$autoEarningRate}%)");
            }
        }

        // Summary report
        $this->info("=== Auto Earning Processing Complete ===");
        $this->info("Players processed: {$processedCount}");
        $this->info("Total auto earned: IDR " . number_format($totalAutoEarned, 0, ',', '.'));
        $this->info("Next processing: In 1 hour");

        // Log to Laravel log for monitoring
        logger("Auto earning processed: {$processedCount} players earned IDR " . number_format($totalAutoEarned, 0, ',', '.'));
    }
}
