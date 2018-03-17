<div class='row'>
    <div class='col-md-2'>
    </div>
    <div class='col-md-8 picture'>
        <div class='card '>
            <div class='panel-body '>
                @include('pictures.error_form') {!! Form::open(['url'=>'comment','class'=>'form-horizontal']) !!} @include('comments.comment_form')
                <div class='form-group'>
                    <div class='col-md-12 text-center'>
                        {!! Form::submit('Add comment',['class'=>'btn btn-info']) !!} {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class='col-md-2'>
    </div>
</div>