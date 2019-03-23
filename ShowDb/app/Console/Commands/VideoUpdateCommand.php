<?php

namespace ShowDb\Console\Commands;

use Illuminate\Console\Command;
use ShowDb\Show;
use ShowDb\Song;
use ShowDb\SetlistItem;
use ShowDb\SetlistItemNote;
use DateTime;

class VideoUpdateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:video-update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Tries to pull in youtube videos from dcrangerfan';

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
        $channelId = env('YOUTUBE_CHANNEL_ID');
        $apikey =    env('YOUTUBE_API_KEY');

        $page = '';
        $search = 'q=' . urlencode('') . '&';
        while(true) {
            $url = "https://www.googleapis.com/youtube/v3/search?{$search}{$page}key={$apikey}&channelId={$channelId}&order=date&part=snippet&maxResults=50";
            $x = json_decode( file_get_contents($url));
            $this->findVideos($x);
            if(isset($x->nextPageToken)) {
                $page = "pageToken={$x->nextPageToken}&";
            } else {
                break;
            }
        }
    }
    private $i = 0;
    private function findVideos($x) {
        foreach($x->items as $item) {
            $song_name = '';
            $show = '';
            $song = '';
            $setlist_item = '';
            $note = '';
            $date = '';

            $title = $item->snippet->title;

            if( stristr( $title, 'avett' ) === false ) {
                continue;
            }

            if( $item->id->kind !== 'youtube#video' ) {
                continue;
            }
            if( SetlistItemNote::where("note", 'LIKE', "%watch?v={$item->id->videoId}%")->count() > 0 ) {
                continue;
            }

            $title = str_replace('&quot;', '"', $title);
            $title = str_replace('&#39;', '\'', $title);
            $title = str_replace('Yard Sale', 'Yardsale', $title);

            $matches = [];
            preg_match('/[0-9]{1,2}\.[0-9]{1,2}\.[0-9]{2}/', $title, $matches);
            if(isset($matches[0])) {
                // dcrangerfan messed up the date of these videos.
                if($matches[0] === '05.16.16') {
                    $matches[0] = '05.15.16';
                }
                $date = DateTime::createFromFormat('m.d.y', $matches[0]);
            } else {
                $this->error("Could not find date in: $title\nhttps://youtube.com/watch?v={$item->id->videoId}");
                continue;
            }
            $matches = [];
            preg_match('/"(.*)"/i', $title, $matches);
            if(isset($matches[1])) {
                $song_name = $matches[1];
            } else {
                $this->error("Could not a song name in: $title\nhttps://youtube.com/watch?v={$item->id->videoId}");
                continue;
            }
        
            $show = Show::where('date',  '=', $date->format('Y-m-d'))
                  ->orderBy('id', 'desc')
                  ->first();
            $song = Song::where('title', 'LIKE', '%' . 
                                str_replace( '...', '', str_replace('The ', '', trim($song_name))) . '%')->first();
        
            if(!$show) {
                $this->error( "Could not find show for: $title\nhttps://youtube.com/watch?v={$item->id->videoId}");
                continue;
            }
        
            if(!$song) {
                $song = Song::where(\DB::raw('replace(replace(title,"\'", "" ), ",", "") LIKE \'' .  
                                             str_replace( ",", '', str_replace( "'", '', str_replace( '...', '', str_replace('The ', '', trim($song_name))))) . '%\''))->first();
            
            }
            if(!$song) {
                $this->error( "Could not find song for: $title\nhttps://youtube.com/watch?v={$item->id->videoId}");
                echo "help? ";
                $song_name = readline();
                if(trim($song_name) == "") {
                    continue;
                }
                $song = Song::where('title', 'LIKE', '%' . 
                                    str_replace( '...', '', str_replace('The ', '', trim($song_name))) . '%')->first();
                
                if(!$song) {
                    continue;
                }
            }
        
            $setlist_item = SetlistItem::where('show_id', '=', $show->id)
                          ->where('song_id', '=', $song->id)
                          ->first();
        
            if(!$setlist_item) {
                $this->error( "Could not setlist item for: $title '$song_name' '{$date->format('Y-m-d')}'\nhttps://youtube.com/watch?v={$item->id->videoId}");
                continue;
            }
        
            if( !SetlistItemNote::where('setlist_item_id', '=', $setlist_item->id)->first()) {
                $note = new SetlistItemNote();
                $note->note = "https://youtube.com/watch?v={$item->id->videoId}";
                $note->setlist_item_id = $setlist_item->id;
                $note->user_id = 1;
                $note->published = 0;
                $note->creator_id = 1;
                $note->order = 1;
                $note->save();
                $this->info( "Inserted video: https://youtube.com/watch?v={$item->id->videoId}\n$title");
            }
        }
    }
}
