@extends('main') @section('content') @if (Session::has('pictures_created'))
<div style="margin-top:.5rem;" class="row alert alert-success text-center card">
    <div class="col-md-12 text-center">
        <b> {{Session::get('pictures_created')}} {{Session::get('logout_message')}}
        </b>
    </div>
</div>

@endif @php ($a=0) @foreach($pictures as $picture)
<?php if($a%3==0 || $a==0) echo " <div class='row rowPictures'><div class='col-md-1'></div>"; ?>

<div class='col-md-3 col-sm-3 picture'>


    <div class='row'>
        <div class='col-md-12 col-sm-12'>
            {{$picture->pic_title}}
        </div>
    </div>


    <div class='row'>
        <div class='col-md-12 col-sm-12'>
            <a href="{{ URL::asset('/pictures/'.$picture->id)}}">
                <img class='img-thumbnail picture-icon' src="{{ URL::asset($picture->source)}}">
            </a>
        </div>
    </div>


    <div class='row'>
        <div class='col-md-12 col-sm-12'>
            <span> {{$picture->pic_description}} </span>
        </div>
        <br/>


    </div>
    <div class="card-footer author">
        Added by:
        <b>
            <a class='author-link' href="{{URL::asset('/user/'.$picture->usr_id)}}">{{$picture->usr_name}}</a>
        </b>
        <div class='div-comments'>
            <a href="{{URL::asset('/pictures/'.$picture->id)}}">
                <img style="margin-left:5px" src="{{URL::asset('css/img/speech-message.png')}}" placeholder="comments" />
                <span class='image-comments'>{{$picture->getCommentsCount()->count()}} comment(s)</span>
            </a>
        </div>
    </div>
</div>
@php($a++)
<?php if($a%3==0) echo "</div>";?> @endforeach



<div class='col-md-12 col-sm-12 picture'>

    @if (session('status'))
    <div class="alert alert-success">
        <h4> {{ session('status') }} </h4>
    </div>
    @endif @if (count($pictures[0]->album_comment)>0 && $pictures[0]->album_active_comments==true)
    <div class='row text-center'>
        <div class='col-md-12 col-sm-12'>
            <blockquote>
                <b> Comments</b>
            </blockquote>
        </div>


    </div>

    <div class="card-footer author">
        @foreach($pictures as $pict)
        <div class='div-comments text-left'>
            <blockquote class="mycode_quote">
                <cite>
                    <span> ({{$pict->updated_at}})</span>
                    <a href="user/{{$pict->com_user_id}}" class="quick_jump">
                        <img class="small-img" src="{{ URL::asset('css/img/avatars/'.$pict->usr_id." .jpg ")}}">{{$pict->usr_name}}</a> wrote: {{$pict->album_comment}}</cite>
            </blockquote>


        </div>



        @endforeach @endif
    </div>
</div>

@stop