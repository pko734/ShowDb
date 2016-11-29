<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShowNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('show_notes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('show_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->text('note');
            $table->boolean('published');
            $table->enum('type', ['public', 'private']);
            $table->integer('created_by')->unsigned();
            $table->timestamps();
            $table->integer('order')->unsigned();

            $table->foreign('show_id')
                ->references('id')
                ->on('shows')
                ->onDelete('cascade')
                ->oUpdate('cascade');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('created_by')
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
        Schema::drop('show_notes');
    }
}
