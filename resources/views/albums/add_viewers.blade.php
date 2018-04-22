@extends('main') @section('content')
<div class='row'>
    <div class='col-md-2'>
    </div>
    <div class='col-md-8 picture'>
        <div class='card'>
            <div class='panel-body'>
                @include('pictures.error_form') {!! Form::open(['url'=>'albums/add_viewers','class'=>'form-horizontal']) !!} @include('albums.visitors_form')
                <div class='form-group'>
                    <div class='col-md-6'>
                        {!! Form::submit('Add visitors',['class'=>'btn btn-info']) !!} {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class='col-md-2'>
    </div>
</div>

@stop