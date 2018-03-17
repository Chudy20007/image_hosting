<?php

namespace App;

use App\Http\Comment;
use Auth;
use Illuminate\Database\Eloquent\Model;

class Picture extends Model
{
    protected $guarded = ['_token'];
    protected $fillable = [
        'title',
        'description',
        'source',
        'user_id',
        'picture_rate',
        'picture_id',
        'visibility',
        'uploadLink',
        'is_active',
        'active_comments',

    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
    public function alb_pict()
    {
        return $this->belongsTo('App\AlbumPicture', 'picture_id');
    }
    public function albums()
    {
        return $this->belongsToMany('App\Album')->withTimestamps();
    }

    public function user_rate()
    {
        return $this->hasOne('App\ImageRating')->where('user_id', '=', Auth::id())->where('is_active', '=', true);
    }

    public function users_rate()
    {
        return $this->hasMany('App\ImageRating', 'picture_id', 'id');
    }

    public function comment()
    {
        return $this->hasMany('App\Comment');
    }
    public function average_rating()
    {

        return round($this->hasMany('App\ImageRating')->where('picture_id', '=', $this->id)->where('is_active', '=', true)->avg('rate'), 2);

    }

    public function album_average_rating()
    {

        return round($this->hasMany('App\AlbumRating')->where('album_id', '=', $this->id)->avg('rate'), 2);

    }

    public function alb_comment()
    {
        return $this->belongsTo('App\AlbumComment');
    }

    public function getCommentsCount()
    {
        return $this->hasMany('App\Comment')->where('picture_id', '<=', $this->id);
    }

}
