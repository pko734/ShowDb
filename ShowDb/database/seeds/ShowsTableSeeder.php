<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use ShowDb\Show;
use Symfony\Component\DomCrawler\Crawler;

class ShowsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $shows = array_map('str_getcsv', file(__DIR__.'/../../resources/seeds/shows.csv'));
        foreach ($shows as $show) {
            $venue = $show[1];
            $date = $show[2];
            if (DB::table('shows')
                ->where('venue', '=', $venue)
                ->where('date', '=', $date)
                ->exists() === false) {
                echo "Seeding: {$date} - {$venue}\n";
                DB::table('shows')->insert([
                    'venue' => $venue,
                    'date'  => $date,
                    'published' => 1,
                    'created_at' => Carbon::now()->toDateTimeString(),
                    'updated_at' => Carbon::now()->toDateTimeString(),
                ]);
            }
        }
        //$csv = array_map('str_getcsv', file('data.csv'));
//       $to_scrape = [
//           'http://www.asmylifeturnstoasong.com/tour-2/2002-2',
//           'http://www.asmylifeturnstoasong.com/tour-2/2003-2',
//           'http://www.asmylifeturnstoasong.com/tour-2/2004-2',
//           'http://www.asmylifeturnstoasong.com/tour-2/2005-2',
//           'http://www.asmylifeturnstoasong.com/tour-2/2006-2',
//           'http://www.asmylifeturnstoasong.com/tour-2/2007-2',
//           'http://www.asmylifeturnstoasong.com/tour-2/2008-2',
//           'http://www.asmylifeturnstoasong.com/tour-2/2009-2',
//           'http://www.asmylifeturnstoasong.com/tour-2/2010-2',
//           'http://www.asmylifeturnstoasong.com/tour-2/2011-2',
//           'http://www.asmylifeturnstoasong.com/tour-2/2012-2',
//           'http://www.asmylifeturnstoasong.com/tour-2/2013-2',
//           'http://www.asmylifeturnstoasong.com/tour-2/2014-tour',
//           'http://www.asmylifeturnstoasong.com/tour-2/2015-3',
//           'http://www.asmylifeturnstoasong.com/tour-2/2016-tour',
//       ];
//
//       foreach( $to_scrape as $url ) {
//           $this->scrape( $url );
//       }
    }

    private function scrape($url)
    {
        $crawler = Goutte::request('GET', $url);
        $data = [];
        $j = 0;
        $elements = $crawler->filter('.entry-content td');
        while (strpos($elements->getNode(0)->textContent, '/') === false) {
            $elements = $elements->slice(1);
        }

        for ($i = 0; $i < count($elements); $i++) {
            $el = $elements->getNode($i);
            if ($i % 3 === 0) {
                if (strpos($el->textContent, '/') === false) {
                    $i += 2;
                    continue;
                }
                $data[$j] = [];
                $data[$j] = array_merge($data[$j], ['date' => $this->fix_date($el->textContent)]);
            }
            if ($i % 3 === 1) {
                $data[$j] = array_merge($data[$j], ['venue' => trim($el->textContent)]);
            }
            if ($i % 3 === 2) {
                $data[$j] = array_merge($data[$j], ['venue' => trim($el->textContent).' - '.$data[$j]['venue']]);
                $j++;
            }
        }

        foreach ($data as $show) {
            if (DB::table('shows')
                ->where('venue', '=', $show['venue'])
                ->where('date', '=', $show['date'])
                ->exists() === false) {
                echo "Seeding: {$show['date']} - {$show['venue']}\n";

                DB::table('shows')->insert([
                    'venue' => $show['venue'],
                    'date'  => $show['date'],
                    'published' => 1,
                    'created_at' => Carbon::now()->toDateTimeString(),
                    'updated_at' => Carbon::now()->toDateTimeString(),
                ]);
            }
        }
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
