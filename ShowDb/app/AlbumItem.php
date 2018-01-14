<?php

namespace ShowDb;

use Illuminate\Database\Eloquent\Model;

use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class AlbumItem extends Model implements AuditableContract
{
    use Auditable;

    public $timestamps = false;

    public function album() {
        return $this->belongsTo('ShowDb\Album');
    }

    public function song() {
        return $this->belongsTo('ShowDb\Song');
    }

    public function creator() {
        return $this->belongsTo('ShowDb\User');
    }

    public function notes() {
        return $this->hasMany('ShowDb\AlbumItemNote');
    }
}
