<?php

namespace App\Http\Controllers;
use App\AlbumRating;
use Illuminate\Http\Request;

class AlbumRatingController extends Controller
{
    public function store_rate()
    {
        $data=json_decode(file_get_contents('php://input'),true);
        $check =AlbumRating::where('album_id',$data['picture_id'])->where('user_id',$data['user_id'])->first();

        if (count($check)>0) 
        {
        $check->update([
            'album_id' => $data['picture_id'],
            'user_id' => $data['user_id'],
            'rate' => $data['picture_rate'],
            'is_active' => $data['is_active'],
            'updated_at' => date('Y-m-d H:i:s'),

        ]);
        }
            else
            {
                $rate=[
                    'album_id' => $data['picture_id'],
                    'user_id' => $data['user_id'],
                    'rate' => $data['picture_rate'],
                    'is_active' => $data['is_active'],
                    'updated_at' => date('Y-m-d H:i:s'),
                    'created_at' => date('Y-m-d H:i:s')
                    
                ];

            AlbumRating::insert($rate);
            }
            return json_encode("<div class='row alert alert-success card text-center'><b>Album has been rated!</b></div>");
 
    }
}
