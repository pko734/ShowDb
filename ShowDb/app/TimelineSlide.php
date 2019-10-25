<?php

namespace ShowDb;

use Illuminate\Database\Eloquent\Model;

class TimelineSlide extends Model
{
    public function creator()
    {
        return $this->belongsTo('ShowDb\User');
    }
}
