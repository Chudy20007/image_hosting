@extends('main') @section('content') 
@if (Session::has('rate_updated'))
<div class='row alert alert-success card'>
  <div class='col-md-12 text-center'>
  <b>  {{Session::get('rate_updated')}} </b>
  </div>
</div>
@endif
<div class="table-responsive">
  <table class="table table- bordered table-hover">


    <thead class="thead-dark text-center">
      <tr>
        <th scope="col">ID</th>
        <th scope="col">Name</th>
        <th scope="col">Rate</th>
        <th scope="col">Picture</th>
        <th scope="col">Active</th>
        <th scope="col">Active ratings</th>
        <th scope="col">Created</th>
        <th scope="col">Updated</th>
       
        <th scope="col">Deactivate</th>
        <th scope="col">Activate</th>
      </tr>
    </thead>
    <tbody>
      @foreach($ratings as $rate)
      <tr class="table-active">

        <td>{{$rate->id}}</td>
        <td><a class='profile-data' href="{{URL::asset('user/'.$rate->user->id)}}">{{$rate->user->name}}</a></td>
        <td>{{$rate->rate}}</td>
        <td><a class='profile-data' href="{{ URL::asset('/pictures/'.$rate->picture->id)}}"><img class="img-thumbnail small-img-admin-panel" src="{{ URL::asset($rate->picture->source)}}"></a></td>
        <td> {{$rate->is_active == 1 ? 'yes' : 'no'}}</td>
        <td> {{$rate->picture->active_ratings == 1 ? 'yes' : 'no'}}</td>
        <td>{{$rate->created_at}}</td>
        <td>{{$rate->updated_at}}</td>

        <td> {!! Form::open(['method'=>'POST','class'=>'form-horizontal','action'=>['AdminController@destroy_rate',$rate->id]]) !!}
          {!! Form::hidden('id',$rate->id,['class'=>'form-control']) !!} {!! Form::hidden('_method','DELETE',['class'=>'form-control'])
          !!} {!! Form::submit('Deactivate',['class'=>'btn btn-info']) !!} {{ Form::close() }} </a>
        </td>
        <td> {!! Form::open(['method'=>'POST','class'=>'form-horizontal','action'=>['AdminController@activate_rate',$rate->id]]) !!}
          {!! Form::hidden('id',$rate->id,['class'=>'form-control']) !!} {!! Form::hidden('_method','PATCH',['class'=>'form-control'])
          !!} {!! Form::submit('Activate',['class'=>'btn btn-info']) !!} {{ Form::close() }} </a>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>

@stop