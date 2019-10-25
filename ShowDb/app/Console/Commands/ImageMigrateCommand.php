<?php

namespace ShowDb\Console\Commands;

use Illuminate\Console\Command;
use ShowDb\ShowNote;

class ImageMigrateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:image-migrate';

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
        $notes = ShowNote::all();
        foreach ($notes as $note) {
            if (strpos($note->note, '<img src="http://') !== false) {
                preg_match_all('/<img src="(.*?)"/', $note->note, $matches);
                $old = $matches[1][0];
                if (strpos($old, 'asmylifeturns')) {
                    continue;
                }
                $new = "/images/{$note->id}.".pathinfo(parse_url($old, PHP_URL_PATH), PATHINFO_EXTENSION);
                $cmd = "wget $old -O ".public_path().$new;

                exec($cmd);

                $replaced = str_replace($old, $new, $note->note);
                echo $replaced."\n";
                //$note->note = $replaced;
          //$note->save();

          //echo "\n";
              //var_export($matches[1][0]); echo "\n";
            }
        }
    }
}
