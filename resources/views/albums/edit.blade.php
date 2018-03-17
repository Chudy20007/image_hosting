@extends('main') @section('content')
<div class='row'>
    <div class='col-md-8 col-md-offset-2 picture'>
        <div class='card'>
            <div class='panel-body'>

                @include('pictures.error_form') {!! Form::model($album,['method'=>'PATCH','files' => true,'class'=>'form-horizontal','action'=>['AlbumsController@edit_pic',$album[0]->alb_id]])
                !!} @include('albums.edit_pictures_album_form')


                <div class='form-group'>
                    <div class='col-md-6'>
                        {!! Form::submit('Edit album',['class'=>'btn btn-info']) !!} {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop