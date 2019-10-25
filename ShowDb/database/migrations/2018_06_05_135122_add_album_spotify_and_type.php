<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAlbumSpotifyAndType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('albums', function ($table) {
            $table->string('spotify_link')->nullable();
            $table->enum('type', ['studio', 'live'])->default('studio');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('albums', function ($table) {
            $table->dropColumn('spotify_link');
            $table->dropColumn('type');
        });
    }
}
