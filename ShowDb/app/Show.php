<?php

namespace ShowDb;

use Illuminate\Database\Eloquent\Model;

class Show extends Model
{
    public function setlistItems() {
        return $this->hasMany('ShowDb\SetlistItem');
    }

}
