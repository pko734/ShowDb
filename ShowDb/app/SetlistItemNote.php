<?php

namespace ShowDb;

use Illuminate\Database\Eloquent\Model;

class SetlistItemNote extends Model
{
    public function setlistItem() {
        return $this->belongsTo('App\SetlistItem');
    }

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function creator() {
        return $this->belongsTo('App\User');
    }
}
