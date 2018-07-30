@extends('layouts.master')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <div class="panel panel-default">
	<div class="panel-heading">Register</div>
	<div class="panel-body">
	  <form class="form-horizontal" role="form" method="POST" action="{{ url('/register') }}">
	    {{ csrf_field() }}

	    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
	      <label for="name" class="col-md-4 control-label">Name</label>

	      <div class="col-md-6">
		<input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

		@if ($errors->has('name'))
		<span class="help-block">
		  <strong>{{ $errors->first('name') }}</strong>
		</span>
		@endif
	      </div>
	    </div>

	    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
	      <label for="email" class="col-md-4 control-label">E-Mail Address</label>

	      <div class="col-md-6">
		<input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

		@if ($errors->has('email'))
		<span class="help-block">
		  <strong>{{ $errors->first('email') }}</strong>
		</span>
		@endif
	      </div>
	    </div>

	    <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
	      <label for="username" class="col-md-4 control-label">Username</label>

	      <div class="col-md-6">
		<input id="username" type="username" class="form-control" name="username" value="{{ old('username') }}" required>

		@if ($errors->has('username'))
		<span class="help-block">
		  <strong>{{ $errors->first('username') }}</strong>
		</span>
		@endif
	      </div>
	    </div>

	    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
	      <label for="password" class="col-md-4 control-label">Password</label>

	      <div class="col-md-6">
		<input id="password" type="password" class="form-control" name="password" required>

		@if ($errors->has('password'))
		<span class="help-block">
		  <strong>{{ $errors->first('password') }}</strong>
		</span>
		@endif
	      </div>
	    </div>

	    <div class="form-group">
	      <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>

	      <div class="col-md-6">
		<input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
	      </div>
	    </div>

	        <div class="form-group">
	          <label for="share" class="col-md-4 control-label">Publish My Username and Stats</label>
	          <div class="col-md-6">
                <button class="btn btn-lg btn-toggle" 
                        data-toggle="button" 
                        aria-pressed="false" 
                        autocomplete="off"
                        onClick="$('#share_input_id').attr('value', ($(this).hasClass('active')) ? 0 : 1)"
                        >
                  <div class="handle"></div>
                </button>
                <input type="hidden" name="share" value="0" id="share_input_id">
		      </div>
	        </div>

	    <div class="form-group">
	      <div class="col-md-6 col-md-offset-4">
		<button type="submit" class="btn btn-primary">
		  Register
		</button>
	      </div>
	    </div>
	    <div class="form-group">
	      <div class="col-md-6 col-md-offset-4">
		or
	      </div>
	    </div>

	    <div class="form-group">
	      <div class="col-md-6 col-md-offset-4">
		<button type="button" class="btn btn-primary" onclick="location.href='/auth/facebook'">
		  Login with Facebook
		</button>
	      </div>
	    </div>
	  </form>
	</div>
      </div>
    </div>
  </div>
</div>
@endsection
