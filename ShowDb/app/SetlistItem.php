<?php

namespace ShowDb;

use Illuminate\Database\Eloquent\Model;

use OwenIt\Auditing\Auditable;

class SetlistItem extends Model
{

    use Auditable;

    public $timestamps = false;

    public function show() {
        return $this->belongsTo('ShowDb\Show');
    }

    public function song() {
        return $this->belongsTo('ShowDb\Song');
    }

    public function creator() {
        return $this->belongsTo('ShowDb\User');
    }
}
