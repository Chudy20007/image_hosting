<div class='form-group'>
        <div class='col-md-4 control-label'>
                {!! Form::label('album','Album:') !!}
        </div>
        <div class='col-md-6'>
                <select name='album_id' id='album_id' class="form-control">
                        <option selected="true" value="{{$album[0]->alb_id}}">{{$album[0]->alb_title}}</option>
                </select>
        </div>
</div>
<div class='form-group'>
        <div class='col-md-4 control-label'>
                {!! Form::label('pictures','Pictures:') !!}
        </div>
        <div class='col-md-6'>
                <select name='pictures_id[]' id='pictures_id[]' class="form-control" multiple>
                        @foreach ($album as $alb)

                        <option value="{{$alb->pic_id}}">{{$alb->pic_title}} ({{$alb->pic_id}})</option>

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
                {!! Form::label('active_ratings','Ratings:') !!}
        </div>
        <div class='col-md-12 col-sm-12 form-select-control'>
                {{ Form::select('active_ratings' ,array('1'=>'enabled','0'=>'disabled'),['class'=>'form-select-control']) }}
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
                {!! Form::label('uploadLink','Upload link:') !!}
        </div>
        <div class='col-md-6'>
                {!! Form::checkbox('uploadLink','yes',['class'=>'form-control']) !!}
        </div>
</div>