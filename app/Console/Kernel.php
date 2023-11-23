<?php

namespace App\Console;

use App\Console\Commands\productexpired;
use App\Console\Commands\deleteexpired;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        productexpired::class,
        deleteexpired::class,
    ];
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('product:expired')->everyFourHours();
        $schedule->command('delete:expired')->everyFourHours();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
