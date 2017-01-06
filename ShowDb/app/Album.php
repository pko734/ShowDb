<?php

namespace ShowDb;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable;

class Album extends Model
{
    use Auditable;

    public function albumItems() {
        return $this->hasMany('ShowDb\AlbumItem');
    }

    public function notes() {
        return $this->hasMany('ShowDb\AlbumNote');
    }
}
