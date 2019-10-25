<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeNotesBigger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \DB::statement('ALTER TABLE `show_notes` CHANGE `note` `note` MEDIUMTEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL');
        \DB::statement('ALTER TABLE `song_notes` CHANGE `note` `note` MEDIUMTEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \DB::statement('ALTER TABLE `show_notes` CHANGE `note` `note` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL');
        \DB::statement('ALTER TABLE `song_notes` CHANGE `note` `note` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL');
    }
}
