<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Http\Requests\CreateCommentRequest;
use App\Picture;
use App\AlbumComment;
use Auth;
use Request;
use Session;

class CommentsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['only' => 'edit']);
    }
    public function index()
    {
        $pictures = Picture::latest()->get();
        return view('pictures.index')->with('pictures', $pictures);
    }

    public function create($id)
    {
        

            $comments_enabled = Picture::select('active_comments')->where('id', $id)->get();
           
            $user = Auth::user();
            if (count($comments_enabled)>0)
            {
                if ($comments_enabled[0]->active_comments == 0 || $user == null) {
                        return view("user.access_denied");
                    }

                $hiddenValues = array();
                $hiddenValues['user_id'] = $user->id;
                $hiddenValues['picture_id'] = $id;

            
                if ($user != null ) {
                    return view("comments.create")->with('hiddenValues', $hiddenValues);
                }
            }
            else
            return view('user.access_denied');

        
    }
    public function album_comment_create($id)
    {
        $user = Auth::id();
        $hiddenValues = array();
        $hiddenValues['user_id'] = $user;
        $hiddenValues['picture_id'] = $id;
        return view ('comments.create_album_comment')->with('hiddenValues',$hiddenValues);
    }
    public function random_str($length, $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')
    {
        $str = '';
        $max = mb_strlen($keyspace, '8bit') - 1;
        for ($i = 0; $i < $length; ++$i) {
            $str .= $keyspace[random_int(0, $max)];
        }
        return $str;
    }
    public function store_com(CreateCommentRequest $request)
    {
        $datas = Request::all();
        $comD=array();
        $comD['album_id'] = $datas['picture_id'];
        $comD['user_id'] = $datas ['user_id'];
        $comD['comment'] = $datas['comment'];
        $com = AlbumComment::create($comD);

        Auth::user()->album_comments()->save($com);

        Session::flash('status', 'Comment to the album added!');
        return redirect("albums/".$comD['album_id']);
    }

    public function store(CreateCommentRequest $request)
    {
        $datas = Request::all();
        $id = $datas['picture_id'];
        $com = Comment::create($datas);

        Auth::user()->comments()->save($com);

        Session::flash('status', 'Comment added!');
        return redirect("pictures/$id");
    }

    public function edit($id)
    {   $comment = Comment::findOrFail($id);

        if ($comment->user_id == $id || Auth::user()->isAdmin())
        return view('comments.edit')->with('hiddenValues', $comment);
        else
        return view("user.access_denied"); 
    }
      
    public function album_com_update($id, CreateCommentRequest $request)
    {
        $datas = Request::all();
        $com = AlbumComment::findOrFail($id);
        $com->update([
            'comment' => $datas['comment'],
        ], $request->all());
        Session::flash('album_created', 'Comment updated!');
        return redirect('albums');
    }

    public function album_com_edit($id)
    {   $comment = AlbumComment::findOrFail($id);
        $comment['picture_id']=0;
        if ($comment->user_id ==Auth::id() || Auth::user()->isAdmin())
        return view('comments.album_com_edit')->with('hiddenValues', $comment);
        else
        return view("user.access_denied"); 
    }

    public function activate($id)
    {
        Comment::where('id',$id)->where('is_active',false)->update([
            'is_active' => true
           ]);

      
        switch(Auth::user()->isAdmin())
        {
            case true:
            {
                Session::flash('comment_updated', 'Comment has been activated!');
                return redirect("comments_list");
            }
            case false:
            {
                Session::flash('account_updated', 'Comment has been activated!');
                return view('pictures.index');
            }

            default:
            {
                return view('pictures.index'); 
            }
        }  
    }
    public function destroy($id)
    { 
   
        Comment::where('id',$id)->where('is_active',true)->update([
            'is_active' => false
           ]);

      
        switch(Auth::user()->isAdmin())
        {
            case true:
            {
                Session::flash('comment_updated', 'Comment has been disactivated!');
                return redirect("comments_list");
            }
            case false:
            {
                Session::flash('comment_updated', 'Comment has been disactivated!');
                return view('comments_list');
            }

            default:
            {
                return view('pictures.index'); 
            }
        }
    }
    public function create_comment()
    {
        return view('pictures.create_comment');
    }

    public function update($id, CreateCommentRequest $request)
    {
        $datas = Request::all();
        $com = Comment::findOrFail($id);
        $com->update([
            'comment' => $datas['comment'],
        ], $request->all());
        Session::flash('status', 'Comment updated!');
        return redirect('pictures');
    }
}
