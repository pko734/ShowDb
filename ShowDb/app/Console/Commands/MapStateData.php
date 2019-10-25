<?php

namespace ShowDb\Console\Commands;

use Illuminate\Console\Command;
use ShowDb\Show;
use ShowDb\State;

class MapStateData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:map-state-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Populate show state location data';

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
        $shows = Show::whereNull('state_id')->whereNull('user_id')->get();
        foreach ($shows as $Show) {
            if (preg_match('/, ([A-Z][A-Z])[\s]*$/', $Show->venue, $matches) !== 0) {
                //	       echo $Show->venue, " [{$matches[1]}]", "\n";
                $State = State::where('iso_3166_2', '=', $matches[1])->first();
                if ($State !== null) {
                    echo $Show->venue, ' [', $State->name, "]\n";
                    $Show->state_id = $State->id;
                    $Show->save();
                } else {
                    echo "COULD NOT FIND STATE: {$Show->venue}", "\n";
                }
            } else {
                echo $Show->venue, " [UNKNOWN] {$Show->id}", "\n";
            }
        }
    }
}
