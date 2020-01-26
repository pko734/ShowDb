<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DeletePosterFix extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('merch_show', function (Blueprint $table) {
            $table->dropForeign('merch_show_merch_id_foreign');
            $table->foreign('merch_id')
                ->references('id')->on('merches')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('merch_show', function (Blueprint $table) {
            //
        });
    }
}
