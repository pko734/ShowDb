<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPhotoBadges extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('badges')->insert([
            [
              'title' => 'Photos: 1',
              'code' => 'PHOTOS1',
              'image_url' => '/img/badges/photos-1+.png',
              'description' => 'Has uploaded between 1 and 4 photos',
            ],
            [
              'title' => 'Photos: 5',
              'code' => 'PHOTOS5',
              'image_url' => '/img/badges/photos-5+.png',
              'description' => 'Has uploaded between 5 and 9 photos',
            ],
            [
              'title' => 'Photos: 10',
              'code' => 'PHOTOS10',
              'image_url' => '/img/badges/photos-10+.png',
              'description' => 'Has uploaded between 10 and 19 photos',
            ],
            [
              'title' => 'Photos: 20',
              'code' => 'PHOTOS20',
              'image_url' => '/img/badges/photos-20+.png',
              'description' => 'Has uploaded between 20 and 29 photos',
            ],
            [
              'title' => 'Photos: 30',
              'code' => 'PHOTOS30',
              'image_url' => '/img/badges/photos-30+.png',
              'description' => 'Has uploaded between 30 and 49 photos',
            ],
            [
              'title' => 'Photos: 50',
              'code' => 'PHOTOS50',
              'image_url' => '/img/badges/photos-50+.png',
              'description' => 'Has uploaded more than 50 photos',
            ],

    ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('badges')->where('code', 'like', 'PHOTOS%')->delete();
    }
}
