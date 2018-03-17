@extends('main') @section('content')

<div class='row rowPictures text-center'>
    <div class='col-md-12 col-sm-12 picture'>

        <div class='row'>
            <div class='col-md-12 col-sm-12'>

                <blockquote>
                    <b> {{$picture[0]->title }} </b>
                </blockquote>

                <span class="image-comments">Visited count: {{$picture[0]->visited_count}}</span>
            </div>
        </div>


        <div class='row'>
            <div class='col-md-12 col-sm-12'>
                <a href="{{ URL::asset('pictures/'.$picture[0]->id)}}">
                    <img class='img-thumbnail picture-show' src="{{ URL::asset($picture[0]->source)}}">
                </a>
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
            <b>
                <a class='author-link' href="{{URL::asset('user/'.$picture[0]->user->id)}}">{{$picture[0]->user->name}}</a>
            </b>

            <div class='div-comments'>
                <?php $b=1; ?> @if ($picture[0]->active_ratings)

                <div class='{{$picture[0]->id}}'>
                    @if (isset($picture[0]->user_rate)) @for ($i=0; $i
                    <5; $i++) @if ($i < $picture[0]->user_rate->rate)
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
                    <b>{{$picture[0]->average_rating()}} </b>
                </span>
                </br>
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
        @endif @if ((count($picture)>0) || Auth::user()->isAdmin())
        <div class='row'>
            <div class='col-md-12 col-sm-12'>
                <blockquote>
                    <b> Comments</b>
                </blockquote>
            </div>


        </div>

        <div class="card-footer author">
            @php $i=0; @endphp @if ($picture[0]->active_comments == true) @foreach($picture[0]->comment as $pict)

            <div class='div-comments text-left'>
                <blockquote class="mycode_quote">
                    <cite>
                        <span> ({{$pict->updated_at}})</span>

                        <a href="{{URL::asset('/user/'.$pict->user_id)}}" class="quick_jump">
                            <img class="small-img" src="{{ URL::asset('css/img/avatars/'.$pict->user_id." .jpg ")}}">{{$pict->user->name}}</a> wrote: {{$pict->comment }}

                    </cite>
                    <div class="row text-right">
                        <div class='col-md-10'></div>
                        @if(Auth::id() == $pict->user_id) @php $hiddenValues=[ 'user_id' =>$pict->user_id, 'picture_id'=>$pict->id ]; @endphp @include('pictures.error_form')
                        {!! Form::model($pict,['method'=>'POST','files' => true,'class'=>'form-horizontal','action'=>['CommentsController@edit',$pict->id]])
                        !!} {!!Form::hidden('user_id',$pict->user_id['user_id'])!!} {!! Form::submit('Edit',['class'=>'btn
                        btn-info']) !!} {!! Form::close() !!} @endif
                    </div>
                </blockquote>


            </div>


            @php $i++; @endphp @endforeach @php $hiddenValues=[ 'user_id'=>Auth::id(), 'picture_id'=>$picture[0]->id ]; @endphp @include('comments.create_fast_comment')
            @endif @endif
        </div>
    </div>
</div>
@stop