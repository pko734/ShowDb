<?php

namespace ShowDb\Console\Commands;

use Illuminate\Console\Command;
use ShowDb\User;
use ShowDb\ShowImage;
use ShowDb\ShowNote;
use ShowDb\Show;
use ShowDb\SetlistItemNote;
use DB;

class TriviaGenerate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:trivia-generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Trivia Generate';

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
        $songs = Song::whereNotNull('snipUrl');
    }
}
