@extends('layouts.master')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <div class="panel panel-default">
	    <div class="panel-heading">My Settings</div>
	    <div class="panel-body">
	      <form class="form-horizontal" role="form" method="POST" action="/settings/update">
	        {{ method_field('PUT') }}
	        {{ csrf_field() }}

		    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
		      <label for="email" class="col-md-4 control-label">E-Mail Address</label>

		      <div class="col-md-6">
		        <input id="email" type="email" class="form-control" name="email" value="{{ $user->email }}" required>

		        @if ($errors->has('email'))
		        <span class="help-block">
		          <strong>{{ $errors->first('email') }}</strong>
		        </span>
		        @endif
		      </div>
		    </div>

		    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
		      <label for="name" class="col-md-4 control-label">Full Name</label>

		      <div class="col-md-6">
		        <input id="name" type="text" class="form-control" name="name" value="{{ $user->name }}" required>

		        @if ($errors->has('name'))
		        <span class="help-block">
		          <strong>{{ $errors->first('name') }}</strong>
		        </span>
		        @endif
		      </div>
		    </div>

	        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
	          <label for="username" class="col-md-4 control-label">Username</label>
	          <div class="col-md-6">
		        <input id="username" type="string" class="form-control" name="username" value="{{ $user->username }}" placeholder="Please choose a username" required autofocus>

		        @if ($errors->has('username'))
		        <span class="help-block">
		          <strong>{{ $errors->first('username') }}</strong>
		        </span>
		        @endif
	          </div>
	        </div>

            @if($user)
	        <div class="form-group">
	          <label for="share" class="col-md-4 control-label">Publish My Username and Stats</label>
	          <div class="col-md-6">
                <button class="btn btn-lg btn-toggle @if($user->share) active @endif" 
                        data-toggle="button" 
                        aria-pressed="false" 
                        autocomplete="off"
                        onClick="$('#share_input_id').attr('value', ($(this).hasClass('active')) ? 0 : 1)"
                        >
                  <div class="handle"></div>
                </button>
                <input type="hidden" name="share" value="{{ $user->share }}" id="share_input_id">
		      </div>
	        </div>
            @endif

	        <div class="form-group">
	          <div class="col-md-8 col-md-offset-4">
		        <button type="submit" class="btn btn-primary">
		          Save
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
