<?php

namespace ShowDb\Console\Commands;

use Illuminate\Console\Command;
use ShowDb\Show;

class SetlistFm extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:setlistfm';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Play with setlistfm stuff';

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
        $shows = Show::whereNull('user_id')
            ->orderBy('date', 'asc')->get();

        foreach ($shows as $show) {
            $encore = 0;
            foreach ($show->setlistItems->sortBy('order') as $item) {
                if ($item->encore) {
                    $encore = 1;
                }
                if (! $item->encore && $encore) {
                    echo "found untagged encore: {$show->date} {$item->song->title}\n";
                    $item->encore = 1;
                    $item->save();
                }
            }
        }

        /*
        foreach (glob("/var/www/html/ShowDb/ShowDb/tmp/*.txt") as $filename) {
            $json = json_decode(file_get_contents($filename));

            foreach($json as $obj) {
                $date = explode('-', $obj->eventDate);
                $date = "{$date[2]}-{$date[1]}-{$date[0]}";
                echo $date, "\n";
                $shows = Show::where('date', '=', $date)->get();
                foreach($shows as $show) {
                    if(! $show) {
                        echo "Could not find a show on date: {$date}\n";
                        exit;
                    }
                    $items = $show->setlistItems->sortBy('order');
                    $encore_count = count($obj->encoreSongs->song);
                    foreach($obj->encoreSongs->song as $song) {
                        $found_item = null;
                        foreach($items as $item) {
                            echo $item->song->title, "\n";
                            if($this->_songConvert1($item->song->title) == strtolower($song->name)) {
                                $found_item = $item;
                                break;
                            }
                        }
                        if($found_item === null) {
                            if(count($items) > 5) {
                                echo "Could not find song: $song->name - setlistfm dumb? ($date)\n";
                            }
                            continue;
                        }
                        if($found_item->order < count($items) - $encore_count) {
                            echo "Encore count mismatch: $song->name, $date\n";
                            continue;
                        }
                        $year = substr($date, 0, 4);
                        if($year == 2018 || $year == 2017 || $year == 2016 || $year == 2015) {
                            $item->encore = 1;
                            $item->save();
                        } else {
                            echo "                   Want to set '{$song->name} on '{$date}' to ENCORE!\n";
                        }
                    }
                }
                echo "\n";
            }
        }
        */
    }

    private function _songConvert1($title)
    {
        if ($title == 'Paranoia in Bb Major') {
            $title = 'Paranoia in B-Flat Major';
        }
        if ($title == 'Pretty Girl From Here') {
            $title = 'Pretty Girl From (Instrumental)';
        }
        if ($title == 'Froggy Went A Courtin\'') {
            $title = 'Frog Went A-Courting';
        }
        if ($title == 'Old Joe Clark (Traditional Cover)') {
            $title = 'Old Joe Clark';
        }
        if ($title == 'How Sweet It Is (To Be Loved By You) (Holland-Dozier-Holland Cover)') {
            return strtolower('How Sweet It Is (To Be Loved by You)');
        }
        $title = strtolower($title);
        $title = preg_replace('/\(.*cover.*\)/i', '', $title);
        echo $title, "\n";

        return trim($title);
    }
}
