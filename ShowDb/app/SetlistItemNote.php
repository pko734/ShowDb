<?php

namespace ShowDb;

use Illuminate\Database\Eloquent\Model;

class SetlistItemNote extends Model
{
    public function setlistItem()
    {
        return $this->belongsTo('ShowDb\SetlistItem');
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
