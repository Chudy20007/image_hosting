<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AlbumRating extends Model
{
    protected $fillable = [
        'album_id',
        'user_id',
        'created_at',
        'updated_at',
        'is_active',
        'rate'
    ];

    public function album()
    {
        return $this->belongsTo('App\Album','album_id','id');
    }

    public function user()
    {
        return $this->belongsTo('App\User','user_id','id');
    }
}
