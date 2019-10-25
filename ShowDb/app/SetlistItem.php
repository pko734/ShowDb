<?php

namespace ShowDb;

use Illuminate\Database\Eloquent\Model;

class SetlistItem extends Model
{
    public $timestamps = false;

    public function show()
    {
        return $this->belongsTo(\ShowDb\Show::class);
    }

    public function song()
    {
        return $this->belongsTo(\ShowDb\Song::class);
    }

    public function interludeSong()
    {
        return $this->belongsTo(\ShowDb\Song::class);
    }

    public function creator()
    {
        return $this->belongsTo(\ShowDb\User::class);
    }

    public function notes()
    {
        return $this->hasMany(\ShowDb\SetlistItemNote::class);
    }
}
