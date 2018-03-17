<?php

namespace App\Http\Controllers;

use App\ImageRating;

class ImageRatingController extends Controller
{
    public function store_rate()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $check = ImageRating::where('picture_id', $data['picture_id'])->where('user_id', $data['user_id'])->where('is_active', true)->first();

        if ($check !== null) {
            $check->update([
                'picture_id' => $data['picture_id'],
                'user_id' => $data['user_id'],
                'rate' => $data['picture_rate'],
                'is_active' => $data['is_active'],
                'updated_at' => date('Y-m-d H:i:s'),

            ]);
        } else {
            $rate = [
                'picture_id' => $data['picture_id'],
                'user_id' => $data['user_id'],
                'rate' => $data['picture_rate'],
                'is_active' => $data['is_active'],
                'updated_at' => date('Y-m-d H:i:s'),
                'created_at' => date('Y-m-d H:i:s'),
            ];
            ImageRating::insert($rate);

        }
        return json_encode("<div class='row alert alert-success card text-center'><b>Picture has been rated!</b></div>");

    }

    public function edit_rate()
    {
        return "A";
    }
}
