<div class='form-group'>
        
        <div class='col-md-4 control-label'>
                {!! Form::label('comment','Comment:') !!}
        </div>
        <div class='col-md-6'>
                {!! Form::textarea('comment',null,['class'=>'form-control','minlength'=>'8']) !!}
        </div>
        {!! Form::hidden('picture_id',$hiddenValues['picture_id'],['class'=>'form-control']) !!} {!! Form::hidden('user_id',$hiddenValues['user_id'],['class'=>'form-control'])
        !!}
</div>