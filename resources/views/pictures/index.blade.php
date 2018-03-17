@extends('main') @section('content') @if (Session::has('pictures_created'))
<div style="margin-top:.5rem;" class="row alert alert-success card text-center">
    <div class="col-md-12">
       <b> {{Session::get('pictures_created')}}
        {{Session::get('logout_message')}} 
       </b>
    </div>
</div>

@endif
<div class='row'>
    <div style='margin-right:0; padding-right:0' class='col-md-11 col-lg-11'>
    <input class='main-search' type='text' placeholder='Search..'>
    </div>
    <div style='margin-left:0; padding-left:0';class='col-md-1 col-lg-1'><button id="find-button"><img src="{{URL::asset('css/img/search-img.png')}}" width="30px" height= "30px"></button>
    </div>
    </div>
@php ($a=0) @foreach($pictures as $picture)
<?php if($a%3==0 || $a==0) echo " <div class='row rowPictures'><div class='col-md-1'></div>"; ?>
   
<div class='col-md-3 col-sm-3 picture'>


    <div class='row'>
        <div class='col-md-12 col-sm-12'>
            {{$picture->title}}
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
            <span> {{$picture->description}} </span>
        </div>
        <br/>


    </div>
    <div class="card-footer author">
        Added by:
        <b>
            <a class='author-link' href='user/{{$picture->user->id}}'>{{$picture->user->name}}</a>
        </b>
        <div class='div-comments'>
                <?php $b=1; ?>
            @if ($picture->active_ratings)
            
            <div class='{{$picture->id}}'>
                @if (isset($picture->user_rate))
                @for ($i=0; $i<5; $i++)
                
               
                    @if ($i < $picture->user_rate->rate)                   
                        <button class="fa fa-star checked" value="{{$b}}"></button>
                    
                    @else
                        <button class="fa fa-star" value="{{$b}}"></button>
                    
                   
                    @endif
                    <?php $b++; ?>     
                @endfor
                @else
                <button class="fa fa-star" value="1"></button>
                <button class="fa fa-star" value="2"></button>
                <button class="fa fa-star" value="3"></button>
                <button class="fa fa-star" value="4"></button>
                <button class="fa fa-star" value="5"></button>
                   
                
                @endif
            </div>
            @endif
            @if ($picture->active_ratings)
<span class='image-comments'>Average rating: <b>{{$picture->average_rating()}} </b></span> </br>
@endif
@if ($picture->active_comments)
            <a href="pictures/{{$picture->id}}">
                <img style="margin-left:5px" src="{{URL::asset('css/img/speech-message.png')}}" placeholder="comments" />
                <span class='image-comments'>{{$picture->getCommentsCount()->count()}} comment(s)</span> </br>
                </a>
                @endif
               
        </div>
    </div>
    <input id="signup-token" name="_token" type="hidden" value="{{csrf_token()}}">
</div>
@php($a++)
<?php if($a%3==0) echo "</div>";?> @endforeach @stop