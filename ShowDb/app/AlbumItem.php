<?php

namespace ShowDb;

use Illuminate\Database\Eloquent\Model;

class AlbumItem extends Model
{
    public $timestamps = false;

    public function album()
    {
        return $this->belongsTo(\ShowDb\Album::class);
    }

    public function song()
    {
        return $this->belongsTo(\ShowDb\Song::class);
    }

    public function creator()
    {
        return $this->belongsTo(\ShowDb\User::class);
    }

    public function notes()
    {
        return $this->hasMany(\ShowDb\AlbumItemNote::class);
    }
}
