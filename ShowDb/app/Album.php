<?php

namespace ShowDb;

use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    public function albumItems() {
        return $this->hasMany('ShowDb\AlbumItem');
    }

    public function notes() {
        return $this->hasMany('ShowDb\AlbumNote');
    }
}
