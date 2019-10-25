<?php

namespace ShowDb;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'name', 'email', 'password', 'admin', 'avatar', 'fb_id', 'username', 'share',
    ];

    protected $dates = ['deleted_at'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function isAdmin()
    {
        return $this->admin;
    }

    public function shows()
    {
        return $this->belongsToMany('ShowDb\Show');
    }

    public function images()
    {
        return $this->hasMany('ShowDb\ShowImage');
    }

    public function badges()
    {
        return $this->belongsToMany('ShowDb\Badge');
    }
}
