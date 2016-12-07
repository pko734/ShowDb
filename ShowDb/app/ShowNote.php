<?php

namespace ShowDb;

use Illuminate\Database\Eloquent\Model;

class ShowNote extends Model
{
    public function show() {
        return $this->belongsTo('App\Show');
    }

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function creator() {
        return $this->belongsTo('App\User');
    }
}
