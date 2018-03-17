@extends('main') @section('content')

<div class='row rowPictures text-center'>
    <div class='col-md-12 col-sm-12 picture'>


        <div class='row'>
            <div class='col-md-12 col-sm-12'>

                <blockquote>
                    <b> {{$picture[0]->title }} </b>
                </blockquote>

                <span class="image-comments">Visited count: {{$picture[0]->visited_count}}</span>

                {!! Form::open(['method'=>'POST','class'=>'form-horizontal','action'=>['PicturesController@destroy',$picture[0]->id]]) !!}
                {!! Form::hidden('id',$picture[0]->id,['class'=>'form-control']) !!} {!! Form::hidden('_method','DELETE',['class'=>'form-control'])
                !!} {!! Form::submit('Delete',['class'=>'btn btn-info']) !!} {{ Form::close() }}
            </div>
        </div>


        <div class='row'>
            <div class='col-md-12 col-sm-12'>
                <img class='img-thumbnail picture-show' src="{{ URL::asset($picture[0]->source)}}">
            </div>
        </div>


        <div class='row'>
            <div class='col-md-12 col-sm-12'>
                <span> {{$picture[0]->description}} </span>
            </div>
            <br/>


        </div>
        <div class="card-footer author">

            Added by:
            <b>{{$picture[0]->user->name}}</b>

            <div class='div-comments'>
                <a href="#">
                    <img style="margin-left:5px" src="../resources/img/speech-message.png" placeholder="comments" />
                    </span>
                </a>
            </div>
        </div>
    </div>
</div>

<div class='row rowPictures text-center'>
    <div class='col-md-12 col-sm-12 picture'>

        @if (session('status'))
        <div class="alert alert-success">
            <h4> {{ session('status') }} </h4>
        </div>
        @endif
        <div class='row'>
            <div class='col-md-12 col-sm-12'>
                <blockquote>
                    <b> Comments</b>
                </blockquote>
            </div>


        </div>

        <div class="card-footer author">
            @if (count($picture[0]->comment)>0 && $picture[0]->active_comments==true) @foreach($picture as $pict)
            <div class='div-comments text-left'>
                <blockquote class="mycode_quote">
                    <cite>
                        <span> ({{$pict->updated_at}})</span>
                        <a href="user/{{$pict->user_id}}" class="quick_jump">
                            <img class="small-img" src="{{ URL::asset('css/img/avatars/'.$pict->user_id." .jpg ")}}">{{$pict->user->name}}</a> wrote: {{$pict->comment}}</cite>
                </blockquote>
                <img style="margin-left:5px" src="../resources/img/speech-message.png" placeholder="comments" />

            </div>



            @endforeach @endif
        </div>
    </div>
</div>
@stop