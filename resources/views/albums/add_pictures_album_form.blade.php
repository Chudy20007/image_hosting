<div class='form-group'>
    <div class='col-md-4 control-label'>
            {!! Form::label('album','Album:') !!}
    </div>
    <div class='col-md-6'>
                   <select name='album_id' id='album_id' class="form-control">                  
                    <option selected="true" value="{{$pictures[0]->alb_id}}">{{$pictures[0]->alb_title}}</option>
                   </select>
    </div>
</div>
<div class='form-group'>
    <div class='col-md-4 control-label'>
            {!! Form::label('pictures','Pictures:') !!}
    </div>
    <div class='col-md-6'>
                   <select name='pictures_id[]' id='pictures_id[]' class="form-control" multiple>
                    @foreach ($pictures as $picture)
                    
                    <option value="{{$picture->pic_id}}">{{$picture->pic_title}} ({{$picture->pic_id}})</option>
                    
                      @endforeach
                   </select>
    </div>
</div>