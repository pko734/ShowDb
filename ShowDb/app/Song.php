<?php

namespace ShowDb;

use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    public function creator()
    {
        return $this->belongsTo(\ShowDb\User::class);
    }

    public function setlistItems()
    {
        return $this->hasMany(\ShowDb\SetlistItem::class);
    }

    public function albumItems()
    {
        return $this->hasMany(\ShowDb\AlbumItem::class);
    }

    public function notes()
    {
        return $this->hasMany(\ShowDb\SongNote::class);
    }

    public function shows()
    {
        return Show::join('setlist_items', 'shows.id', '=', 'setlist_items.show_id')
            ->where(function ($query) {
                $query->where('setlist_items.song_id', $this->id)
                      ->orWhere('setlist_items.interlude_song_id', $this->id);
            })
            ->whereNull('shows.user_id');
    }

    public function getShowCount()
    {
        return \DB::select("SELECT COUNT(*) AS cnt FROM setlist_items si, shows s WHERE s.id = si.show_id AND (si.song_id = {$this->id} OR si.interlude_song_id = {$this->id}) AND s.user_id IS NULL")[0]->cnt;
    }
}
