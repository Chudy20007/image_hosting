<div class='form-group'>
        <div class='col-md-4 control-label'>
                {!! Form::label('visitors','Users:') !!}
        </div>
        <div class='col-md-6'>
                {{ Form::select('visitors[]',$users,null,['multiple'=>'multiple','class'=>'form-select-control']) }}
                {{ Form::hidden('album_id',$album->id,['multiple'=>'multiple','class'=>'form-select-control']) }}
</div>

