<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'comment',
        'user_id',
        'picture_id',
        'is_active',
        'created_at',
        'updated_at',
    ];

    public function picture()
    {
        return $this->belongsTo('App\Picture', 'id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

}
