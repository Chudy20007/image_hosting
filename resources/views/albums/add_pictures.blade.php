@extends('main') @section('content')
<div class='row'>
        <div class='col-md-2'>
            </div> 
    <div class='col-md-8 picture'>
        
        <div class='card'>
            <div class='panel-body'>
                @include('pictures.error_form') {!! Form::open(['url'=>'albums/store_pic','class'=>'form-horizontal']) !!} @include('albums.add_pictures_album_form')
                <div class='form-group'>
                    <div class='col-md-6'>
                        {!! Form::submit('Add album',['class'=>'btn btn-info']) !!} {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@stop