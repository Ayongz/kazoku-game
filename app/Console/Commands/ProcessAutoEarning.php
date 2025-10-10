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
    protected $description = 'Process auto earning for players with auto earning ability (0.05% per level per hour) and prestige bonuses (1-5% per hour)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🤖 Starting Auto Earning & Prestige Processing...');

        // Get all players with auto earning ability OR prestige level
        $earningPlayers = User::where(function($query) {
            $query->where('auto_earning_level', '>', 0)
                  ->orWhere('prestige_level', '>', 0);
        })->get();

        if ($earningPlayers->count() === 0) {
            $this->warn('⚠️  No players with auto earning or prestige abilities found');
            return;
        }

        $this->info("👥 Found {$earningPlayers->count()} players with earning abilities");

        $totalAutoEarned = 0;
        $totalPrestigeEarned = 0;
        $processedCount = 0;

        foreach ($earningPlayers as $player) {
            $totalEarnAmount = 0;
            $earningDetails = [];

            // Calculate auto earning amount (0.05% per level per hour)
            if ($player->auto_earning_level > 0) {
                $autoEarningRate = $player->auto_earning_level * 0.05; // 0.05% per level
                $autoEarnAmount = $player->money_earned * ($autoEarningRate / 100);
                $totalEarnAmount += $autoEarnAmount;
                $totalAutoEarned += $autoEarnAmount;
                $earningDetails[] = "Auto: {$autoEarningRate}%";
            }

            // Calculate prestige earning amount (1-5% per hour based on prestige level)
            if ($player->prestige_level > 0) {
                $prestigeEarningRate = $player->prestige_level; // 1% per prestige level
                $prestigeEarnAmount = $player->money_earned * ($prestigeEarningRate / 100);
                $totalEarnAmount += $prestigeEarnAmount;
                $totalPrestigeEarned += $prestigeEarnAmount;
                $earningDetails[] = "Prestige: {$prestigeEarningRate}%";
            }

            // Only process if there's something to earn
            if ($totalEarnAmount > 0) {
                // Calculate prize pool contribution (10% of total earned amount)
                $prizePoolContribution = $totalEarnAmount * 0.10;
                $playerReceives = $totalEarnAmount - $prizePoolContribution;

                // Update player money
                $player->money_earned += $playerReceives;
                $player->save();

                // Update global prize pool
                $gameSettings = GameSetting::first();
                if ($gameSettings) {
                    $gameSettings->global_prize_pool += $prizePoolContribution;
                    $gameSettings->save();
                }

                $processedCount++;

                $this->line("💰 {$player->name}: " .
                          "Earned IDR " . number_format($playerReceives, 0, ',', '.') .
                          " (" . implode(' + ', $earningDetails) . ")");
            }
        }

        // Summary report
        $this->info("=== Auto Earning & Prestige Processing Complete ===");
        $this->info("Players processed: {$processedCount}");
        $this->info("Total auto earned: IDR " . number_format($totalAutoEarned, 0, ',', '.'));
        $this->info("Total prestige earned: IDR " . number_format($totalPrestigeEarned, 0, ',', '.'));
        $this->info("Grand total earned: IDR " . number_format($totalAutoEarned + $totalPrestigeEarned, 0, ',', '.'));
        $this->info("Next processing: In 1 hour");

        // Log to Laravel log for monitoring
        logger("Auto + Prestige earning processed: {$processedCount} players earned IDR " . 
               number_format($totalAutoEarned + $totalPrestigeEarned, 0, ',', '.') . 
               " (Auto: " . number_format($totalAutoEarned, 0, ',', '.') . 
               ", Prestige: " . number_format($totalPrestigeEarned, 0, ',', '.') . ")");
    }
}
