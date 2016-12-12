<?php

use Illuminate\Database\Seeder;

class SetlistItemNotesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $csv = array_map('str_getcsv', file(__DIR__ . '/../../resources/seeds/setlist_item_notes.csv'));

        foreach($csv as $entry) {
            DB::table('setlist_item_notes')->insert([
                'setlist_item_id' => $entry[0],
                'user_id'         => $entry[1],
                'note'            => $entry[2],
                'published'       => $entry[3],
                'type'            => $entry[4],
                'creator_id'      => $entry[5],
                'order'           => $entry[6],
            ]);
        }

    }
}
