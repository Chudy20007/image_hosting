<?php

namespace App\Http\Controllers;

use App\Album;
use App\AlbumComment;
use App\AlbumRating;
use App\Comment;
use App\Http\Requests\UpdateAccountRequest;
use App\ImageRating;
use App\Picture;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Request;
use Session;

class AdminController extends Controller
{
    public function edit($id)
    {

        $user2 = User::findOrFail($id);
        if ($user2->id == Auth::id() || Auth::user()->isAdmin()) {
            return view("user.edit")->with('user', $user2);
        } else {
            return view("user.access_denied");
        }

    }

    public function create()
    {
        return view('user.create');
    }

    public function destroy_all()
    {
        dd(Request::all());
    }
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->id == Auth::id()) {
            return ($this->usersList()->with(Session::flash('account_updated', 'You can not disable your account!')));
        }

        if ($user->is_active == 0) {
            Picture::where('user_id', $id)->update([
                'is_active' => false,
            ]);
            $user->update([
                'is_active' => false,
            ]);
            return ($this->usersList()->with(Session::flash('account_updated', 'Account has been disabled!')));
        } else {
            Picture::where('user_id', $id)->update([
                'is_active' => false,
            ]);
            $user->update([
                'is_active' => false,
            ]);

        }

        return ($this->usersList()->with(Session::flash('account_updated', 'Account has been disabled!')));
    }

    public function album_comment_activate($id)
    {
        $album_comment = AlbumComment::findOrFail($id);

        if ($album_comment->is_active == 0) {
            $album_comment->update([
                'is_active' => true,
            ]);
        }

        return redirect("album_comments_list")->with(Session::flash('comment_updated', 'Comment has been activated!'));
    }
    public function album_comment_destroy($id)
    {
        $album_comment = AlbumComment::findOrFail($id);

        if ($album_comment->is_active == 1) {
            $album_comment->update([
                'is_active' => false,
            ]);
        }

        return redirect("album_comments_list")->with(Session::flash('comment_updated', 'Comment has been disabled!'));
    }

    public function activate_rate($id)
    {
        $img_rate = ImageRating::findOrFail($id);

        if ($img_rate->is_active == 0) {
            $img_rate->update([
                'is_active' => true,
            ]);
        }

        return redirect("pictures_ratings_list")->with(Session::flash('rate_updated', 'Rate has been activated!'));
    }
    public function destroy_rate($id)
    {
        $img_rate = ImageRating::findOrFail($id);

        if ($img_rate->is_active == 1) {
            $img_rate->update([
                'is_active' => false,
            ]);
        }

        return redirect("pictures_ratings_list")->with(Session::flash('rate_updated', 'Rate has been disabled!'));
    }

    public function activate_album_rate($id)
    {
        $img_rate = AlbumRating::findOrFail($id);

        if ($img_rate->is_active == 0) {
            $img_rate->update([
                'is_active' => true,
            ]);
        }

        return redirect("albums_ratings_list")->with(Session::flash('rate_updated', 'Rate has been activated!'));
    }
    public function destroy_album_rate($id)
    {
        $img_rate = AlbumRating::findOrFail($id);

        if ($img_rate->is_active == 1) {
            $img_rate->update([
                'is_active' => false,
            ]);
        }

        return redirect("albums_ratings_list")->with(Session::flash('rate_updated', 'Rate has been disabled!'));
    }
    public function activate($id)
    {
        User::where('id', $id)->where('is_active', false)->update([
            'is_active' => true,
        ]);

        switch (Auth::user()->isAdmin()) {
            case true:
                {
                    Session::flash('account_updated', 'Comment has been activated!');
                    return redirect("album_comments_list");
                }
            case false:
                {
                    Session::flash('account_updated', 'Account has been activated!');
                    return view('pictures.index');
                }

            default:
                {
                    return view('pictures.index');
                }
        }
    }

    public function album_comments_list()
    {

        switch ($user = Auth::user()->isAdmin()) {
            case true:
                { $comments = Album::with('user')
                        ->leftjoin('album_comments', 'album_comments.album_id', '=', 'albums.id')
                        ->leftjoin('users', 'album_comments.user_id', '=', 'users.id')
                        ->groupBy('album_comments.id')
                        ->get(['users.name', 'album_comments.updated_at', 'albums.title', 'album_comments.id', 'albums.visited_count', 'albums.active_comments', 'album_comments.created_at', 'albums.id AS album_id', 'album_comments.comment', 'albums.is_active', 'album_comments.is_active', 'albums.title_photo']);

                    return view('admin.album_comments_list')->with('comments', $comments);

                }
            case false:
                return view('user.access_denied');

            default:
                return view('user.access_denied');
        }

    }

    public function albums_ratings_list()
    {

        switch ($user = Auth::user()->isAdmin()) {
            case true:
                { $ratings = AlbumRating::with('user', 'album')
                        ->groupBy('album_ratings.id')
                        ->latest()
                        ->get();

                    return view('admin.albums_ratings_list')->with('ratings', $ratings);

                }
            case false:
                return view('user.access_denied');

            default:
                return view('user.access_denied');
        }
    }

    public function pictures_ratings_list()
    {

        switch ($user = Auth::user()->isAdmin()) {
            case true:
                { $ratings = ImageRating::with('user','picture')
                        ->groupBy('image_ratings.id')
                        ->latest()
                        ->get();

                    return view('admin.pictures_ratings_list')->with('ratings', $ratings);

                }
            case false:
                return view('user.access_denied');

            default:
                return view('user.access_denied');
        }
    }
    public function comments_list()
    {

        switch ($user = Auth::user()->isAdmin()) {
            case true:
                { $comments = Comment::with('user', 'picture')

                        ->distinct()
                        ->groupBy('comments.id')
                        ->orderBy('comments.id', 'desc')
                        ->get();

                    return view('admin.comments_list')->with('comments', $comments);

                }
            case false:
                return view('user.access_denied');

            default:
                return view('user.access_denied');
        }

    }
    public function store(UpdateAccountRequest $request)
    {$datas = Request::all();
        if (User::where('email', '=', $datas['email']) != null) {
            Session::flash('account_updated', 'Email are exist!');
            return redirect("users_list");
        }

        $files = Input::file('file');

        $user = new User([

            'name' => $datas['name'],
            'password' => bcrypt($datas['password']),
            'email' => $datas['email'],
            'is_active' => $datas['active'],
            'is_admin' => $datas['privileges'],

        ], $request->all());
        $user->save();
        if ($files != null) {
            $files->move('C:\xampp\htdocs\web\image_hosting\public\css\img\avatars', $user->id . ".jpg");
        }

        Session::flash('account_updated', 'Account has been created!');
        return redirect("users_list");
    }

    public function update(UpdateAccountRequest $request)
    {

        $user = User::findOrFail($request['user_id']);

        $files = Input::file('file');

        if ($files != null) {
            $files->move('C:\xampp\htdocs\web\image_hosting\public\css\img\avatars', $user->id . ".jpg");
        }

        $user->name = Request::input('name');
        $user->email = Request::input('email');
        Request::input('privileges') == 1 ? $user->is_admin = true : $user->is_admin = false;
        Request::input('active') == 1 ? $user->is_active = true : $user->is_active = false;
        $user->updated_at = now();

        if (!Request::input('password') == '') {
            $user->password = bcrypt(Request::input('password'));
        }

        $user->save();

        Session::flash('account_updated', 'Account has been updated!');
        if (Auth::user()->isAdmin()) {
            return redirect("users_list");
        } else {
            return redirect("user_panel");
        }

    }
    public function pictures_list()
    {

        switch ($user = Auth::user()->isAdmin()) {
            case true:
                { $pictures = Picture::with('user')
                        ->join('users', 'pictures.user_id', '=', 'users.id')
                        ->distinct()
                        ->orderBy('pictures.id', 'desc')
                        ->get(['users.name', 'pictures.updated_at', 'pictures.title', 'pictures.source', 'pictures.id', 'pictures.user_id', 'pictures.visited_count', 'pictures.active_comments', 'pictures.created_at', 'pictures.description', 'pictures.is_active', 'pictures.visibility']);

                    return view('admin.pictures_list')->with('pictures', $pictures);

                }
            case false:
                return view('user.access_denied');

            default:
                return view('user.access_denied');
        }

    }

    public function usersList()
    {

        switch ($user = Auth::user()->isAdmin()) {
            case true:
                {
                    $users = User::select('name', 'email', 'created_at', 'updated_at', 'id', 'is_admin', 'is_active')->get();

                    return view('admin.users_list')->with('users', $users);

                }
            case false:
                return view('user.access_denied');

            default:
                return view('user.access_denied');
        }

    }

    public function admin_panel()
    {
        switch ($user = Auth::user()->isAdmin()) {
            case true:
                return view('admin.admin_panel')->with('user', $user);
            case false:
                return view('user.access_denied');

            default:
                return view('user.access_denied');
        }
    }

    public function albums_list()
    {
        if (Auth::user()->isAdmin()) {
            $albums = Picture::with('user')

                ->leftjoin('users', 'pictures.user_id', '=', 'users.id')
                ->leftjoin('albums', 'albums.user_id', '=', 'users.id')
                ->leftjoin('album_pictures', 'albums.id', '=', 'album_id')
                ->leftjoin('album_ratings', 'album_ratings.user_id', '=', 'users.id')
                ->groupBy('album_pictures.album_id')
                ->orderBy('albums.updated_at', 'desc')

                ->get(['albums.id', 'albums.is_active', 'albums.active_ratings', 'album_ratings.is_active AS active_rates', 'album_ratings.rate', 'albums.title', 'albums.title_photo', 'albums.user_id', 'users.name', 'albums.visited_count', 'album_pictures.picture_id', 'pictures.source', 'albums.active_comments', 'albums.description']);

            if ($albums->isEmpty()) {
                return view('pictures.not_found');
            }

            return view('admin.albums_list')->with('albums', $albums);
        }
    }

    public function activate_album($id)
    {
        $album = ImageRating::findOrFail($id);

        if ($album->is_active == 0) {
            $album->update([
                'is_active' => true,
            ]);
        }

        return redirect("albums_list_a")->with(Session::flash('comment_updated', 'Album has been activated!'));
    }
    public function destroy_album($id)
    {
        $album = Album::findOrFail($id);

        if ($album->is_active == 1) {
            $album->update([
                'is_active' => false,
            ]);
        }

        return redirect("albums_list_a")->with(Session::flash('comment_updated', 'Album has been disabled!'));
    }

    public function album_edit($id)
    {

    }

}
