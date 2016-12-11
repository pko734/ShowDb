<?php

namespace ShowDb;

use Illuminate\Database\Eloquent\Model;

use OwenIt\Auditing\Auditable;

class Song extends Model
{

    use Auditable;

    public function creator() {
        return $this->belongsTo('ShowDb\User');
    }

    public function setlistItems() {
        return $this->hasMany('ShowDb\SetlistItem');
    }

    public function notes() {
        return $this->hasMany('ShowDb\SongNote');
    }
}
