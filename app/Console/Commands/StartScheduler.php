<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class StartScheduler extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'schedule:start {--interval=60 : Check interval in seconds}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Start the Laravel scheduler in a continuous loop';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $interval = (int) $this->option('interval');
        
        $this->info('🚀 Starting Laravel Scheduler...');
        $this->info("⏱️  Checking every {$interval} seconds");
        $this->info('⛔ Press Ctrl+C to stop');
        $this->newLine();

        $iteration = 0;
        
        while (true) {
            $iteration++;
            $timestamp = now()->format('Y-m-d H:i:s');
            
            $this->line("[$timestamp] Iteration #{$iteration} - Checking for scheduled tasks...");
            
            try {
                // Run the scheduler
                $exitCode = Artisan::call('schedule:run');
                
                if ($exitCode === 0) {
                    $output = Artisan::output();
                    
                    if (str_contains($output, 'No scheduled commands are ready to run')) {
                        $this->comment('   ⏳ No commands ready to run');
                    } else {
                        $this->info('   ✅ Scheduled commands executed!');
                        $this->line("   📋 Output: " . trim($output));
                    }
                } else {
                    $this->error('   ❌ Schedule run failed');
                }
                
            } catch (\Exception $e) {
                $this->error("   💥 Error: " . $e->getMessage());
            }
            
            // Show next check time
            $nextCheck = now()->addSeconds($interval)->format('H:i:s');
            $this->comment("   ⏰ Next check at: {$nextCheck}");
            $this->newLine();
            
            // Sleep for the specified interval
            sleep($interval);
        }
    }
}
