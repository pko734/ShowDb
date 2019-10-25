<?php

namespace ShowDb\Console\Commands;

use Illuminate\Console\Command;
use ShowDb\Show;

class MarkEmptySetlists extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:mark-empty-setlists';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $shows = Show::has('setlistItems', '=', 0)->get();
        foreach ($shows as $show) {
            if (strpos($show->date, '2017') !== false) {
                $show->incomplete_setlist = false;
                $show->save();
            }
        }
    }
}
