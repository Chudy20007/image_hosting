<?php

namespace App\Http\Controllers;

class StaticPagesController extends Controller
{
    public function contact()
    {
        return view('static_views.contact');
    }

    public function home()
    {
        return redirect('pictures');
    }

    public function about()
    {
        return view('static_views.about');
    }

    public function get_job()
    {
        return view('static_views.get_job');
    }
}
