<?php

namespace ShowDb;

use Illuminate\Database\Eloquent\Model;

class SongNote extends Model
{
    public function song()
    {
        return $this->belongsTo(\ShowDb\Song::class);
    }

    public function user()
    {
        return $this->belongsTo(\ShowDb\User::class);
    }

    public function creator()
    {
        return $this->belongsTo(\ShowDb\User::class);
    }
}
