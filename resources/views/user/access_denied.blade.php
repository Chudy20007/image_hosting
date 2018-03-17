@extends('main') @section('content')
<div class='picture'>
  <div class='col-md-12'>
    <div class="alert alert-danger text-center">
      <h3>Access denied!</h3>
      Return to
      <a href="{{URL::asset('pictures')}}" class="alert-link">home page</a>.
    </div>
  </div>
</div>

@stop