<?php

namespace ShowDb;

use Illuminate\Database\Eloquent\Model;

class Show extends Model
{
    public function setlistItems() {
        return $this->hasMany('ShowDb\SetlistItem');
    }

    public function notes() {
        return $this->hasMany('ShowDb\ShowNote');
    }

}
