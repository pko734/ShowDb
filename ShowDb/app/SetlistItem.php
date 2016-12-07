<?php

namespace ShowDb;

use Illuminate\Database\Eloquent\Model;

class SetlistItem extends Model
{
    public function show() {
        return $this->belongsTo('App\Show');
    }

    public function song() {
        return $this->belongsTo('App\Song');
    }

    public function creator() {
        return $this->belongsTo('App\User');
    }
}
