<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTimelineTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('timeline_slides', function (Blueprint $table) {
                $table->increments('id');
                $table->enum('type', ['title','era','slide'])->default('slide');
                $table->date('start_date')->nullable();
                $table->time('start_time')->nullable();
                $table->date('end_date')->nullable();
                $table->time('end_time')->nullable();
                $table->string('text_headline')->nullable();
                $table->text('text_text')->nullable();
                $table->string('media_url')->nullable();
                $table->string('media_caption')->nullable();
                $table->string('media_credit')->nullable();
                $table->string('media_thumbnail_url')->nullable();
                $table->string('media_link')->nullable();
                $table->string('link_target')->nullable();
                $table->string('group')->nullable();
                $table->integer('creator_id')
                    ->references('id')
                    ->on('users');
                $table->timestamps();
                $table->boolean('published')->default(false);
                
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('timeline_slides');
    }
}
