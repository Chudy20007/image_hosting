<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ImageRating extends Model
{
    protected $fillable = [
        'picture_id',
        'user_id',
        'created_at',
        'updated_at',
        'is_active',
        'rate'
    ];

    public function picture()
    {
        return $this->belongsTo('App\Picture','picture_id','id');
    }

    public function user()
    {
        return $this->belongsTo('App\User','user_id','id');
    }



}
