<!DOCTYPE html>
<html lang="en">
  <head>
    <title>
    November Blue Database @yield('title')
    </title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="/trumbowyg/ui/trumbowyg.min.css">
    <link href='{{ elixir('css/app.css') }}' type='text/css' rel='stylesheet'>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" type='text/css' rel='stylesheet'>
    <link href="data:image/x-icon;base64,AAABAAEAEBAAAAEACABoBQAAFgAAACgAAAAQAAAAIAAAAAEACAAAAAAAAAEAAAAAAAAAAAAAAAEAAAAAAAAAAAAAGhoaAMjIyADc3NwASEhIACYmJgAzMzMA6OjoACwsLABoaGgAxcXFAHt7ewAxMTEAnJycAMvLywAwMDAAPT09ACIiIgBKSkoAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAQGBgMAAAAAAAAAAAAAAA0GBgYGDwAAAAAAAAAAAAAJBgYGBgYAAAAABgYGAAAAAAYGBgYGAAAABgYGBgYAAAAABQYGBgAAAAYGBgYGDAAAAAAAAAYAAAAKBgYGBgwAAAAAAAAGAAAAAAABCAsMAAAAAAAABgAAAAAAAAAODAAAAAAAAAYAAAAAAAAADgwAAAAAAAAGAAAAAAAAAA4MAAAAAAAABgYGBgAAAAAODAAAAAAAAAYGBgYGBhAAAgwAAAAAAAAGBgYGBgYGBgYMAAAAAAAAAAYGBgYGBgYGDAAAAAAAAAAAAAcMBgYGBgwAAAAAAAAAAAAAAAAAEQYSAIf/AAAD/wAAA8cAAIODAADDgQAA+4EAAPvhAAD7+QAA+/kAAPv5AAD4eQAA+AkAAPgBAAD8AQAA/wEAAP/xAAA=" rel="icon" type="image/x-icon" />
    <meta name="_token" content="{{ csrf_token() }}">
    @yield('head')
  </head>
  <body>
      <script>

    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');


    ga('create', 'UA-65243648-2', 'auto');


    ga('send', 'pageview');


</script>
    <nav id="asd-navbar" class="navbar navbar-default navbar-fixed-top">
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
            {{ config('app.name', 'Laravel') }}
          </a>
        </div>
        <div class="collapse navbar-collapse" id="app-navbar-collapse">
          <!-- Left Side Of Navbar -->
          <ul class="nav navbar-nav">
            @if(Auth::user())
            <li class="{{ isActiveUrl('/stats/' . Auth::user()->username) }}"><a href="/stats/{{ Auth::user()->username }}">My Stats</a></li>
            @endif
            <li class="{{ isActiveRoute('shows.*')  }}"><a href="/shows">Shows</a></li>
            <li class="{{ isActiveRoute('songs.*')  }}"><a href="/songs">Songs</a></li>
            <li class="{{ isActiveRoute('albums.*')  }}"><a href="/albums">Albums</a></li>
            @if(Auth::user())
            <li class="{{ isActiveRoute('fantasy.*.*') }}"><a href="/fantasy/shows">Fantasy</a></li>
            @endif
            <li class="{{ isActiveUrl('/about') }}">
              <a href="/about">About</a>
            </li>
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

      <div id="asd-messages-box">
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
      </div>

      @yield('before_content')
      <div id="asd-container">
        @yield('content')
      </div>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
      <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
      <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.bundle.min.js"></script>
      <script src="/js/bootbox.min.js"></script>
      <script src="/trumbowyg/trumbowyg.min.js"></script>
      <script src="/trumbowyg/plugins/base64/trumbowyg.base64.min.js"></script>
      <!--    <script src="https://use.fontawesome.com/0c6c3c7579.js"></script> -->
      <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/1.5.16/clipboard.min.js"></script>
      <script src="/js/jquery.isonscreen.min.js"></script>
      <script src="/js/app.js"></script>
    </body>
  </html>