@extends('main') @section('content') @if (Session::has('comment_updated'))
<div class='row alert alert-success card'>
  <div class='col-md-12 text-center'>
    <b> {{Session::get('comment_updated')}} </b>
  </div>
</div>
@endif
<div class="table-responsive">
  <table class="table table- bordered table-hover">


    <thead class="thead-dark text-center">
      <tr>
        <th scope="col">ID</th>
        <th scope="col">User name</th>
        <th scope="col">Picture</th>
        <th scope="col">Comment</th>
        <th scope="col">Active</th>
        <th scope="col">Created</th>
        <th scope="col">Updated</th>
        <th scope="col">Edit</th>
        <th scope="col">Deactivate</th>
        <th scope="col">Activate</th>
      </tr>
    </thead>
    <tbody>
      @foreach($comments as $comment)
      <tr class="table-active">

        <td>{{$comment->id}}</td>
        <td>{{$comment->user->name}}</td>
        <td>
          <a class='profile-data' href="{{ URL::asset($comment->picture->source)}}">
            <img class="img-thumbnail small-img-admin-panel" src="{{ URL::asset($comment->picture->source)}}">
          </a>
        </td>
        <td>{{$comment->comment}}</td>
        <td> {{$comment->is_active == 1 ? 'yes' : 'no'}}</td>
        <td>{{$comment->created_at}}</td>
        <td>{{$comment->updated_at}}</td>
        <td> {!! Form::open(['method'=>'POST','class'=>'form-horizontal','action'=>['CommentsController@edit',$comment->id]])
          !!} {!! Form::hidden('id',$comment->id,['class'=>'form-control']) !!} {!! Form::submit('Edit',['class'=>'btn btn-info'])
          !!} {{ Form::close() }} </a>
        </td>
        <td> {!! Form::open(['method'=>'POST','class'=>'form-horizontal','action'=>['CommentsController@destroy',$comment->id]])
          !!} {!! Form::hidden('id',$comment->id,['class'=>'form-control']) !!} {!! Form::hidden('_method','DELETE',['class'=>'form-control'])
          !!} {!! Form::submit('Deactivate',['class'=>'btn btn-info']) !!} {{ Form::close() }} </a>
        </td>
        <td> {!! Form::open(['method'=>'POST','class'=>'form-horizontal','action'=>['CommentsController@activate',$comment->id]])
          !!} {!! Form::hidden('id',$comment->id,['class'=>'form-control']) !!} {!! Form::hidden('_method','PATCH',['class'=>'form-control'])
          !!} {!! Form::submit('Activate',['class'=>'btn btn-info']) !!} {{ Form::close() }} </a>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>

@stop