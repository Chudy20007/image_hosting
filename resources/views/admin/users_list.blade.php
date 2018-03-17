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
        <th scope="col">E-mail</th>
        <th scope="col">Admin</th>
        <th scope="col">Active</th>
        <th scope="col">Created</th>
        <th scope="col">Updated</th>
        <th scope="col">Edit</th>
        <th scope="col">Deactivate</th>
        <th scope="col">Activate</th>
      </tr>
    </thead>
    <tbody>
      @foreach($users as $user)
      <tr class="table-active">

        <td>{{$user->id}}</td>
        <td>{{$user->name}}</td>
        <td>{{$user->email}}</td>
        <td> {{$user->is_admin == 1 ? 'yes' : 'no'}}</td>
        <td> {{$user->is_active == 1 ? 'yes' : 'no'}}</td>
        <td>{{$user->created_at}}</td>
        <td>{{$user->updated_at}}</td>
        <td> {!! Form::open(['method'=>'POST','class'=>'form-horizontal','action'=>['AdminController@edit',$user->id]]) !!} {!!
          Form::hidden('id',$user->id,['class'=>'form-control']) !!} {!! Form::submit('Edit',['class'=>'btn btn-info']) !!}
          {{ Form::close() }} </a>
        </td>
        <td> {!! Form::open(['method'=>'POST','class'=>'form-horizontal','action'=>['AdminController@destroy',$user->id]]) !!}
          {!! Form::hidden('id',$user->id,['class'=>'form-control']) !!} {!! Form::hidden('_method','DELETE',['class'=>'form-control'])
          !!} {!! Form::submit('Deactivate',['class'=>'btn btn-info']) !!} {{ Form::close() }} </a>
        </td>
        <td> {!! Form::open(['method'=>'POST','class'=>'form-horizontal','action'=>['AdminController@activate',$user->id]]) !!}
          {!! Form::hidden('_method','PATCH',['class'=>'form-control'])
          !!}
          {!! Form::hidden('id',$user->id,['class'=>'form-control']) !!} {!! Form::submit('Activate',['class'=>'btn btn-info']) !!} {{ Form::close() }} </a>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>

@stop