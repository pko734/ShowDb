<?php

namespace ShowDb;

use Illuminate\Database\Eloquent\Model;

class AlbumNote extends Model
{
    public function album()
    {
        return $this->belongsTo(\ShowDb\Album::class);
    }

    public function creator()
    {
        return $this->belongsTo(\ShowDb\User::class);
    }
}
