@extends('main') @section('content')
<div class="container">
    <div class="row">
        <div class="col-md-1">
        </div>
        <div class="col-md-10 picture">
            <div class="panel panel-default card">
                <div class="panel-heading"></div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" enctype="multipart/form-data" action="update">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label label">Name</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{$user->name}}" required autofocus> @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ $user->email }}" required> @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label label">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required> @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="col-md-4 control-label label">Confirm Password</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>
                        {{ Form::hidden('user_id',$user->id) }} @if (Auth::user()->isAdmin())
                        <div class="form-group">
                            <label for="password-confirm" class="col-md-4 control-label label">Priviliges:</label>

                            <div class="col-md-6">
                                <select id="privileges" type="select" class="form-control" name="privileges" required>
                                    <option value='1'> Admin </option>
                                    <option value='0'> User </option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="col-md-4 control-label label">Active:</label>

                            <div class="col-md-6">
                                <select id="active" type="select" class="form-control" name="active" required>
                                    <option value='1'> Enabled </option>
                                    <option value='0'> Disabled </option>
                                </select>
                            </div>
                        </div>
                        @endif
                        <div class="form-group">
                            <label for="file" class="col-md-4 control-label label">Avatar</label>
                            <div class="col-md-6">
                                {{ Form::file('file', array('multiple'=>false,'accept'=>'image/jpeg','class'=>'formOption')) }}
                            </div>
                        </div>
                        </br>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-info">
                                    Update
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-1">
        </div>
    </div>

</div>
@endsection