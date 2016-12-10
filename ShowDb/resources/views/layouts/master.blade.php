<!DOCTYPE html>
<html lang="en">
  <head>
    <title>
      @yield('title','Avett Setlist Database')
    </title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!--
	<div></div>    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	-->

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <!-- <link href='/css/app.css'    type='text/css' rel='stylesheet'> -->
    <link href='/css/showdb.css' type='text/css' rel='stylesheet'>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.bundle.min.js"></script>
  </head>
  <body>
    @if(Session::get('flash_message') != null)
    <div class='flash_message'>{{ Session::get('flash_message') }}</div>
    @endif
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
	    {{ config('app.name', 'Laravel') }}: @yield('title')
	  </a>
	</div>

	<div class="collapse navbar-collapse" id="app-navbar-collapse">
	  <!-- Left Side Of Navbar -->
	  <ul class="nav navbar-nav">
	    <li><a href="/shows">Shows</a></li>
	    <li><a href="/songs">Songs</a></li>
	    <li><a href="/about">About</a></li>
	    &nbsp;
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
		{{ Auth::user()->username }} <span class="caret"></span>
	      </a>

	      <ul class="dropdown-menu" role="menu">
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

    <div class="fluid-container">
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

    </div>


  </body>

</html>
