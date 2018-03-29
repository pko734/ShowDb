<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class StateBadges extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $states = DB::table('states')
            ->select('iso_3166_2 as code', 'country_code', 'name')
            ->get();

	foreach($states as $state) {
	var_export($state);
	    DB::table('badges')->insert([
		array(
		    'title' => "{$state->name}",
		    'code' => "STATE_{$state->code}_{$state->country_code}",
		    'image_url' => "/img/badges/TAB_State_{$state->code}_{$state->country_code}_90h.png",
		    'description' => "Has seen the band in {$state->name}"
		)
	    ]);
	}
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('badges')->where('code', 'LIKE', 'STATE_%');
    }
}
