<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

// Define the schedules in console routes
Schedule::command('game:add-treasure')->hourly();  // Add 5 treasure every hour
Schedule::command('game:distribute-prize')->dailyAt('00:00'); // Distribute prize pool daily at midnight
Schedule::command('game:process-auto-earning')->hourly(); // Process auto earning every hour  
