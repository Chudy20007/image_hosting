<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePictureRequest;
use App\Picture;
use App\User;
use Cookie;
use Auth;
use Illuminate\Support\Facades\Input;
use Request;
use Session;

class PicturesController extends Controller
{

    public function __construct()
    {
    }
    public function index()
    {
        if(!isset($_COOKIE['user_id']) && Auth::user())
        setcookie("user_id", Auth::id(), time() + 8600);
        //$pictures = Picture::latest()->where('pictures.is_active', '=', true)->get();
        $pictures = Picture::with('user_rate')->where('pictures.visibility', '=', 'public')->where('pictures.is_active','=',true)->latest()->get();
       
        

        
  
        return view('pictures.index')->with('pictures', $pictures);
    }

    public function find_pictures()
    {
        if (Auth::user())
        {
        if (Auth::user()->isAdmin())
        {
        $data=json_decode(file_get_contents('php://input'),true);
        $shares = Picture::with('comment.user','user','user_rate')
    //    ->where('pictures.user_id','=',$data['user_id'])
        ->where('pictures.title','LIKE','%'.$data['title'].'%')
       ->groupBy('pictures.id')
        ->get();
        }
        else
        {
            $data=json_decode(file_get_contents('php://input'),true);
            $shares = Picture::with('comment.user','user','user_rate')
            ->where('pictures.is_active','=',true)
            ->where('pictures.visibility','=','public')
            ->where('pictures.title','LIKE','%'.$data['title'].'%')
            ->groupBy('pictures.id')
            ->get();
        }
        }
        else
        {
            $data=json_decode(file_get_contents('php://input'),true);
            $shares = Picture::with('comment.user','user','user_rate')
            ->where('pictures.is_active','=',true)
            ->where('pictures.visibility','=','public')
            ->where('pictures.title','LIKE','%'.$data['title'].'%')
            ->groupBy('pictures.id')
            ->get();
        }
       
            return json_encode($shares);
 
    }


        public function store_rate()
        {
           $data=json_decode(file_get_contents('php://input'),true);
            print_r($data);

             return '';
        }
    public function show($id)
    {

        switch (Auth::user()->isAdmin())
        {
             /*case false:
            {
        $shares = Picture::with('comment','user')
            ->join('comments', 'comments.picture_id', '=', 'pictures.id')
            ->join('users', 'comments.user_id', '=', 'users.id')
            ->where('comments.picture_id', '=', $id)
            ->where('comments.is_active', '=', true)
            ->where('pictures.is_active', '=', true)
            ->where('pictures.visibility', '=', 'public')
            ->distinct()
            ->orderBy('comments.updated_at', 'desc')
            ->get(['comments.comment', 'users.name', 'comments.created_at', 'comments.updated_at', 'pictures.title', 'pictures.source', 'pictures.id', 'comments.user_id', 'pictures.visited_count', 'pictures.active_comments']);
            }
*/
            case false:
            {
                $shares = Picture::with('comment.user','user','user_rate')
                ->where('pictures.id','=',$id)
                ->where('pictures.is_active','=',true)
                ->where('pictures.visibility','=','public')
                ->get(); 

                if($shares->isEmpty())
                return view('pictures.not_found');           
                $shares[0]->comment= $shares[0]->comment->where('is_active', '=', true)->sortByDesc('updated_at');
     
            }
            case true:
            {
                $shares = Picture::with('comment.user','user','user_rate')
                ->where('pictures.id','=',$id)
                ->where('pictures.is_active','=',true)
                ->get();      

               
                if($shares->isEmpty())
                return view('pictures.not_found');      
                $shares[0]->comment= $shares[0]->comment->where('is_active', '=', true)->sortByDesc('updated_at');
            }
        }

     
       /* if (count($shares) == 0) {$pic = array();
            $picture = Picture::findOrFail($id);
            if ($picture->visibility =='private' && Auth::user()->isAdmin()!=true)
            return $this->index();
            $pic[0] = $picture;
            $pic[0]->name=User::where('id',$pic[0]->user_id)->get(['users.name']);
            $picture->increment('pictures.visited_count');
    
            return view('pictures.show')->with('picture', (array) $pic);
        } else { $picture = Picture::findOrFail($id)->increment('pictures.visited_count');

        */
        $picture = Picture::findOrFail($id)->increment('pictures.visited_count');
   
         return view('pictures.show')->with('picture', $shares);
        
    }

    public function create()
    {
        return view('pictures.create');
    }

    public function store(CreatePictureRequest $request)
    {
        $user_id=Auth::id();
        $picture_id=Picture::latest()->first()['id'];
        if ($picture_id==null)
        $picture_id=0;
        $datas = Request::all();
        $files = Input::file('file');
        
        if (isset($datas['uploadLink']))
        {   $uniq = md5 (uniqid (rand()));
            $uniq = substr($uniq,0,32).$user_id;
            $uploadLink = $uniq;
        }
        else $uploadLink="null";
        foreach ($files as $file) {

            $picture_id=$picture_id+1;
            $source='css\img\\'.$user_id.'\\'.$picture_id.'.jpg';
          
            $datas['file'] = null;
            $datas['source'] = $source ;
        
            $picture[] =[
                'user_id' => $user_id,
                'title' => $datas['title'],
                'description' => $datas['description'],
                'source' => $source,
                'visibility' => $datas['visibility'],
                'active_ratings' => $datas['active_ratings'],
                'active_comments' => $datas['active_comments'],
                'updated_at' => date('Y-m-d H:i:s'),
                'created_at' => date('Y-m-d H:i:s'),
                'uploadLink' => $picture_id.$uploadLink
            ];
      

          
            
            $file->move('C:\xampp\htdocs\web\image_hosting\public\css\img\\'.$user_id,$picture_id.".jpg");
        }
        Picture::insert($picture);
        Session::flash('pictures_created', 'Files uploaded!');
        return view ("pictures.index")->with('pictures',Picture::latest()->get());
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
    public function edit($id)
    {
        
        $picture = Picture::findOrFail($id);
        if($picture==null)
        return view('pictures.not_found');  

        if (Auth::id() == $picture->user_id || Auth::user()->isAdmin())
        {
        Session::flash('account_updated', 'Picture has been updated!');
        return view('pictures.edit')->with('picture', $picture);
        }
        else
        return view("user.access_denied");  
    }
    public function create_comment()
    {
        return view('pictures.create_comment');
    }


    public function show_pic($uploadLink)
    {
        
       /*  $picture = Picture::with('user','comment')
        ->leftjoin('comments', 'comments.picture_id', '=', 'pictures.id')
            ->leftjoin('users', 'pictures.user_id', '=', 'users.id')
            ->where('pictures.uploadLink', '=', $uploadLink)
            ->where('pictures.is_active', '=', true)
            ->distinct()
            ->orderBy('comments.updated_at', 'desc')
            ->get(['comments.comment', 'users.name', 'comments.created_at', 'comments.updated_at', 'pictures.title', 'pictures.source', 'pictures.id', 'comments.user_id','pictures.user_id', 'pictures.visited_count', 'pictures.active_comments']);
          */
          $picture = Picture::with('comment.user','user')
          ->where('pictures.is_active','=',true)
          ->where('pictures.uploadLink','=',$uploadLink)
          ->get();        
         if($picture->isEmpty())
          return view('pictures.not_found');  
          $picture[0]->comment= $picture[0]->comment->where('is_active', '=', true)->sortByDesc('updated_at');  
            $picture[0]->increment('pictures.visited_count');

           
            
        return view('pictures.show')->with('picture', $picture);
    }
    public function destroy($id)
    {
   
       

      
        switch(Auth::user()->isAdmin())
        {
            case true:
            {
                Picture::where('id',$id)->where('is_active',true)->update([
                    'is_active' => false
                   ]);

                Session::flash('account_updated', 'Picture has been disactivated!');
                return redirect("pictures_list");
            }
            case false:
            {
               $saved = Picture::where('id',$id)->where('is_active',true)->where('user_id',Auth::id())->update([
                    'is_active' => false
                   ]);
                   if($saved)
                Session::flash('pictures_created', 'Picture has been deleted!');
                return redirect('user_panel');
            }

            default:
            {
                return view('pictures.index'); 
            }
        }
    }

    public function activate($id)
    {
        Picture::where('id',$id)->where('is_active',false)->update([
            'is_active' => true
           ]);

      
        switch(Auth::user()->isAdmin())
        {
            case true:
            {
                Session::flash('account_updated', 'Picture has been activated!');
                return redirect("pictures_list");
            }
            case false:
            {
                Session::flash('account_updated', 'Picture has been activated!');
                return view('pictures.index');
            }

            default:
            {
                return view('pictures.index'); 
            }
        }  
    }
    public function update($id, CreatePictureRequest $request)
    {


        $picture = Picture::findOrFail($id);
        $files = Input::file('file');
        $user_id=$picture['user_id'];
        $datas = Request::all();

        if (!isset($datas['active']))
        $datas['active']=1;
      
        if ($files != null) {
            foreach ($files as $file) {
                $source='css\img\\'.$user_id.'\\'.$id.'.jpg';
                if (isset($datas['uploadLink']))
                {   $uniq = md5 (uniqid (rand()));
                    $uniq = substr($uniq,0,32).$user_id;
                    $uploadLink =$id.$uniq;
                }
                else
                $uploadLink = $id.$picture->uploadLink;
                $datas['file'] = null;
               
                $picture->update([

                    'title' => $datas['title'],
                    'visibility' =>$datas['visibility'],
                    'description' => $datas['description'],
                    'source' => $source,
                    'is_active' => $datas['active'],
                    'active_ratings' => $datas['active_ratings'],
                    'active_comments' => $datas['active_comments'],
                    'uploadLink' => $uploadLink

                ], $request->all());

                $picture = null;
                $file->move('C:\xampp\htdocs\web\image_hosting\public\css\img\\'.$user_id,$id.".jpg");
            }
        } else {
            if (isset($datas['uploadLink']))
            {   $uniq = md5 (uniqid (rand()));
                $uniq = substr($uniq,0,32).$user_id;
                $uploadLink = $id.$uniq;
            }
            else
            $uploadLink = $id.$picture->uploadLink;
            $picture->update([

                'title' => $datas['title'],
                'description' => $datas['description'], 
                'is_active' => $datas['active'],
                'visibility' =>$datas['visibility'],
                'active_ratings' => $datas['active_ratings'],
                'active_comments' => $datas['active_comments'],
                'uploadLink' => $uploadLink
            ], $request->all());
        }
        Session::flash('pictures_created', 'Picture has been updated!');
        return redirect('pictures');
    }
}
