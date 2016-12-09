<?php

use Illuminate\Database\Seeder;

use Carbon\Carbon;

class SongsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $songs = file( __DIR__ . '/../../resources/seeds/songs.txt' );
        foreach( $songs as $song ) {
            $song = trim( $song );
            if( DB::table('songs')
                ->where('title', '=', $song)
                ->exists() === false ) {

                DB::table('songs')->insert([
                    'title' => $song,
                    'creator_id' => 1,
                    'created_at' =>  Carbon::now()->toDateTimeString(),
                    'updated_at' =>  Carbon::now()->toDateTimeString(),
                ]);
            }
        }
    }
}
