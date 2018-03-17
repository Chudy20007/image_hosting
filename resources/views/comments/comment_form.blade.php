<div class='form-group'>

        <div class='col-md-12 text-center control-label'>
                {!! Form::label('comment','Comment:') !!}
        </div>
        <div class='col-md-12'>
                {!! Form::textarea('comment',null,['class'=>'form-control','minlength'=>'8']) !!}
        </div>
        {!! Form::hidden('picture_id',$hiddenValues['picture_id'],['class'=>'form-control']) !!} {!! Form::hidden('user_id',$hiddenValues['user_id'],['class'=>'form-control'])
        !!}
</div>