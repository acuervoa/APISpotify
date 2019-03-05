<?php

namespace App\Console;

use App\Http\Controllers\Spotify\SpotifySessionController;
use App\Http\Controllers\Track\TrackRecentController;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
        $schedule->call(function () {

            $spotifyController = new SpotifySessionController();
            $spotifyController->refreshTokens();

            Log::info('Tokens refreshed');

            // Now add some handlers
            $trackController = new TrackRecentController();
            $trackController->recentTracks();

            Log::info('New tracks adquisition');
        })->everyThirtyMinutes();
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
