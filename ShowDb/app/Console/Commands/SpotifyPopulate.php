<?php

namespace ShowDb\Console\Commands;

use Illuminate\Console\Command;

use ShowDb\Song;

class SpotifyPopulate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:spotify-songs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'populate spotify_links for songs';

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
        $songs = Song::whereNull('spotify_link')->orWhere('spotify_link', '=', '')->get();
        foreach($songs as $Song) {
            $result = [];
            $cmd = "curl -s -X \"GET\" \"https://api.spotify.com/v1/search?q=The%20Avett%20Brothers%20%22" . rawurlencode($Song->title) . "%22&type=track\" -H \"Accept: application/json\" -H \"Content-Type: application/json\" -H \"Authorization: Bearer BQCefaWiFmgtPKDDkuFc82_uPUxAy0sep9QG2NegtQUUk8aQRwcg0Y-h1hMW8TXI0o3Q05P5y5IrAlUltC-dBtY7O_uztwi0-jfVGtMshM5I96I1da-EG8Y_i5RhGNyaD5J_m5roWpfS\" | grep spotify | grep track | grep uri | head -n1 | awk '{print \$3}' | xargs echo";
            exec($cmd, $result, $retval);
            $info = trim($result[0]);
            if($info == '') {
                $cmd = "curl -s -X \"GET\" \"https://api.spotify.com/v1/search?q=The%20Avett%20Brothers%20%22" . rawurlencode(str_replace('The ', '', $Song->title)) . "%22&type=track\" -H \"Accept: application/json\" -H \"Content-Type: application/json\" -H \"Authorization: Bearer BQCefaWiFmgtPKDDkuFc82_uPUxAy0sep9QG2NegtQUUk8aQRwcg0Y-h1hMW8TXI0o3Q05P5y5IrAlUltC-dBtY7O_uztwi0-jfVGtMshM5I96I1da-EG8Y_i5RhGNyaD5J_m5roWpfS\" | grep spotify | grep track | grep uri | head -n1 | awk '{print \$3}' | xargs echo";
                $result = [];
                exec($cmd, $result, $retval);
                $info = trim($result[0]);
                if($info == '') {
                    echo "Could not find {$Song->title}, skipping...\n";
                    continue;
                }
            }
            $spotify_link = "<iframe src=\"https://open.spotify.com/embed?uri={$info}\" width=\"250px\" height=\"80px\" frameborder=\"0\" allowtransparency=\"true\" allow=\"encrypted-media\"></iframe>";
            $Song->spotify_link = $spotify_link;
            $Song->save();
            echo "Added {$Song->title}\n";
        }
    }
}
