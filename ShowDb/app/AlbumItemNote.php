<?php

namespace ShowDb;

use Illuminate\Database\Eloquent\Model;

class AlbumItemNote extends Model
{
    public function albumItem()
    {
        return $this->belongsTo(\ShowDb\AlbumItem::class);
    }

    public function creator()
    {
        return $this->belongsTo(\ShowDb\User::class);
    }
}
