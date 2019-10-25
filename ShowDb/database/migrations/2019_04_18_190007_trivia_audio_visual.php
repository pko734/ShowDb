<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TriviaAudioVisual extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('trivia_questions', function ($table) {
            $table->string('audioUrl')->nullable();
            $table->string('imageUrl')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('trivia_questions', function ($table) {
            $table->dropColumn('audioUrl');
        });
        Schema::table('trivia_questions', function ($table) {
            $table->dropColumn('imageUrl');
        });
    }
}
