<?php

namespace ShowDb;

use Illuminate\Database\Eloquent\Model;

class ShowNote extends Model
{
    public function show()
    {
        return $this->belongsTo(\ShowDb\Show::class);
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
