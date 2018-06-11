<?php

namespace ShowDb;

use Illuminate\Database\Eloquent\Model;

class Show extends Model
{

    public function setlistItems() {
        return $this->hasMany('ShowDb\SetlistItem');
    }

    public function setlistItemsNotes() {
    	return $this->hasManyThrough('ShowDb\SetlistItemNote', 'ShowDb\SetlistItem');
    }

    public function notes() {
        return $this->hasMany('ShowDb\ShowNote');
    }

    public function images() {
        return $this->hasMany('ShowDb\ShowImage');
    }

    public function users() {
        return $this->belongsToMany('ShowDb\User');
    }

    public function creator() {
        return $this->belongsTo('ShowDb\User', 'user_id');
    }

    public function state() {
        return $this->belongsTo('ShowDb\State');
    }

    public function getShowDisplay() {
        return "{$this->date} {$this->venue}";
    }

}
