@extends('main') @section('content') @if (Session::has('pictures_created'))
<div style="margin-top:.5rem;" class="row alert alert-success">
    <div class="text-center col-md-12">
        <b> {{Session::get('pictures_created')}} </b>
        {{Session::get('logout_message')}}
    </div>
</div>


@endif

<div class='row rowPictures'>
    <div class='offset-3'>

    </div>
    <div class='col-md-6 col-sm-12 picture text-center'>
        <h2>Profile</h2>
        <a class='profile-data' href="{{URL::asset('user/'.$pictures[0]->id)}}">
            <img class="img-thumbnail picture-icon" src="{{ URL::asset('css/img/avatars/'.$pictures[0]->id.".jpg ")}}">
        </a>
        </br>
        <b> Name: </b>
        <a class='profile-data' href="{{URL::asset('user/'.$pictures[0]->id)}}">{{$pictures[0]->name}}</a>
        </br>@php $reg=explode(" ",($pictures[0]->created_at));@endphp
        <b> Registered: </b>{{$reg[0]}}</br>
        <b> Pictures count: </b> 0
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
@stop

</div>