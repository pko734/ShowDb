<?php

namespace ShowDb\Console\Commands;

use DateTime;
use Illuminate\Console\Command;
use ShowDb\Show;
use ShowDb\ShowNote;
use ShowDb\Merch;
use ShowDb\Artist;
use Image;

class PosterExtracter extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:poster-extract';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Tries to pull poster data out of notes and into merch';

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
        $notes = ShowNote::where('note', 'LIKE', '%<img %>')->get();
        $todo = 0;
        foreach($notes as $note) {
            if( $note->show->id == 1219) {
                continue;
            }
            if( $note->show->id == 662) {
                continue;
            }
            $note->note = str_replace("\n", "", $note->note);
            if(preg_match('#<img src="(.*?)"(?:.*)>(?:.*)(?:<p>)?Poster by(?:&nbsp;| )<a href="(.*?)">(.*?)</a>(?:</p>)?#', $note->note, $matches) === 1) {
                $this->_process1($note, $matches);
            } else if(preg_match('#<img src="(.*?)">(?:(?:<p>)?<br></p>)?$#', $note->note, $matches2) === 1) {
                $this->_process2($note, $matches2);
            } else if(preg_match('#<p><strong>Poster by (.*) - Size (.*) - Run (.*)</strong></p><img src="(.*?)">#', $note->note, $matches3) === 1) {
                $map = [1 => $matches3[4], 2 => '', 3 => $matches3[1]];
                $this->_process1($note, $map);
            } else if(preg_match('#Poster by(?:&nbsp;| )<a href="(.*?)">(.*?)</a>(?:</p>)?<img src="(.*?)">#', $note->note, $matches4) === 1) {
                $map = [1 => $matches4[3], 2 => $matches4[1], 3 => $matches4[2]];
                $this->_process1($note, $map);
            } else if(preg_match('#<p>Poster by (.*?)(?:&nbsp;)?</p><img src="(.*?)">#', $note->note, $matches5) === 1) {
                $map = [1 => $matches5[2], 2 => '', 3 => $matches5[1]];
                $this->_process1($note, $map);
            } else if(preg_match('#<img src="(.*?)"(?:.*?)?>(?:.*?)?(?:<p>)?Poster [b,B]y(?:&nbsp;| )(.*?)</p>#', $note->note, $matches6) === 1) {
                $map = [1 => $matches6[1], 2 => '', 3 => $matches6[2]];
                $this->_process1($note, $map);
            } else if(preg_match('#^<img src="(.*?)">(?:<br>)?$#', $note->note, $matches7) === 1) {
                $this->_process2($note, $matches7);
            } else {
                echo $note->show->id, "\n";
                $todo++;
            }
        }
        echo "TODO: $todo\n";

        /*
        foreach($notes as $note) {
            if(preg_match('#<img src="(.*)"><p>Poster by <a href="(.*)">(.*)</a></p>#', $note->note, $matches) === 1) {
                $this->_process1($note, $matches);
            }
        }
        */
    }

    private function _base64ToFile($img_src, $note) {
        if(($x = preg_match('#^data:(.*);base64,(.*)$#', $img_src, $matches)) === 1) {
            $file = base64_decode($matches[2]);
            $url = '/storage/merch/posters/note_' . $note->id . '.' . basename($matches[1]);
            $file_path = public_path($url);
            file_put_contents($file_path, $file);
            //echo "$file_path\n$url\n";
            return $url;
        } else {
            $file = base64_decode(substr($img_src, strpos($img_src, ',')));
            $url = '/storage/merch/posters/note_' . $note->id . '.' . 'jpeg';
            $file_path = public_path($url);
            file_put_contents($file_path, $file);
            //echo "$file_path\n$url\n";
            return $url;
        }
        echo $img_src, "\n";
        echo "BOOOOOOOOOOOOO\n";
        exit;
    }

    private function _process2($note, $matches) {
        $img_src = $matches[1];
        $this->_doImage($img_src, $note);
    }

    private function _process1($note, $matches) {
        $img_src = $matches[1];
        $artist_url = $matches[2];
        $artist_name = $matches[3];
        $artist = Artist::where('name', '=', $artist_name)->first();
        if(!$artist && $artist_url) {
            $artist = Artist::where('url', '=', $artist_url)->first();
        }
        if(!$artist) {
            $artist = new Artist();
            $artist->name = $artist_name;
            $artist->url = $artist_url;
            $artist->save();
        }
        $this->_doImage($img_src, $note, $artist);
    }

    private function _doImage($img_src, $note, $artist = null) {
        if(strpos($img_src, ';base64,') !== false) {
            $img_src = $this->_base64ToFile($img_src, $note);
        }
        $img_file = public_path($img_src);
        $s_thumb = public_path('storage/merch/posters/thumbnail/s_' . basename($img_file));
        $m_thumb = public_path('storage/merch/posters/thumbnail/m_' . basename($img_file));
        $l_thumb = public_path('storage/merch/posters/thumbnail/l_' . basename($img_file));
        $big_file = public_path('storage/merch/posters/' . basename($img_file));
        if(is_file($l_thumb)) {
            return;
        }
        copy($img_file, $s_thumb);
        copy($img_file, $m_thumb);
        copy($img_file, $l_thumb);
        copy($img_file, $big_file);
        $this->createThumbnail($s_thumb, 150);
        $this->createThumbnail($m_thumb, 300);
        $this->createThumbnail($l_thumb, 600);

        $url = '/storage/merch/posters/' . basename($img_file);
        $t_url = '/storage/merch/posters/thumbnail/s_' . basename($img_file);

        $merch = Merch::where('url', '=', $url)->get()->first();
        if(!$merch) {
            $merch = new Merch();
        }
        $merch->year = substr($note->show->date, 0, 4);
        $merch->category = 'posters';
        $merch->url = $url;
        $merch->thumbnail_url = $t_url;
        $merch->dimensions = '';
        $merch->description = '';
        $merch->notes = '';
        $merch->group = 'The Avett Brothers';
        $merch->name = '';
        $merch->artist = $artist ? $artist->name : '';
        $merch->save();

        if(!$note->show->posters->contains($merch->id)) {
            $note->show->posters()->attach($merch->id);
        }

        if($artist) {
            if(!$artist->posters->contains($merch->id)) {
                $artist->posters()->attach($merch->id);
            }
        }
        echo $merch->toJson(), "\n";

    }

    /**
     * Create a thumbnail of specified size
     *
     * @param string $path path of thumbnail
     * @param int $width
     * @param int $height
     */
    public function createThumbnail($path, $width, $height = null)
    {
        $img = Image::make($path)->resize($width, $height, function ($constraint) {
            $constraint->aspectRatio();
        });
        $img->save($path);
    }

}
