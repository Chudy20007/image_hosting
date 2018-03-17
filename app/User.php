<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Auth;
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'is_active'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token'
    ];

    public function pictures()
    {
        return $this->hasMany('App\Picture','user_id');
    }

    public function albums()
    {
        return $this->hasMany('App\Album','user_id');
    }

    public function albums_picture()
    {
        return $this->hasMany('App\AlbumPicture')->withTimestamps();
    }

    public function comments()
    {
        return $this->hasMany('App\Comment','user_id');
    }
public function comment()
{
    return $this->belongsTo('App\User','id');
}
    public function album_comments()
    {
        return $this->hasMany('App\AlbumComment');
    }
    public function isAdmin()
    {
        return $this->is_admin; // this looks for an admin column in your users table
    }

    public function users_rate()
    {
        return $this->hasMany('App\ImageRating','picture_id','id');
    }

    public function user_rate()
    {
        return $this->hasOne('App\ImageRating')->where('user_id','=',Auth::id())->where('is_active','=',true);
    }

    public function getEmail()
    {
        return $this->email();
    }
}
