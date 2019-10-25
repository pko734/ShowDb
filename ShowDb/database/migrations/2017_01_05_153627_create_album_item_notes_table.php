<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlbumItemNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('album_item_notes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('album_item_id')->unsigned();
            $table->mediumText('note');
            $table->boolean('published');
            $table->enum('type', ['public', 'private']);
            $table->integer('creator_id')->unsigned();
            $table->timestamps();
            $table->integer('order')->unsigned();

            $table->foreign('album_item_id')
                ->references('id')
                ->on('album_items')
                ->onDelete('cascade')
                ->oUpdate('cascade');

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
        Schema::drop('album_item_notes');
    }
}
