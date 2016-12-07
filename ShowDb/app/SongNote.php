<?php

namespace ShowDb;

use Illuminate\Database\Eloquent\Model;

class SongNote extends Model
{
    public function song() {
        return $this->belongsTo('App\Song');
    }

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function creator() {
        return $this->belongsTo('App\User');
    }
}
