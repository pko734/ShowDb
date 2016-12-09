<?php

namespace ShowDb;

use Illuminate\Database\Eloquent\Model;

class SetlistItem extends Model
{
    public function show() {
        return $this->belongsTo('ShowDb\Show');
    }

    public function song() {
        return $this->belongsTo('ShowDb\Song');
    }

    public function creator() {
        return $this->belongsTo('ShowDb\User');
    }
}
