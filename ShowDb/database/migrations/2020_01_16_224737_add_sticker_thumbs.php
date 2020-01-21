<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStickerThumbs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stickers', function (Blueprint $table) {
            $table->string('thumbnail_url');
            $table->string('group');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stickers', function (Blueprint $table) {
            $table->dropColumn('thumbnail_url');
            $table->dropColumn('group');
        });
    }
}
