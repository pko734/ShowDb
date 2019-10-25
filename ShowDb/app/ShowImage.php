<?php

namespace ShowDb;

use Illuminate\Database\Eloquent\Model;

class ShowImage extends Model
{
    public function show()
    {
        return $this->belongsTo(\ShowDb\Show::class);
    }

    public function user()
    {
        return $this->belongsTo(\ShowDb\User::class);
    }
}
