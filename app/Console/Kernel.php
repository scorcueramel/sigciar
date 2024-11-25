<?php

namespace App\Console;

use App\Console\Commands\DeleteInscripcionTemporal;
use App\Console\Commands\DeleteReservaTemporal;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [DeleteReservaTemporal::class,DeleteInscripcionTemporal::class];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        $schedule->command(DeleteReservaTemporal::class)->dailyAt('03:00');
        $schedule->command(DeleteInscripcionTemporal::class)->dailyAt('03:05');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
