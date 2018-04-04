@extends('main') @section('content') @if (Session::has('pictures_created'))
<div style="margin-top:.5rem;" class="row alert alert-danger card">
    <div class="col-md-12">
        {{Session::get('pictures_created')}} {{Session::get('logout_message')}}
    </div>
</div>


@endif

<div class='row rowPictures'>
    <div class='offset-3'>

    </div>
    <div class='col-md-6 col-sm-12 picture text-center'>
        <h2>Profile</h2>
        <a class='profile-data' href="{{URL::asset('user/'.$pictures[0]->user->id)}}">
            <img class="img-thumbnail picture-icon" src="{{ URL::asset('css/img/avatars/'.$pictures[0]->user->id.".jpg ")}}">
        </a>
        </br>
        <b> Name: </b>
        <a class='profile-data' href="{{URL::asset('user/'.$pictures[0]->user->id)}}">{{$pictures[0]->user->name}}</a>
        </br>@php $reg=explode(" ",($pictures[0]->user->created_at));@endphp
        <b> Registered: </b>{{$reg[0]}}</br>
        <b> Pictures count: </b> {{count($pictures)}}
        <br/> @if ($pictures[0]->id==Auth::id())
        <a href="{{URL::asset('/user/'.$pictures[0]->id.'/edit')}}">
            <button class="btn-info btn" id="buttonTestClick" value="" type="button">Edit profile</button>
        </a>
        @endif
    </div>
    <div class='offset-3'>
    </div>
</div>
</div>
<div class=' col-md-12 col-sm-12 picture '>
    @php ($a=0) @foreach($pictures as $picture)
    <?php if($a/3==0 || $a==0) echo "<div class='row rowPictures'>"; ?>

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
                <a class='author-link' href="{{URL::asset('/user/'.$picture->user->id)}}">{{$picture->user->name}}</a>
            </b>
            <div class='div-comments'>
                <?php $b=1; ?> @if ($picture->active_ratings)

                <div class='{{$picture->id}}'>
                    @if (isset($picture->user_rate)) @for ($i=0; $i
                    <5; $i++) @if ($i < $picture->user_rate->rate)
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
                    <b>{{$picture->average_rating()}} </b>
                </span>
                </br>
                <a href="{{URL::asset('/pictures/'.$picture->id)}}">
                    <img style="margin-left:5px" src="{{URL::asset('css/img/speech-message.png')}}" placeholder="comments" />

                    <span class='image-comments'>{{$picture->getCommentsCount()->count()}} comment(s)</span>
                    </br>
                    </br>
                </a>
                @if ($picture->uploadLink!==null && $picture->user->id == Auth::id())
                <button class="btn-info btn link" id="buttonTestClick" value="{{URL::asset('/show_pic/'.$picture->uploadLink)}}" type="button">Copy link</button>
                @endif
            </div>
        </div>
    </div>

    <div class='col-md-1 col-sm-1'>

    </div>

    @php($a++)
    <?php if($a/3==0) echo "</div>";?> @endforeach @stop

</div>