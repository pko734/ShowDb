<?php

namespace ShowDb;

use Illuminate\Database\Eloquent\Model;

class ShowNote extends Model
{
    public function show()
    {
        return $this->belongsTo('ShowDb\Show');
    }

    public function user()
    {
        return $this->belongsTo('ShowDb\User');
    }

    public function creator()
    {
        return $this->belongsTo('ShowDb\User');
    }
}
