<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlbumItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('album_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('album_id')->unsigned();
            $table->integer('song_id')->unsigned();
            $table->integer('creator_id')->unsigned();
            $table->integer('order')->unsigned();

            $table->foreign('album_id')
                ->references('id')
                ->on('albums')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('song_id')
                ->references('id')
                ->on('songs')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('creator_id')
                ->references('id')
                ->on('users');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('album_items');
    }
}
