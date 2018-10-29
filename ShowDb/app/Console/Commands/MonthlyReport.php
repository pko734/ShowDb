<?php

namespace ShowDb\Console\Commands;

use Illuminate\Console\Command;
use ShowDb\User;
use ShowDb\ShowImage;
use ShowDb\ShowNote;
use ShowDb\Show;
use ShowDb\SetlistItemNote;
use DB;

class MonthlyReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:report';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Monthly Report';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $start = date('2018-10-01');
        $end = date('2018-11-01');

        $newshows = Show::whereDate('created_at', '>=', $start)
            ->whereDate('created_at', '<', $end);
        echo "New Shows: {$newshows->count()}\n";

        $newusers = User::whereDate('created_at', '>=', $start)
            ->whereDate('created_at', '<', $end);
        echo "New Users: {$newusers->count()}\n";

        $shownotes = ShowNote::whereDate('created_at', '>=', $start)
            ->whereDate('created_at', '<', $end);
        echo "New Show Notes: {$shownotes->count()}\n";

        $showimages = ShowImage::whereDate('created_at', '>=', $start)
            ->whereDate('created_at', '<', $end);
        echo "New Show Images: {$showimages->count()}\n";

        $newvideos = SetlistItemNote::whereDate('created_at', '>=', $start)
            ->whereDate('created_at', '<', $end);
        echo "New Videos: {$newvideos->count()}\n";


 
   }
}
