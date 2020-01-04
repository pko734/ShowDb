<!DOCTYPE html>
<html lang="en">
  <head>
    <title>
      @yield('title', 'November Blue Database')
    </title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta property="og:type"          content="website" />
    <meta property="og:url"           content="{{ url()->current() }}" />
    <meta property="og:title"         content="@yield('title', 'November Blue Database')" />
    <meta property="og:description"   content="Explore and record Avett Brothers show data!" />
    <meta property="og:image"         content="{{ url('/') }}/img/avett.jpg" />
    <meta property="fb:app_id"        content="{{ env('FACEBOOK_APP_ID') }}" />

    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#e1ebf4">
    <meta name="theme-color" content="#e1ebf4">
    <meta name="apple-mobile-web-app-title" content="Avett Database">

    <!-- Latest compiled and minified CSS -->
    <link href='{{ elixir('css/app.css') }}?update5' type='text/css' rel='stylesheet'>
    <link rel="dns-prefetch" href="//maps.googleapis.com">
    <style>

.blueimp-gallery > .delete {
  position: absolute;
  bottom: 105px;
  right: 17px;
  display: none;
  cursor: pointer;
}

.blueimp-gallery > .approve {
  position: absolute;
  bottom: 60px;
  right: 15px;
  display: none;
  cursor: pointer;
}

    </style>
    <link href="data:image/x-icon;base64,AAABAAEAEBAAAAEACABoBQAAFgAAACgAAAAQAAAAIAAAAAEACAAAAAAAAAEAAAAAAAAAAAAAAAEAAAAAAAAAAAAAGhoaAMjIyADc3NwASEhIACYmJgAzMzMA6OjoACwsLABoaGgAxcXFAHt7ewAxMTEAnJycAMvLywAwMDAAPT09ACIiIgBKSkoAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAQGBgMAAAAAAAAAAAAAAA0GBgYGDwAAAAAAAAAAAAAJBgYGBgYAAAAABgYGAAAAAAYGBgYGAAAABgYGBgYAAAAABQYGBgAAAAYGBgYGDAAAAAAAAAYAAAAKBgYGBgwAAAAAAAAGAAAAAAABCAsMAAAAAAAABgAAAAAAAAAODAAAAAAAAAYAAAAAAAAADgwAAAAAAAAGAAAAAAAAAA4MAAAAAAAABgYGBgAAAAAODAAAAAAAAAYGBgYGBhAAAgwAAAAAAAAGBgYGBgYGBgYMAAAAAAAAAAYGBgYGBgYGDAAAAAAAAAAAAAcMBgYGBgwAAAAAAAAAAAAAAAAAEQYSAIf/AAAD/wAAA8cAAIODAADDgQAA+4EAAPvhAAD7+QAA+/kAAPv5AAD4eQAA+AkAAPgBAAD8AQAA/wEAAP/xAAA=" rel="icon" type="image/x-icon" />
    <meta name="_token" content="{{ csrf_token() }}">
    @yield('head')
  </head>
  <body>
    <a href="javascript:window.history.back();" id="pwa-back" class="fa-stack fa-2x">
      <i class="fas fa-circle fa-stack-2x"></i>
      <i class="fas fa-arrow-left fa-stack-1x fa-inverse"></i>
    </a>    
    <div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls">
      <div class="slides"></div>
      <h3 class="title"></h3>
      <a class="prev">‹</a>
      <a class="next">›</a>
      <a class="close">×</a>
      <a class="play-pause"></a>
      <a class="delete text-danger" title="Delete Photo"><i class="fa fa-trash fa-lg text-danger"></i></a>
      <a class="approve text-danger" title="Approve Photo"><i class="fas fa-check fa-lg text-success"></i></a>
      <ol class="indicator"></ol>
    </div>
    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

      ga('create', 'UA-65243648-2', 'auto');

      ga('send', 'pageview');
    </script>
<!--
    <div id="fb-root"></div>
    <script>
      (function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.10&appId=1769812696591894";
      fjs.parentNode.insertBefore(js, fjs);
      }(document, 'script', 'facebook-jssdk'));
    </script>
-->

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
          <a class="navbar-brand" href="@if(Auth::user())/stats/{{Auth::user()->username}}@else/@endif">
            <img src="/images/dblogo-white-48x48.png">
          </a>
        </div>
        <div class="collapse navbar-collapse" id="app-navbar-collapse">
          <!-- Left Side Of Navbar -->
          <ul class="nav navbar-nav">
            <!--
            @if(Auth::user())
            <li class="{{ Ekko::isActiveURL('/stats/' . Auth::user()->username) }}"><a href="/stats/{{ Auth::user()->username }}">My Stats</a></li>
	        @else
            <li class="{{ Ekko::isActiveURL('/register') }}"><a href="/register">My Stats</a></li>
            @endif
            -->
            @if(Auth::user())
            <li class="{{ Ekko::isActiveURL('/new') }}"><a href="/new">What's New</a></li>
            @endif
            <li class="{{ Ekko::isActiveRoute('shows.*')  }}"><a href="/shows">Shows</a></li>
            <li class="{{ Ekko::isActiveRoute('songs.*')  }}"><a href="/songs">Songs</a></li>
            <li class="{{ Ekko::isActiveRoute('albums.*')  }}"><a href="/albums">Albums</a></li>
            @if(Auth::user() && Auth::user()->admin)
            <!-- <li class="{{ Ekko::isActiveURL('/timeline')  }}"><a href="/timeline">Timeline</a></li> -->
            @endif
            @if(Auth::user())
            <li class="{{ Ekko::isActiveURL('/game')  }}"><a href="/game">Games</a></li>
            <li class="{{ Ekko::isActiveURL('/users')  }}"><a href="/users">Users</a></li>
            @endif
            <li class="{{ Ekko::isActiveURL('/about') }}">
              <a href="/about">About</a>
            </li>
            @if(Auth::user() && Auth::user()->admin)
            <li class="dropdown {{ Ekko::isActiveRoute('admin.*') }}">
              <a class="dropdown-toggle" data-toggle="dropdown" href="#">Admin
                <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li class="{{ Ekko::isActiveURL('/admin') }}"><a href="/admin">Notes</a></li>
                <li class="{{ Ekko::isActiveURL('/admin/users') }}"><a href="/admin/users">Users</a></li>
                <li class="{{ Ekko::isActiveURL('/admin/timeline') }}"><a href="/admin/timeline">Timeline</a></li>
		<li class="{{ Ekko::isActiveURL('/admin/trivia') }}"><a href="/admin/trivia">Trivia</a></li>
                <!--<li class="{{ Ekko::isActiveURL('/admin/audit')}}"><a href="/admin/audit">Audit</a></li>-->
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
            <li class="dropdown {{ Ekko::isActiveRoute('settings.*') }}">
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
                <li class="{{ Ekko::isActiveURL('/settings') }}">
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
        <!-- <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> -->
        {{ Session::get('flash_message') }}
      </div>
      @endif
      @if(Session::get('flash_error') != null)
      <div class="alert alert-danger alert-dismissible" style="margin-top: -20px;">
        <!-- <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> -->
        {{ Session::get('flash_error') }}
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
    <script>
    mapsApiKey="{{ env('GOOGLE_MAPS_API_KEY')}}";
    </script>
<!--
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.bundle.min.js"></script>
    <script src="/js/bootbox.min.js"></script>
    <script src="/trumbowyg/trumbowyg.min.js"></script>
    <script src="/trumbowyg/plugins/base64/trumbowyg.base64.min.js"></script>

    <script src="/js/jquery.isonscreen.min.js"></script>
    <script src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.js"></script>
-->
<!--
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/1.5.16/clipboard.min.js"></script>
-->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="/js/app.js"></script>

    <script>
    </script>
  </body>
</html>
