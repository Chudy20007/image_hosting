<div class='form-group'>
        <div class='col-md-4 control-label'>
                {!! Form::label('title','Album name:') !!}
        </div>
        <div class='col-md-12'>
                {!! Form::text('title',null,['class'=>'form-control']) !!}
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
                {!! Form::label('pictures','Pictures:') !!}
        </div>
        <div class='col-md-12'>
                <select name='pictures_id[]' id='pictures_id[]' class="form-control" multiple>
                        @foreach ($pictures as $picture)

                        <option value="{{$picture->id}}">{{$picture->title}} (created: {{$picture->updated_at}})</option>

                        @endforeach
                </select>
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