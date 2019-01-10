@extends('layouts.master')
@section('title')
User Finder
@endsection
@section('content')

<div class="panel panel-default container">
  <div class="panel-heading row">
    <div class="col-lg-6 col-md-6">
      <h1>Users</h1>
      <p><em>Database users that have chosen to make their stats public</em></p>
      @if(!$user->share)
      <p><b>Your stats are currently NOT shared.  To share them, go to the <em>Settings</em> menu.</b></p>
      @else
      <p>Your stats are currently shared!  This is configurable under the <em>Settings</em> menu.</p>
      @endif
      <p><em>An asterisk(*) indicates the user has the <a href="https://www.patreon.com/avettdb">donor badge</a></em></p>
    </div>
    <div class="col-lg-6 col-md-6" style="margin-top: 20px">
      <form action="{{ url()->current() }}" method="GET" role="search">
	    <div class="input-group">
	      <input type="text" class="form-control" name="q"
		         placeholder="Search Users" value="{{ $query or '' }}">
	      <span class="input-group-btn" style="vertical-align:top;">
	        <button type="submit" class="btn btn-default">
	          <span class="glyphicon glyphicon-search"></span>
	        </button>
	      </span>
	    </div>
      </form>
    </div>
  </div>

  <div class="is-table panel-body">
    <div class="is-table-col col-xs-9">

      <form action="{{ url()->current() }}" method="POST">
        {{csrf_field() }}
        <table id="showtable" class="table table-striped">
          <thead>
            <tr>
	          <th>
		        <a href="/users">
		          @if($order == "shows_count" && $donorsFirst)<u>@endif
		          *
		          @if($order == "shows_count" && $donorsFirst)<u>@endif
		        </a>
	          </th>
	          <th>
		        <a href="{{ Request::fullUrlWithQuery(['o' => $userOrder, 'page' => 1]) }}">
		          @if($order == "username")<u>@endif
		          Username
  	              @if($order == "username")</u>@endif
		        </a>
	          </th>
	          <th>
		        <a href="{{ Request::fullUrlWithQuery(['o' => $showOrder, 'page' => 1]) }}">
		          @if($order == "shows_count" && !$donorsFirst)<u>@endif
                    Shows
  	              @if($order == "shows_count" && !$donorsFirst)</u>@endif
		        </a>
	          </th>
	          <th width="1px">
		        <a href="{{ Request::fullUrlWithQuery(['o' => $randomOrder, 'page' => 1]) }}">
		          @if($order == "random")<u>@endif
		          Randomize
  	              @if($order == "random")</u>@endif
		        </a>
	          </th>
            </tr>
          </thead>
          <tbody>
            @forelse($users as $u)
            <tr>
	          <td width="1px">
                @if ($u->donor)* @endif
	          </td>
	          <td>
		        <a href="/stats/{{ $u->username }}">
		          {{ $u->username }}
		        </a>
	          </td>
	          <td colspan="2">
		        @if ($u->shows_count === 0)
		        -
		        @else
		        <strong>{{ $u->shows_count }}</strong>
		        @endif
	          </td>
            </tr>
            @empty
            <tr>
	          <td colspan="4">No matches</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </form>
    </div><!--.is-table-col-->

    <div class="is-table-col col-xs-3 image-col">
      @include('widgets.slider', ['slides' => 
      array_map(function($a){ return "/{$a}"; }, glob('sliderimages/*.jpg'))
      ] )
    </div>

  </div><!--/.is-table-->


  <div class="panel-footer row">
    <div class="pull-right">
      @if($order != "random")
      {!! $users->render() !!}
      @else
      <i>Cannot paginate random order!</i>
      @endif
    </div>
    <div style="clear:both;"></div>
  </div>
</div><!--/.panel-->
@endsection
