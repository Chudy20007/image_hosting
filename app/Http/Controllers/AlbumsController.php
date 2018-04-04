<?php

namespace App\Http\Controllers;

use App\Album;
use App\AlbumPicture;
use App\Http\Requests\CreateAlbumRequest;
use App\Picture;
use App\User;
use Auth;
use Carbon\Carbon;
use Request;
use Session;

class AlbumsController extends Controller
{
    public function create()
    {
        $pictures = Picture::latest()->where('pictures.user_id', '=', Auth::id())->get(['title', 'id', 'updated_at']);
        return view('albums.create')->with('pictures', $pictures);
    }

    public function edit_pic($id)
    {
        $user_id = Auth::id();
        $datas = Request::all();
        $album_id = $id;
        if (isset($datas['uploadLink'])) {$uniq = md5(uniqid(rand()));
            $uniq = substr($uniq, 0, 32) . $user_id;
            $uploadLink = $uniq;
        } else {
            $uploadLink = null;
        }

        Album::where('id', $album_id)->update([
            'visibility' => $datas['visibility'],
            'active_ratings' => $datas['active_ratings'],
            'upload_link' => $uploadLink,

        ]);
        if (isset($datas['pictures_id'])) {
            $pictures = $datas['pictures_id'];
        }

        if (isset($pictures) && count($pictures) > 1) {
            for ($i = 0; $i < count($pictures); $i++) {
                $picture[] = [

                    'picture_id' => $pictures[$i],
                    'album_id' => $album_id,
                    'is_active' => true,
                    'visibility' => $datas['visibility'],
                    "created_at" => Carbon::now(),
                    "updated_at" => Carbon::now(),
                ];

            }
            AlbumPicture::insert($picture);
        } else {
            if (!isset($pictures)) {
                return redirect('albums/' . $id . '/edit');
            }

            $album_picture = new AlbumPicture([
                'picture_id' => (int) $pictures[0],
                'album_id' => $album_id,
                'is_active' => true,
                'visibility' => $datas['visibility'],
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now(),
            ]);

            AlbumPicture::insert(['picture_id' => $album_picture['picture_id'], 'album_id' => $album_id, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        }
        Session::flash('pictures_created', 'Album edited!');
        if (Auth::user()->isAdmin()) {
            return redirect('albums_list_a');
        } else {
            return $this->show($id);
        }

    }
    public function edit($id)
    {
        if (!Auth::user()->isAdmin()) {
            $album = Album::findOrFail($id)
                ->join('album_pictures', 'albums.id', '=', 'album_pictures.album_id')
                ->join('pictures', 'pictures.id', '=', 'album_pictures.picture_id')
                ->where('pictures.user_id', '=', Auth::id())
                ->where('pictures.is_active', '=', true)
                ->where('albums.is_active', '=', true)
                ->where('albums.id', '=', $id)
                ->groupBy('pictures.id')
                ->orderBy('pictures.id', 'desc')
                ->get(['pictures.title AS pic_title', 'album_pictures.picture_id as pic_id', 'albums.title AS alb_title', 'albums.id AS alb_id']);
            if ($album->isEmpty()) {
                return view('pictures.not_found');
            }

            return view('albums.edit')->with('album', $album);
        } else {
            $album = Album::findOrFail($id)
                ->join('album_pictures', 'albums.id', '=', 'album_pictures.album_id')
                ->join('pictures', 'pictures.id', '=', 'album_pictures.picture_id')
                ->where('albums.id', '=', $id)
                ->groupBy('pictures.id')
                ->orderBy('pictures.id', 'desc')
                ->get(['pictures.title AS pic_title', 'album_pictures.picture_id as pic_id', 'albums.title AS alb_title', 'albums.id AS alb_id']);
            if ($album->isEmpty()) {
                return view('pictures.not_found');
            }

            return view('albums.edit')->with('album', $album);
        }
    }

    public function show_alb($uploadLink)
    {

        $shares = Album::with('comment.user', 'user', 'picture.picture')

            ->where('albums.upload_link', '=', $uploadLink)
            ->where('albums.is_active', '=', true)
            ->distinct()
            ->get();

        /*  $shares = Picture::with('user')

        ->leftjoin('album_pictures','pictures.id','=','album_pictures.picture_id')
        ->leftjoin('users', 'pictures.user_id', '=', 'users.id')
        ->leftjoin('albums', 'albums.user_id', '=', 'users.id')
        ->leftjoin('album_comments', 'album_comments.album_id', '=', 'albums.id')
        ->where('albums.upload_link','=',$uploadLink)
        ->where('album_pictures.album_id', '=',substr($uploadLink,0,1))
        ->where('album_pictures.is_active','=',true)
        ->where('albums.is_active','=',true)
        ->groupBy('album_pictures.id')
        ->orderBy('album_comments.updated_at','desc')
        ->get(['pictures.title AS pic_title','pictures.source','users.name AS usr_name','pictures.id','pictures.user_id AS usr_id','pictures.description AS pic_description','album_comments.comment AS album_comment','album_comments.is_active AS album_active_comments','album_comments.updated_at AS updated_at','album_comments.user_id AS com_user_id']);
        dd($shares[0]->user);

         */

        if ($shares->isEmpty()) {
            return view('pictures.not_found');
        }

        Album::where('upload_link', $uploadLink)->increment('albums.visited_count');

        return view('albums.show_pictures2')->with('pictures', $shares);
    }

    public function store(CreateAlbumRequest $request)
    {
        $user_id = Auth::id();

        $datas = Request::all();

        if (isset($datas['pictures_id'])) {
            $pictures = $datas['pictures_id'];
        }

        if (isset($datas['uploadLink'])) {$uniq = md5(uniqid(rand()));
            $uniq = substr($uniq, 0, 32) . $user_id;
            $uploadLink = $uniq;
        } else {
            $uploadLink = "null";
        }

        $album_id = Album::latest()->first()['id'];

        if ($album_id == null) {
            $album_id = 1;
        } else {
            $album_id = $album_id + 1;
        }

        $album = new Album([
            'user_id' => $user_id,
            'title' => $datas['title'],
            'title_photo' => "css\img\\" . $user_id . "\\" . $pictures[0] . '.jpg',
            'visibility' => $datas['visibility'],
            'is_active' => true,
            'description' => $datas['description'],
            'active_comments' => $datas['active_comments'],
            'active_ratings' => $datas['active_ratings'],
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
            'upload_link' => $album_id . $uploadLink,

        ], $request->all());
        Auth::user()->albums()->save($album);

        if (count($datas['pictures_id']) > 1) {
            for ($i = 0; $i < count($pictures); $i++) {
                $picture[] = [

                    'picture_id' => $pictures[$i],
                    'album_id' => $album_id,
                    'visibility' => $datas['visibility'],
                    "created_at" => Carbon::now(),
                    "updated_at" => Carbon::now(),
                ];

            }
            AlbumPicture::insert($picture);
        } else {
            $album_picture = new AlbumPicture([

                'picture_id' => (int) $pictures[0],
                'album_id' => $album_id,
                'visibility' => $datas['visibility'],
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now(),
            ]);

            AlbumPicture::insert(['picture_id' => $album_picture['picture_id'], 'album_id' => $album_id, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'visibility' => $datas['visibility']]);
        }

        Session::flash('album_created', 'Album created!');
        return $this->albums_list();
    }

    public function store_pic()
    {
        $datas = Request::all();
        $album_id = $datas['album_id'];
        $pictures = $datas['pictures_id'];
        for ($i = 0; $i < count($pictures); $i++) {
            $picture[] = [

                'picture_id' => $pictures[$i],
                'album_id' => $album_id,
                'is_active' => true,
                'visibility' => $datas['visibility'],
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now(),

            ];

        }
        AlbumPicture::insert($picture);

        Session::flash('album_created', 'Pictures added!');
        return $this->albums_list();

    }

    public function find_albums()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        if (Auth::user())
        {
            if (Auth::user()->isAdmin())
            {
                $shares = Album::with('comment.user', 'user', 'user_rate')
                  //  ->where('albums.user_id', '=', $data['user_id'])
                    ->where('albums.title', 'LIKE', '%' . $data['title'] . '%')
                    ->groupBy('albums.id')
                    ->get();
            }
            else {
                $shares = Album::with('comment.user', 'user', 'user_rate')
                    ->where('albums.is_active', '=', true)
                    ->where('albums.visibility', '=', 'public')
                    ->where('albums.title', 'LIKE', '%' . $data['title'] . '%')
                    ->groupBy('albums.id')
                    ->get();
            }
        } else {
            $shares = Album::with('comment.user', 'user', 'user_rate')
                ->where('albums.is_active', '=', true)
                ->where('albums.visibility', '=', 'public')
                ->where('albums.title', 'LIKE', '%' . $data['title'] . '%')
                ->groupBy('albums.id')
                ->get();
        }
        return json_encode($shares);

    }

    public function select_albums_user($id)
    {
        if (Auth::id() == $id) {
            $shares = Album::with('comment.user', 'user', 'user_rate')
                ->where('albums.is_active', '=', true)
                ->where('albums.user_id', '=', $id)
                ->groupBy('albums.id')
                ->get();

            if ($shares->isEmpty()) {
                $shares = User::where('id', $id)->with('user_rate')->get();
                Session::flash('pictures_created', 'Empty albums folder...');
                return view('user.show_profile_only')->with('pictures', $shares);
            }
            $shares[0]->comment = $shares[0]->comment->where('is_active', '=', true)->sortByDesc('updated_at');
            return view('albums.show_user_albums')->with('albums', $shares);
        } else {
            return view('user.access_denied');
        }

    }

    public function add_pictures($id)
    {

        $user_id = Auth::id();

        $pictures = Album::findOrFail($id)
            ->leftjoin('pictures', 'albums.user_id', '=', 'pictures.user_id')
            ->where('albums.is_active', '=', true)
            ->where('albums.user_id', '=', $user_id)
            ->where('albums.id', '=', $id)
            ->orderBy('albums.updated_at', 'desc')
            ->groupBy('pictures.title')
            ->get(['pictures.title AS pic_title', 'albums.id AS alb_id', 'albums.title AS alb_title', 'pictures.id as pic_id']);

        return view('albums.add_pictures')->with('pictures', $pictures);
    }
    public function destroy($id)
    {

        if (Auth::user()->isAdmin()) {

            Album::where('id', $id)
                ->update([
                    'is_active' => false,
                ]);
            AlbumPicture::where('album_id', $id)->update([
                'is_active' => false,
                "updated_at" => Carbon::now(),
            ]);

            return redirect('albums_list_a')->with(Session::flash('account_updated', 'Album has been disactivated!'));
        }
        if (!Auth::user()->isAdmin()) {
            $query = Album::where('id', $id)->where('user_id', Auth::id())
                ->update([
                    'is_active' => false,
                    "updated_at" => Carbon::now(),
                ]);
            if ($query) {
                AlbumPicture::where('album_id', $id)->update([
                    'is_active' => false,
                    "updated_at" => Carbon::now(),
                ]);
                return redirect('albums/user/' . Auth::id());
            }

        }

        return redirect('pictures');
    }

    public function activate($id)
    {

        if (Auth::user()->isAdmin()) {

            Album::where('id', $id)
                ->update([
                    'is_active' => true,
                ]);
            AlbumPicture::where('album_id', $id)->update([
                'is_active' => true,
                "updated_at" => Carbon::now(),
            ]);

            return redirect('albums_list_a')->with(Session::flash('account_updated', 'Album has been activated!'));
        }
        if (!Auth::user()->isAdmin()) {
            $query = Album::where('id', $id)->where('user_id', Auth::id())
                ->update([
                    'is_active' => true,
                    "updated_at" => Carbon::now(),
                ]);
            if ($query) {
                AlbumPicture::where('album_id', $id)->update([
                    'is_active' => true,
                    "updated_at" => Carbon::now(),
                ]);
                return redirect('albums/user/' . Auth::id());
            }

        }

        return redirect('albums');
    }
    public function show($id)
    {
        /*
        $pictures = Picture::with('user')

        ->leftjoin('album_pictures','pictures.id','=','album_pictures.picture_id')
        ->leftjoin('users', 'pictures.user_id', '=', 'users.id')
        ->leftjoin('albums', 'albums.user_id', '=', 'users.id')
        ->leftjoin('album_comments', 'album_comments.album_id', '=', 'albums.id')

        ->where('album_pictures.album_id', '=', $id)
        ->where('album_pictures.is_active','=',true)
        ->where('album_pictures.visibility','=','public')
        ->groupBy('album_pictures.id')
        ->orderBy('album_comments.updated_at','desc')
        ->get(['pictures.title AS pic_title','pictures.source','users.name AS usr_name','pictures.id','pictures.user_id AS usr_id','pictures.description AS pic_description','album_comments.comment AS album_comment','album_comments.is_active AS album_active_comments','album_comments.updated_at AS updated_at','album_comments.user_id AS com_user_id']);
         */$shares = Album::with('comment.user', 'user', 'picture.picture', 'picture.picture.user_rate')

            ->where('albums.id', '=', $id)
            ->where('albums.is_active', '=', true)
            ->distinct()
            ->get();

        if ($shares->isEmpty()) {
            return view('pictures.not_found');
        }

        $shares[0]->comment = $shares[0]->comment->where('is_active', '=', true)->sortByDesc('updated_at');
        Album::findOrFail($id)->increment('albums.visited_count');

        return view('albums.show_pictures2')->with('pictures', $shares);

    }

    public function albums_list()
    {
        $albums = Picture::with('user')

            ->leftjoin('users', 'pictures.user_id', '=', 'users.id')
            ->leftjoin('albums', 'albums.user_id', '=', 'users.id')
            ->leftjoin('album_pictures', 'albums.id', '=', 'album_id')
            ->leftjoin('album_ratings', 'album_ratings.user_id', '=', 'users.id')
            ->where('albums.is_active', '=', true)
            ->where('albums.visibility', '=', 'public')
            ->groupBy('album_pictures.album_id')
            ->orderBy('albums.updated_at', 'desc')

            ->get(['albums.id', 'albums.active_ratings', 'album_ratings.is_active AS active_rates', 'album_ratings.rate', 'albums.title', 'albums.title_photo', 'albums.user_id', 'users.name', 'albums.visited_count', 'album_pictures.picture_id', 'pictures.source', 'albums.active_comments', 'albums.description']);
        if ($albums->isEmpty()) {
            return view('pictures.not_found');
        }
      
        return view('albums.index')->with('albums', $albums);
    }

}
