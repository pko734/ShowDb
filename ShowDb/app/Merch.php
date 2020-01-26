<?php

namespace ShowDb;

use Illuminate\Database\Eloquent\Model;

class Merch extends Model
{
    public function artists()
    {
        return $this->belongsToMany(\ShowDb\Artist::class);
    }

    public function shows()
    {
        return $this->belongsToMany(\ShowDb\Show::class);
    }

}
