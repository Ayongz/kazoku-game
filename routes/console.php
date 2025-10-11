<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

// Define the schedules in console routes
Schedule::command('game:add-treasure')->everyMinute();  // Check treasure regeneration every minute for Fast Recovery
Schedule::command('game:distribute-prize')->dailyAt('00:00')->timezone('Asia/Jakarta'); // Distribute prize pool daily at midnight GMT+7
Schedule::command('game:process-auto-earning')->hourly(); // Process auto earning every hour  
Schedule::command('gambling:reset-daily-attempts')->dailyAt('00:00')->timezone('Asia/Jakarta'); // Reset gambling attempts daily at midnight GMT+7
