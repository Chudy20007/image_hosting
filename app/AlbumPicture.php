<?php

namespace App;
use Auth;
use Illuminate\Database\Eloquent\Model;

class AlbumPicture extends Model
{
    protected $fillable = [
        'picture_id',
        'album_id',
        'created_at',
        'updated_at',
        'is_active'
    ];

    public function album ()
    {
        return $this->belongsTo('App\Album','album_id')->withTimestamps();
    }

    public function picture()
    {
        return $this->belongsTo('App\Picture','picture_id','id');
    }

    public function user_rate()
    {
return $this->hasOne('App\ImageRating')->where('user_id','=',Auth::id());
    }
    

}
