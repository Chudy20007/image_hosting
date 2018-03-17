<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return('welcome');
});
Route::get('/user_panel','UserController@user_panel');
Route::get('/albums_panel','UserController@albums_panel');
Route::get('/contact','StaticPagesController@contact');
Route::get('/about','StaticPagesController@about');
Route::get('/home','StaticPagesController@home');
Route::get('/get_job','StaticPagesController@get_job');
Route::post('/pictures','PicturesController@store');
Route::get('user/{id}//update','UserController@update');
Route::get('/albums','AlbumsController@albums_list');
Route::post('/user/{id}/edit','AdminController@edit');
Route::post('/index','CommentsController@store');
Route::post('/album_comment/store_com','CommentsController@store_com');
Route::get('/albums_list','AlbumsController@albums_list');
Route::post('/albums','AlbumsController@store');
Route::get('/edit','UserController@edit');
Route::get('/create_comment','PicturesController@create_comment');
Route::get('/albums/create','AlbumsController@create');
Route::get('pictures/{id}/destroy','PicturesController@destroy');
Route::get('/albums/{id}/destroy','AlbumsController@destroy');
Route::delete('/albums/{id}','AlbumsController@destroy');
Route::get('/albums/{id}','AlbumsController@show');
Route::get('/albums/{id}/edit','AlbumsController@edit');
Route::patch('/albums/{id}/update','AlbumsController@edit_pic');
Route::get('/pictures','PicturesController@index');





Route::get('albums/user/{id}','AlbumsController@select_albums_user', function () {
    // Only authenticated users may enter...
})->middleware('auth');
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout',function()
{
    Session::flash('logout_message', 'Logout!')  ;
});
Route::get('/comment/{id}/create','CommentsController@create', function () {
    // Only authenticated users may enter...
})->middleware('auth');
Route::get('/user/{id}','UserController@show', function () {
    // Only authenticated users may enter...
})->middleware('auth');
Route::get('/album_comment/{id}/create','CommentsController@album_comment_create', function () {
    // Only authenticated users may enter...
})->middleware('auth');
Route::get('/album_comment/{id}/edit','CommentsController@album_com_edit', function () {
    // Only authenticated users may enter...
})->middleware('auth');
Route::get('/albums/{id}/add_pictures','AlbumsController@add_pictures', function () {
    // Only authenticated users may enter...
})->middleware('auth');
Route::post('/albums/store_pic','AlbumsController@store_pic', function () {
    // Only authenticated users may enter...
})->middleware('auth');
Route::get('/user/{id}/edit','AdminController@edit', function () {
    // Only authenticated users may enter...
})->middleware('auth');


Route::post('/albums_ratings_list/{id}/edit','ImageRatingController@edit_album_rate');

Route::group(['middleware' => ['auth', 'admin']], function() {
    Route::patch('//album_comments/{id}/edit','CommentsController@album_com_update');
Route::patch('/pictures_ratings_list/{id}/activate','AdminController@activate_rate');
Route::delete('/pictures_ratings_list/{id}/destroy','AdminController@destroy_rate');
Route::post('/pictures_ratings_list/{id}/edit','ImageRatingController@edit_rate');
Route::patch('/albums_ratings_list/{id}/activate','AdminController@activate_album_rate');
Route::delete('/albums_ratings_list/{id}/destroy','AdminController@destroy_album_rate');
    Route::get('/pictures_list','AdminController@pictures_list');
    Route::post('pictures/{id}/edit','PicturesController@edit');
    Route::patch('/pictures_ratings_list/{id}/activate','AdminController@activate_rate');
    Route::delete('/pictures_ratings_list/{id}/destroy','AdminController@destroy_rate');
    Route::get('/admin_panel','AdminController@admin_panel');
    Route::patch('/comments_list/{id}/activate','CommentsController@activate');

    Route::patch('/users_list/{id}/activate','AdminController@activate');
    Route::patch('/pictures_list/{id}/activate','PicturesController@activate');
    Route::delete('/users_list/{id}/destroy','AdminController@destroy');
    Route::post('/album_comment/{id}/edit','CommentsController@album_com_edit');
    Route::delete('/album_comments/{id}/destroy','AdminController@album_comment_destroy');
    Route::patch('/album_comments/{id}/activate','AdminController@album_comment_activate');
    Route::get('/users_list','AdminController@usersList');
    Route::get('/album_comments_list','AdminController@album_comments_list');
    Route::get('/pictures_list','AdminController@pictures_list');
    Route::get('/comments_list','AdminController@comments_list');
    Route::get('/pictures_ratings_list','AdminController@pictures_ratings_list');
    Route::get('/albums_ratings_list','AdminController@albums_ratings_list');
    Route::post('/comment/{id}/edit','CommentsController@edit');
    Route::post('/user/{id}/edit','AdminController@edit');

    Route::post('/user/{id}/update','AdminController@update');
    Route::post('/user/store','AdminController@store');
    Route::get('/user/create','AdminController@create');
    Route::get('/pictures','PicturesController@index');
    Route::post('user_panel/find_pictures','PicturesController@find_pictures');
    Route::post('albums_panel/find_albums','AlbumsController@find_albums');

    Route::post('albums/{id}/store_rating','ImageRatingController@store_rate');
    Route::post('pictures/{id}/store_rating','ImageRatingController@store_rate');
    Route::post('pictures/store_rating','ImageRatingController@store_rate');
    Route::post('albums/store_rating','AlbumRatingController@store_rate');
    Route::post('user/{id}/store_rating','ImageRatingController@store_rate');
    Route::post('albums/store_rating','AlbumRatingController@store_rate');
    Route::post('albums/user/{id}/store_rating','AlbumRatingController@store_rate');
});

Route::group(['middleware' => ['web']],function(){
 
    Route::get('/show_pic/{uploadLink}','PicturesController@show_pic');
    Route::get('/show_alb/{uploadLink}','AlbumsController@show_alb');
    Route::post('pictures/find_pictures','PicturesController@find_pictures');
    Route::post('albums/find_albums','AlbumsController@find_albums');
/*

    Route::post('/pictures','PicturesController@store');
    Route::get('/pictures','PicturesController@index');
    Route::get('/pictures/create','PicturesController@create');
    Route::get('/pictures/{id}','PicturesController@show');
*/

Route::auth();
Auth::routes();


});

Route::group(['middleware'=>['auth']],function(){
   
    Route::resource('pictures','PicturesController');
    Route::resource('comment','CommentsController');
});



