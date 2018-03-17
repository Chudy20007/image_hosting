@extends('main') @section('content') @if (Session::has('album_updated'))
<div style="margin-top:.5rem;" class="row alert alert-success card">
    <div class="text-centercol-md-12">
        <b> {{Session::get('album_updated')}} </b>
        {{Session::get('logout_message')}}
    </div>
</div>
@endif

<div class='row'>
    <div style='margin-right:0; padding-right:0' class='col-md-11 col-lg-11'>
        <input class='main-search' type='text' placeholder='Search..'>
    </div>
    <div style='margin-left:0; padding-left:0' ;class='col-md-1 col-lg-1'>
        <button id="find-button-alb">
            <img src="{{URL::asset('css/img/search-img.png')}}" width="30px" height="30px">
        </button>
    </div>
</div>

@php ($a=0) @foreach($albums as $album)
<?php if($a%3==0 || $a==0) echo "<div class='row rowPictures'><div class='col-md-1 col-sm-1'></div>"; ?>

<div class='col-md-3 col-sm-3 picture'>


    <div class='row'>
        <div class='col-md-12 col-sm-12'>
            {{$album->title}}
        </div>
    </div>


    <div class='row'>
        <div class='col-md-12 col-sm-12'>
            <a href="{{URL::asset('/albums/'.$album->id)}}">
                <img class='img-thumbnail picture-icon' src="{{URL::asset($album->title_photo)}}">
            </a>
        </div>
    </div>


    <div class='row'>
        <div class='col-md-12 col-sm-12'>
            <span> {{$album->description}} </span>
        </div>
        <br/>


    </div>
    <div class="card-footer author">
        Added by:
        <b>
            <a class='author-link' href='user/{{$album->user_id}}'>{{$album->user->name}}</a>
        </b>
        <div class='div-comments'>
            @if ($album->active_ratings)
            <?php $b=1; ?>
            <div class='{{$album->id}}'>
                @if (isset($album->rate)) @for ($i=0; $i
                <5; $i++) @if ($i < $album->rate)
                    <button class="fa fa-star checked" value="{{$b}}"></button>

                    @else
                    <button class="fa fa-star" value="{{$b}}"></button>


                    @endif
                    <?php $b++; ?> @endfor @else
                    <button class="fa fa-star" value="1"></button>
                    <button class="fa fa-star" value="2"></button>
                    <button class="fa fa-star" value="3"></button>
                    <button class="fa fa-star" value="4"></button>
                    <button class="fa fa-star" value="5"></button>


                    @endif
            </div>
            @endif
            <span class='image-comments'>Average rating:
                <b>{{$album->average_rating()}} </b>
            </span>
            <br/>
            <span class='image-comments'>Comments enabled:
                <b>{{$album->active_comments ? 'yes' : 'no'}} </b>
            </span>
            <br/>
            <span class='image-comments'>Ratings enabled:
                <b>{{$album->active_ratings ? 'yes' : 'no'}} </b>
            </span>
            <br/>
            <span class='image-comments'>Album visibility:
                <b>{{$album->visibility}} </b>
            </span>
            <br/>
            <a href="albums/{{$album->id}}">
                <img style="margin-left:5px" src="{{URL::asset('css/img/speech-message.png')}}" placeholder="comments" />
                <span class='image-comments'>{{$album->getCommentsCount()->count()}} comment(s)</span>
            </a>
            <br/>
            <br/>
            <div class='row'>
                @if (strpos($album->upload_link, $album->id.'null') === false)
                <button class="btn-info btn link col-md-12" id="buttonTestClick" value="{{URL::asset('/show_alb/'.$album->upload_link)}}"
                    type="button">Copy link</button>
                @endif
            </div>
            <br/>
            <div class='row text-center'>
                <a class="col-md-12" href="{{URL::asset('/albums/'.$album->id.'/edit')}}">
                    <button class="btn-info btn col-md-12" value="" type="button">Edit album</button>
                </a>
            </div>
            <br/>
            <div class='row text-center'>
                <a class="col-md-12" href="{{URL::asset('/albums/'.$album->id.'/destroy')}}">
                    <button class="btn-info btn col-md-12" value="" type="button">Delete album</button>
                </a>
            </div>

        </div>
    </div>
</div>
@php($a++)
<?php if($a%3==0) echo "</div>";?> @endforeach @stop