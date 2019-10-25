<?php

namespace ShowDb;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    public function show()
    {
        return $this->hasMany('ShowDb\Show');
    }
}
