<?php

namespace ShowDb;

use Illuminate\Database\Eloquent\Model;

class Artist extends Model
{
    public function posters()
    {
        return $this->belongsToMany(\ShowDb\Merch::class)->where('merches.category', '=', 'posters');
    }

    public function merch()
    {
        return $this->belongsToMany(\ShowDb\Merch::class);
    }
}
