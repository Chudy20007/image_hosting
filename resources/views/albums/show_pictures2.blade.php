@extends('main') @section('content') @if (Session::has('pictures_created'))
<div style="margin-top:.5rem;" class="row alert alert-success text-center card ">
    <div class="col-md-12 text-center">
        <b> {{Session::get('pictures_created')}} {{Session::get('logout_message')}}
        </b>
    </div>
</div>

@endif @php $a=0; $i=0; @endphp @foreach($pictures[0]->picture as $picture)
<?php if($a%3==0 || $a==0) echo " <div class='row rowPictures'><div class='col-md-1'></div>"; ?>

<div class='col-md-3 col-sm-3 picture'>


    <div class='row'>
        <div class='col-md-12 col-sm-12'>
            {{($picture->picture->title)}}
        </div>
    </div>




    <div class='row'>
        <div class='col-md-12 col-sm-12'>
            <a href="{{ URL::asset('/pictures/'.$picture->picture_id)}}">
                <img class='img-thumbnail picture-icon' src="{{ URL::asset($picture->picture->source)}}">
            </a>
        </div>
    </div>


    <div class='row'>
        <div class='col-md-12 col-sm-12'>
            <span> {{$picture->picture->description}} </span>
        </div>
        <br/>


    </div>
    <div class="card-footer author">
        Added by:
        <b>
            <a class='author-link' href="{{URL::asset('/user/'.$pictures[$i]->user->id)}}">{{$pictures[$i]->user->name}}</a>
        </b>
        <div class='div-comments'>
            @if ($pictures[0]->active_ratings)
            <?php $b=1; ?>
            <div class='{{$picture->picture_id}}'>
                @if (isset($picture->users_rate)) @for ($c=0; $c
                <5; $c++) @if ($c < $picture->picture->user_rate->rate)
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

            <span class='image-comments'>Average rating:
                <b> @if (isset($picture->picture)) {{$picture->picture->average_rating()}} @endif </b>
            </span>
            @endif </br>
            @if ($pictures[0]->active_comments)
            <a href="{{URL::asset('/pictures/'.$picture->picture_id)}}">
                <img style="margin-left:5px" src="{{URL::asset('css/img/speech-message.png')}}" placeholder="comments" />
                <span class='image-comments'>{{$picture->picture->getCommentsCount()->count()}} comment(s)</span>
            </a>
            @endif
        </div>
    </div>
</div>
@php $a++; @endphp
<?php if($a%3==0) echo "</div>";?> @endforeach



<div class='col-md-12 col-sm-12 picture'>

    @if (session('status'))
    <div class="alert alert-success">
        <h4> {{ session('status') }} </h4>
    </div>
    @endif @if ($pictures[0]->active_comments==true)
    <div class='row text-center'>
        <div class='col-md-12 col-sm-12'>
            <blockquote>
                <b> Comments</b>
            </blockquote>
        </div>


    </div>

    <div class="card-footer author">
        @foreach($pictures[0]->comment as $pict)
        <div class='div-comments text-left'>
            <blockquote class="mycode_quote">
                <cite>
                    <span> ({{$pict->updated_at}})</span>
                    <a href="{{URL::asset('user/'.$pict->user_id)}}" class="quick_jump">
                        <img class="small-img" src="{{ URL::asset('css/img/avatars/'.$pict->user_id.".jpg ")}}">{{$pict->user->name}}</a> wrote: {{$pict->comment}}</cite>
                        @if(Auth::id() == $pict->user_id) @php $hiddenValues=[ 'user_id' =>$pict->user_id, 'picture_id'=>$pict->id ]; @endphp @include('pictures.error_form')
                        {!! Form::model($pict,['method'=>'POST','files' => true,'class'=>'form-horizontal','action'=>['CommentsController@album_com_edit',$pict->id]])
                        !!} {!!Form::hidden('user_id',$pict->user_id['user_id'])!!} {!! Form::submit('Edit',['class'=>'btn btn-info'])
                        !!} {!! Form::close() !!} @endif
            </blockquote>


        </div>



        @endforeach @php $hiddenValues=[ 'user_id'=>Auth::id(), 'picture_id'=>$pictures[0]->id ]; @endphp @include('comments.create_fast_album_comment')
        @endif
    </div>
</div>

@stop