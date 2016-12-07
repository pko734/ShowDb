<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSongNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('song_notes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('song_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->text('note');
            $table->boolean('published');
            $table->enum('type', ['public', 'private']);
            $table->integer('creator_id')->unsigned();
            $table->timestamps();
            $table->integer('order')->unsigned();

            $table->foreign('song_id')
                ->references('id')
                ->on('songs')
                ->onDelete('cascade')
                ->oUpdate('cascade');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('creator_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
       });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('song_notes');
    }
}
