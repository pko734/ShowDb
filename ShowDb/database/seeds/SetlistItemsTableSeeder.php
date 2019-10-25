<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use ShowDb\Show;
use ShowDb\Song;

class SetlistItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $lines = file(__DIR__.'/../../resources/seeds/setlistdb6.txt');
        $show_id = -1;
        $j = 1;

        for ($i = 0; $i < count($lines); $i++) {
            $line = $lines[$i];
            if (trim($line) === '') {
                continue;
            }

            if (strpos($line, "\t")) {
                $show_id = $this->findShow($line);
                $j = 1;
                continue;
            }

            $song_id = $this->findSong($line);

            if (DB::table('setlist_items')
                ->where('show_id', '=', $show_id)
                ->where('song_id', '=', $song_id)
                ->exists() === false) {
                $tline = trim($line);
                echo "Seeding: show_id: {$show_id} song_id: {$song_id} order: {$j} [{$tline}]\n";
                DB::table('setlist_items')->insert([
                    'show_id'    => $show_id,
                    'song_id'    => $song_id,
                    'creator_id' => '1',
                    'order'      => $j++,
                ]);
            }
        }
    }

    private function findShow(&$line)
    {
        $parts = explode("\t", $line);
        $date = $this->fix_date($parts[0]);
        $venue = trim($parts[2]).' - '.$parts[1];
        $show_id = Show::where('venue', '=', $venue)
                 ->where('date', '=', $date)
                 ->value('id');
        if ($show_id === null) {
            echo "Could not find show: $line";
            readline();
        }

        return $show_id;
    }

    private function findSong(&$line)
    {
        $song = trim($line);
        while (($song_id = Song::where('title', '=', $song)->value('id')) === null) {
            if (isset($this->lookup_table[$song])) {
                $song = $this->lookup_table[$song];
                continue;
            }
            echo "Could not find song: [$song]: ";
            $fix = readline();
            if ($fix === '') {
                Song::create([
                    'title' => $song,
                    'creator_id' => '1',
                ]);
                continue;
            }
            if ($fix !== $song) {
                $this->lookup_table[$song] = $fix;
            }
            $song = $fix;
        }
        $line = $song."\n";

        return $song_id;
    }

    private function fix_date($date_str)
    {
        $result = str_replace('//', '/', $date_str);
        $result = str_replace('.', '', $result);
        $result = str_replace('/?/', '/', $result);

        try {
            if (substr_count($result, '/') === 1) {
                $result = Carbon::createFromFormat('m/y', $result)->format('Y-m-00');
            } else {
                $result = Carbon::createFromFormat('m/d/y', $result)->format('Y-m-d');
            }
        } catch (Exception $e) {
            echo "Invalid date: {$result}\n";
            throw $e;
        }

        return $result;
    }
}
