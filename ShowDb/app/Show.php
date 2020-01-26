<?php

namespace ShowDb;

use Illuminate\Database\Eloquent\Model;

class Show extends Model
{
    public function posters()
    {
        return $this->belongsToMany(\ShowDb\Merch::class)->where('merches.category', '=', 'posters');
    }

    public function setlistItems()
    {
        return $this->hasMany(\ShowDb\SetlistItem::class);
    }

    public function setlistItemsNotes()
    {
        return $this->hasManyThrough(\ShowDb\SetlistItemNote::class, \ShowDb\SetlistItem::class);
    }

    public function notes()
    {
        return $this->hasMany(\ShowDb\ShowNote::class);
    }

    public function images()
    {
        return $this->hasMany(\ShowDb\ShowImage::class);
    }

    public function users()
    {
        return $this->belongsToMany(\ShowDb\User::class);
    }

    public function creator()
    {
        return $this->belongsTo(\ShowDb\User::class, 'user_id');
    }

    public function state()
    {
        return $this->belongsTo(\ShowDb\State::class);
    }

    public function getShowDisplay()
    {
        return "{$this->date} {$this->venue}";
    }
}
