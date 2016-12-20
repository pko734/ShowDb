<?php

namespace ShowDb;

use Illuminate\Database\Eloquent\Model;

class Audit extends Model
{
    public function user() {
        return $this->belongsTo('ShowDb\User');
    }
}
