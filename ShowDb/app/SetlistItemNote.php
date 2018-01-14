<?php

namespace ShowDb;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class SetlistItemNote extends Model implements AuditableContract
{
    use Auditable;

    public function setlistItem() {
        return $this->belongsTo('ShowDb\SetlistItem');
    }

    public function user() {
        return $this->belongsTo('ShowDb\User');
    }

    public function creator() {
        return $this->belongsTo('ShowDb\User');
    }
}
