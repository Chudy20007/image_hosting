<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateAccountRequest;
use App\Picture;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Request;
use Session;

class UserController extends Controller
{
    public function user_panel()
    {
        $pictures = Picture::with('user_rate')->where('pictures.user_id', '=', Auth::id())->where('pictures.is_active','=',true)->latest()->get();
        return view("user.user_panel")->with('pictures', $pictures);
    }
    public function albums_panel()
    {
        $albums = Picture::with('user')
        ->leftjoin('users', 'pictures.user_id', '=', 'users.id')
        ->leftjoin('albums', 'albums.user_id', '=', 'users.id')
        ->leftjoin('album_pictures','albums.id','=','album_id')
        ->leftjoin('album_ratings','album_ratings.user_id','=','users.id')
        ->where('albums.is_active', '=', true)
        ->where('albums.user_id', '=', Auth::id())
        ->groupBy('album_pictures.album_id')
        ->orderBy('albums.updated_at', 'desc')
        
        ->get(['albums.id','albums.active_ratings','album_ratings.is_active AS active_rates','album_ratings.rate','albums.title','albums.title_photo', 'albums.user_id','users.name', 'albums.visited_count', 'album_pictures.picture_id','pictures.source','albums.active_comments','albums.description']);

        if($albums->isEmpty())
        return view('pictures.not_found');  
        return view('user.albums_panel')->with('albums', $albums);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->update([
            'is_active' => false,
        ]);
    }

    public function redirectToView($view)
    {

    }


    public function show($id)
    {

        switch (Auth::id()==$id || Auth::user()->isAdmin())
        {
        case 1:
        {       
        $shares = Picture::with('comment.user','user','user_rate')
            
            ->where('pictures.user_id', '=', $id)
            ->where('pictures.is_active', '=', true)
            ->orderBy('pictures.updated_at', 'desc')
            ->get();
            if (count($shares)==0)
            {
            $shares = User::where('id',$id)->with('user_rate')->get();
            return view('user.show_profile_only')->with('pictures', $shares);
            }
            else
            return view('user.show_profile')->with('pictures', $shares);
        }
            case 0:
            {
                $shares = Picture::with('comment.user','user','user_rate')
                
                ->where('pictures.user_id', '=', $id)
                ->where('pictures.is_active', '=', true)
                ->where ('pictures.visibility','=','public')
                ->orderBy('pictures.updated_at', 'desc')
                ->get();
               
                if (count($shares)==0)
                {
                $shares = User::where('id',$id)->with('user_rate')->get();
                return view('user.show_profile_only')->with('pictures', $shares);
                }
                else
                return view('user.show_profile')->with('pictures', $shares);
            }

            
        } 
          
           
        
    }

  /*  public function edit()
    {
        $user = Auth::user();

        if ($user == null) {
            return view("user.access_denied");
        } else {
            return view("user.edit")->with('user', $user);
        }

    }
    public function update(UpdateAccountRequest $request)
    {
        $user = Auth::user();
        $files = Input::file('file');

        if ($files != null) {
            $files->move('C:\xampp\htdocs\web\image_hosting\public\css\img\avatars', $user->id . ".jpg");
        }

        $user->name = Request::input('name');
        $user->email = Request::input('email');

        if (!Request::input('password') == '') {
            $user->password = bcrypt(Request::input('password'));
        }

        $user->save();

        Session::flash('account_updated', 'Account has been updated!');
        return redirect("user_panel");
    }
 */
}
