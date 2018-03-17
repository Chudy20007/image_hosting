@extends('main') @section('content') @if (Session::has('account_updated'))
<div class='row alert alert-success card'>
  <div class='col-md-12 text-center'>
    <b> {{Session::get('account_updated')}} </b>
  </div>
</div>
@endif
<div class="table-responsive">
  <table class="table table- bordered table-hover">


    <thead class="thead-dark text-center">
      <tr>
        <th scope="col">ID</th>
        <th scope="col">Title</th>
        <th scope="col">User name</th>
        <th scope="col">Description</th>
        <th scope="col">Active</th>
        <th scope="col">Active com</th>
        <th scope="col">Created</th>
        <th scope="col">Updated</th>
        <th scope="col">Edit</th>
        <th scope="col">Deactivate</th>
        <th scope="col">Activate</th>
      </tr>
    </thead>
    <tbody>
      @foreach($albums as $album)
      <tr class="table-active">

        <td>{{$album->id}}</td>
        <td>
          <a href="{{URL::asset('albums/'.$album->id)}}">{{$album->title}}</a>
        </td>
        <td>{{$album->user['name']}}</td>
        <td>{{$album->description}}</td>
        <td> {{$album->is_active == 1 ? 'yes' : 'no'}}</td>
        <td> {{$album->active_comments == 1 ? 'yes' : 'no'}}</td>
        <td>{{$album->created_at}}</td>
        <td>{{$album->updated_at}}</td>
        <td> {!! Form::open(['method'=>'POST','class'=>'form-horizontal','action'=>['AlbumsController@edit',$album->id]]) !!}
          {!! Form::hidden('id',$album->id,['class'=>'form-control']) !!} {!! Form::submit('Edit',['class'=>'btn btn-info'])
          !!} {{ Form::close() }} </a>
        </td>
        <td> {!! Form::open(['method'=>'POST','class'=>'form-horizontal','action'=>['AlbumsController@destroy',$album->id]]) !!}
          {!! Form::hidden('id',$album->id,['class'=>'form-control']) !!} {!! Form::hidden('_method','DELETE',['class'=>'form-control'])
          !!} {!! Form::submit('Deactivate',['class'=>'btn btn-info']) !!} {{ Form::close() }} </a>
        </td>
        <td> {!! Form::open(['method'=>'POST','class'=>'form-horizontal','action'=>['AlbumsController@activate',$album->id]])
          !!} {!! Form::hidden('id',$album->id,['class'=>'form-control']) !!} {!! Form::hidden('_method','PATCH',['class'=>'form-control'])
          !!} {!! Form::submit('Activate',['class'=>'btn btn-info']) !!} {{ Form::close() }} </a>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>

@stop