<?php

namespace App;

use Auth;
use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    protected $fillable = [
        'title',
        'title_photo',
        'visibility',
        'updated_at',
        'active_comments',
        'active_ratings',
        'created_at',
        'upload_link',
        'description',
    ];

    public function visitors()
    {
        return $this->hasMany('App\AlbumVisitor', 'album_id', 'id')->where('user_id','=',Auth::id());
    }
    public function albums()
    {
        return $this->belongsToMany('App\Picture', 'id')->withTimestamps();
    }

    public function picture()
    {
        return $this->hasMany('App\AlbumPicture', 'album_id');
    }
    public function comment()
    {
        return $this->hasMany('App\AlbumComment', 'album_id');
    }
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
    public function album_user_rate()
    {
        return $this->hasOne('App\AlbumRating')->where('user_id', '=', Auth::id());
    }

    public function user_rate()
    {
        return $this->hasMany('App\AlbumRating')->where('user_id', '=', Auth::id());
    }

    public function album()
    {
        return $this->withTimestamps();
    }
    public function average_rating()
    {

        return round($this->hasMany('App\AlbumRating')->where('album_id', '=', $this->id)->where('is_active', '=', true)->avg('rate'), 2);

    }

    public function getCommentsCount()
    {
        return $this->hasMany('App\AlbumComment')->where('album_id', '=', $this->id);
    }
}
