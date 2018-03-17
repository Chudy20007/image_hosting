<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AlbumComment extends Model
{
    protected $fillable = [
        'comment',
        'user_id',
        'album_id',
        'is_active'
    ];

    public function comment()
    {
        return $this->belongsTo('App\Album');
    }

    public function user()
    {
        return $this ->belongsTo('App\User','user_id');
    }
}
