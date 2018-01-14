<?php

namespace ShowDb;

use Illuminate\Database\Eloquent\Model;

use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class SetlistItem extends Model implements AuditableContract
{

    use Auditable;

    public $timestamps = false;

    public function show() {
        return $this->belongsTo('ShowDb\Show');
    }

    public function song() {
        return $this->belongsTo('ShowDb\Song');
    }

    public function interludeSong() {
        return $this->belongsTo('ShowDb\Song');
    }

    public function creator() {
        return $this->belongsTo('ShowDb\User');
    }

    public function notes() {
        return $this->hasMany('ShowDb\SetlistItemNote');
    }
}
