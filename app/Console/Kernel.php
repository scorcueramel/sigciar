<?php

namespace App\Console;

use App\Console\Commands\DeleteInscripcionTemporal;
use App\Console\Commands\DeleteReservaTemporal;
use App\Console\Commands\SendNotificacionMembership;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
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
				$schedule->command(SendNotificacionMembership::class)->dailyAt('04:00');
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
