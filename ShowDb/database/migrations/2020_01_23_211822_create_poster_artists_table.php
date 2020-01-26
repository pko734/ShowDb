<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePosterArtistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('artists', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('url')->nullable();
            $table->timestamps();
        });

        Schema::create('artist_merch', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('artist_id')->unsigned()->index();
            $table->bigInteger('merch_id')->unsigned()->index();

            $table->foreign('artist_id')->references('id')->on('artists');
            $table->foreign('merch_id')->references('id')->on('merches');
        });

        Schema::create('merch_show', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('show_id')->unsigned()->index();
            $table->bigInteger('merch_id')->unsigned()->index();

            $table->foreign('show_id')->references('id')->on('shows');
            $table->foreign('merch_id')->references('id')->on('merches');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('artists');
        Schema::dropIfExists('artist_merch');
        Schema::dropIfExists('merch_show');
    }
}
