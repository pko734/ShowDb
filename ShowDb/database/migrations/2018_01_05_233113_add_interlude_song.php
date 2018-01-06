<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddInterludeSong extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('setlist_items', function($table) {
	    $table->integer('interlude_song_id')->unsigned()->nullable()->default(null);
	    $table->foreign('interlude_song_id')
                ->references('id')
                ->on('songs');
	});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('setlist_items', function (Blueprint $table) {
            $table->dropColumn('interlude_song_id');
        });
    }
}
