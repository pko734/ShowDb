<?php

namespace ShowDb;

use Illuminate\Database\Eloquent\Model;

class TriviaQuestion extends Model
{
    public function creator()
    {
        return $this->belongsTo(\ShowDb\User::class, 'user_id');
    }
}
