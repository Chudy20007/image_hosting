<div class='form-group'>
        <div class='col-md-4 control-label'>
                {!! Form::label('title','Title:') !!}
        </div>
        <div class='col-md-6'>
                {!! Form::text('title',null,['class'=>'form-control']) !!}
        </div>
</div>

</div>
<div class='form-group'>
        <div class='col-md-4 control-label'>
                {!! Form::label('description','Description:') !!}
        </div>
        <div class='col-md-6'>
                {!! Form::textarea('description',null,['class'=>'form-control']) !!}
        </div>
</div>

<div class='form-group'>
        <div class='col-md-4 control-label'>
                {!! Form::label('visibility','Visibility:') !!}
        </div>
        <div class='form-select-control col-md-6 '>
                {!! Form::select('visibility',array('public'=>'public','private'=>'private'),['class'=>'form-select-control']) !!}
        </div>
</div>

@if (Auth::user()->isAdmin())
<div class='form-group'>
                <div class='col-md-4 control-label'>
                        {!! Form::label('active','Active:') !!}
                </div>
                <div class='col-md-12 col-sm-12'>
                        {{ Form::select('active', array('1'=>'yes','0'=>'no'),['class'=>'formOption']) }}
                </div>
        </div>
        @endif
<div class='form-group'>
        <div class='col-md-4 control-label'>
                {!! Form::label('active_comments','Comments:') !!}
        </div>
        <div class='col-md-12 col-sm-12 form-select-control'>
                {{ Form::select('active_comments' ,array('1'=>'enabled','0'=>'disabled'),['class'=>'form-select-control']) }}
        </div>
</div>

<div class='form-group'>
                <div class='col-md-4 control-label'>
                        {!! Form::label('active_ratings','Ratings:') !!}
                </div>
                <div class='col-md-12 col-sm-12 form-select-control'>
                        {{ Form::select('active_ratings' ,array('1'=>'enabled','0'=>'disabled'),['class'=>'form-select-control']) }}
                </div>
        </div>

<div class='form-group'>
        <div class='col-md-4 control-label'>
                {!! Form::label('uploadLink','Upload link:') !!}
        </div>
        <div class='col-md-6'>
                {!! Form::checkbox('uploadLink','yes',['class'=>'form-control']) !!}
        </div>
</div>
<div class='form-group'>
        <div class='col-md-4 control-label'>
                {!! Form::label('url','File:') !!}
        </div>
        <div class='col-md-12 col-sm-12'>
                {{ Form::file('file[]', array('multiple'=>true,'accept'=>'image/jpeg','class'=>'formOption')) }}
        </div>
</div>