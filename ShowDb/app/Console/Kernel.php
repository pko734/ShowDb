<?php

namespace ShowDb\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\VideoUpdateCommand::class,
        Commands\ImageMigrateCommand::class,
        Commands\MarkEmptySetlists::class,
        Commands\ArchiveVideos::class,
        Commands\MapStateData::class,
        Commands\SpotifyPopulate::class,
        Commands\SetlistFm::class,
        Commands\MonthlyReport::class,
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
	$date = \Carbon\Carbon::now()->format('YmdHs');
	$environment = env('APP_ENV');
	$schedule->command(
	    "db:backup --database=mysql --destination=dropbox --destinationPath=/{$environment}/avett_setlist_db_{$environment}_{$date} --compression=gzip"
	)->twiceDaily(13, 21);
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
