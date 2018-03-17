@extends('main') @section('content') 
@if (Session::has('account_updated'))
<div class='row alert alert-success card'>
  <div class='col-md-12 text-center'>
  <b>  {{Session::get('account_updated')}} </b>
  </div>
</div>
@endif
<div class="table-responsive">
  <table class="table table- bordered table-hover">


    <thead class="thead-dark text-center">
      <tr>
        <th scope="col">ID</th>
        <th scope="col">Name</th>
        <th scope="col">Title</th>
        <th scope="col">Picture</th>
        <th scope="col">Access</th>
        <th scope="col">Active</th>
        <th scope="col">Comments</th>
        <th scope="col">Created</th>
        <th scope="col">Updated</th>
        <th scope="col">Edit</th>
        <th scope="col">Deactivate</th>
        <th scope="col">Activate</th>
      </tr>
    </thead>
    <tbody>
      @foreach($pictures as $picture)
      <tr class="table-active">

        <td>{{$picture->id}}</td>
        <td><a class='profile-data' href="{{URL::asset('user/'.$picture->user_id)}}">{{$picture->name}}</a></td>
        <td>{{$picture->title}}</td>
        <td><a class='profile-data' href="{{ URL::asset($picture->source)}}"><img class="img-thumbnail small-img-admin-panel" src="{{ URL::asset($picture->source)}}"></a></td>
       <td> {{$picture->visibility}} </td>
        <td> {{$picture->is_active == 1 ? 'yes' : 'no'}}</td>
        <td> {{$picture->active_comments == 1 ? 'yes' : 'no'}}</td>
        <td>{{$picture->created_at}}</td>
        <td>{{$picture->updated_at}}</td>
        <td> {!! Form::open(['method'=>'POST','class'=>'form-horizontal','action'=>['PicturesController@edit',$picture->id]]) !!} {!!
          Form::hidden('id',$picture->id,['class'=>'form-control']) !!} {!! Form::submit('Edit',['class'=>'btn btn-info']) !!}
          {{ Form::close() }} </a>
        </td>
        <td> {!! Form::open(['method'=>'POST','class'=>'form-horizontal','action'=>['PicturesController@destroy',$picture->id]]) !!}
          {!! Form::hidden('id',$picture->id,['class'=>'form-control']) !!} {!! Form::hidden('_method','DELETE',['class'=>'form-control'])
          !!} {!! Form::submit('Deactivate',['class'=>'btn btn-info']) !!} {{ Form::close() }} </a>
        </td>
        <td> {!! Form::open(['method'=>'POST','class'=>'form-horizontal','action'=>['PicturesController@activate',$picture->id]]) !!}
          {!! Form::hidden('id',$picture->id,['class'=>'form-control']) !!} {!! Form::hidden('_method','PATCH',['class'=>'form-control'])
          !!} {!! Form::submit('Activate',['class'=>'btn btn-info']) !!} {{ Form::close() }} </a>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>

@stop