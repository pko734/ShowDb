<!DOCTYPE html>
<html lang="en">
  <head>
    <title>
      Avett Setlist Database @yield('title')
    </title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Latest compiled and minified CSS -->

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="/trumbowyg/ui/trumbowyg.min.css">
    <link href='{{ elixir('css/app.css') }}' type='text/css' rel='stylesheet'>

    @yield('head')
  </head>
  <body>{!! Analytics::render() !!}
    <nav class="navbar navbar-default navbar-static-top">
      <div class="container">
	<div class="navbar-header">

	  <!-- Collapsed Hamburger -->
	  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
	    <span class="sr-only">Toggle Navigation</span>
	    <span class="icon-bar"></span>
	    <span class="icon-bar"></span>
	    <span class="icon-bar"></span>
	  </button>

	  <!-- Branding Image -->
	  <a class="navbar-brand" href="{{ url('/') }}">
	    {{ config('app.name', 'Laravel') }}:
	  </a>
	</div>

	<div class="collapse navbar-collapse" id="app-navbar-collapse">
	  <!-- Left Side Of Navbar -->
	  <ul class="nav navbar-nav">
	    @if(Auth::user())
	    <li class="{{ isActiveUrl('/stats/' . Auth::user()->username) }}"><a href="/stats/{{ Auth::user()->username }}">My Stats</a></li>
	    @endif

	    <li class="{{ isActiveUrl('/shows') }}"><a href="/shows">Shows</a></li>
	    <li class="{{ isActiveUrl('/songs') }}"><a href="/songs">Songs</a></li>
	    @if(Auth::user() && Auth::user()->admin)
	    <li class="dropdown {{ isActiveRoute('admin.*') }}">
	      <a class="dropdown-toggle" data-toggle="dropdown" href="#">Admin
		<span class="caret"></span></a>
	      <ul class="dropdown-menu">
		<li class="{{ isActiveUrl('/admin')}}"><a href="/admin">Notes</a></li>
		<li class="{{ isActiveUrl('/admin/users')}}"><a href="/admin/users">Users</a></li>
		<li class="{{ isActiveUrl('/admin/audit')}}"><a href="/admin/audit">Audit</a></li>
	      </ul>
	    </li>
	    @endif
	  </ul>

	  <!-- Right Side Of Navbar -->
	  <ul class="nav navbar-nav navbar-right">
	    <!-- Authentication Links -->
	    @if (Auth::guest())
	    <li><a href="{{ url('/auth/facebook') }}">Login with Facebook</a></li>
	    <li><a href="{{ url('/login') }}">Login</a></li>
	    <li><a href="{{ url('/register') }}">Register</a></li>
	    @else
	    <li class="dropdown">
	      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
		@if(\Gravatar::exists(Auth::user()->email))
		{!! \Gravatar::image(Auth::user()->email, 'test', ['width'=>25,'height'=>25]) !!}
		@else
		@if(Auth::user()->username)
		{{ Auth::user()->username }}
		@else
		{{ Auth::user()->name }}
		@endif
		@endif
		<span class="caret"></span>
	      </a>

	      <ul class="dropdown-menu" role="menu">
		<li class="{{ isActiveUrl('/settings') }}">
		  <a href="/settings">Settings</a>
		</li>
		<li class="{{ isActiveUrl('/about') }}">
		  <a href="/about">About</a>
		</li>
		<li>
		  <a href="{{ url('/logout') }}"
		     onclick="event.preventDefault();
			      document.getElementById('logout-form').submit();">
		    Logout
		  </a>

		  <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
		    {{ csrf_field() }}
		  </form>
		</li>
	      </ul>
	    </li>
	    @endif
	  </ul>
	</div>
      </div>
    </nav>


    @if(Session::get('flash_message') != null)
    <div class="alert alert-success alert-dismissible" style="margin-top: -20px;">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
      <strong>{{ Session::get('flash_message') }}</strong>
    </div>
    @endif
    @if(Session::get('flash_error') != null)
    <div class="alert alert-danger alert-dismissible" style="margin-top: -20px;">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
      <strong>{{ Session::get('flash_error') }}</strong>
    </div>
    @endif

    @if (count($errors) > 0)
    <div class="alert alert-danger">
      <ul>
	@foreach ($errors->all() as $error)
	<li>{{ $error }}</li>
	@endforeach
      </ul>
    </div>
    @endif

    @yield('content')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.bundle.min.js"></script>
    <script src="/js/bootbox.min.js"></script>
    <script src="/trumbowyg/trumbowyg.min.js"></script>
    <script src="https://use.fontawesome.com/0c6c3c7579.js"></script>

    <script src="/js/app.js"></script>


  </body>

</html>
