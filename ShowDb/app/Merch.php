<?php

namespace ShowDb;

use Illuminate\Database\Eloquent\Model;

class Merch extends Model
{
    public function artists()
    {
        return $this->belongsToMany(\ShowDb\Artist::class);
    }

    public function shows()
    {
        return $this->belongsToMany(\ShowDb\Show::class);
    }

    public function users()
    {
        return $this->belongsToMany(\ShowDb\User::class);
    }

    public function userHas($user_id = null)
    {
        if(is_null($user_id)) {
            if( \Auth::user()) {
                $user_id = \Auth::user()->id;
            }
        }
        return $this->belongsToMany(\ShowDb\User::class)->where('mode', '=', 'has')->where('user_id', '=', $user_id);
    }

    public function userWants($user_id = null)
    {
        if(is_null($user_id)) {
            if( \Auth::user()) {
                $user_id = \Auth::user()->id;
            }
        }
        return $this->belongsToMany(\ShowDb\User::class)->where('mode', '=', 'want')->where('user_id', '=', $user_id);
    }

    public function title()
    {
        $title = '';
        if($this->name) {
            $title .= $this->name . ' - ';
        }
        if($this->description) {
            $title .= $this->description . ' - ';
        }
        if($this->artist) {
            $title .= $this->artist . ' - ';
        }
        if($this->category == 'posters') {
            if($this->shows()->first()->date) {
                $title .= $this->shows()->first()->getShowDisplay() . ' - ';
            }
        } else {
            if($this->year) {
                $title .= $this->year . ' - ';
            }
        }
        if($this->notes) {
            $title .= $this->notes . ' - ';
        }

        return rtrim($title, '- ');
    }
}
