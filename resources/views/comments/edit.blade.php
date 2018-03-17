@extends('main') @section('content')
<div class='row'>
    <div class='col-md-8 col-md-offset-2 picture'>
        <div class='card'>
            <div class='panel-body'>

                @include('pictures.error_form') {!! Form::model($hiddenValues,['method'=>'PATCH','class'=>'form-horizontal','action'=>['CommentsController@update',$hiddenValues->id]])
                !!} @include('comments.comment_form')


                <div class='form-group'>
                    <div class='col-md-12 text-center'>
                        {!! Form::submit('Edit comment',['class'=>'btn btn-info']) !!} {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop