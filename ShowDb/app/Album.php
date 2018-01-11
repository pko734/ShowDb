<?php

namespace ShowDb;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class Album extends Model implements AuditableContract
{
    use Auditable;

    public function albumItems() {
        return $this->hasMany('ShowDb\AlbumItem');
    }

    public function notes() {
        return $this->hasMany('ShowDb\AlbumNote');
    }
}
