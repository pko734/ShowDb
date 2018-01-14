<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddShowImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('show_images', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
	    $table->integer('show_id')->unsigned();
	    $table->string('caption')->nullable();
	    $table->string('photo_credit')->nullable();
            $table->string('url');
	    $table->string('path');
            $table->boolean('published')->default(0);
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users');

            $table->foreign('show_id')
                ->references('id')
                ->on('shows');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::drop('show_images');
    }
}
