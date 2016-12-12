<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(ShowsTableSeeder::class);
        $this->call(SongsTableSeeder::class);
        $this->call(SetlistItemsTableSeeder::class);
        $this->call(SetlistItemNotesTableSeeder::class);
        $this->call(ShowNotesTableSeeder::class);
    }
}
