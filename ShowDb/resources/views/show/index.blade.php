@extends('layouts.master')

@section('head')
<link href='/css/show.css' rel='stylesheet'>
@endsection

@section('title')
Show Finder
@endsection

@section('content')

<div class="container">
  <form action="/shows" method="GET" role="search">
    <div class="input-group">
      <input type="text" class="form-control" name="q"
	 placeholder="Search Shows" value="{{ $query or '' }}">
      <small class="form-text text-muted">examples: <em>2013, 2016-05, Detroit, etc</em></small>
      <span class="input-group-btn" style="vertical-align:top;">
	<button type="submit" class="btn btn-default">
	  <span class="glyphicon glyphicon-search"></span>
	</button>
      </span>
    </div>
  </form>
</div>

<div class="container">
  <form action="/shows" method="POST">
    {{csrf_field() }}
  <table id="showtable" class="table table-striped">
    <thead>
      <tr>
    <th>ID</th>
    <th>
      <a href="{{ Request::fullUrlWithQuery(['o' => $date_order]) }}">
	Date
      </a>
    </th>
    <th>
      <a href="{{ Request::FullUrlWithQuery(['o' => $setlist_item_order]) }}">
	Songs
      </a>
    </th>
    <th>Venue</th>
      </tr>
    </thead>
    <tbody>
      @forelse($shows as $show)
      <tr>
	<td>{{ $show->id }}</td>
	<td>{{ $show->date }}</td>
	<td>
	  @if ($show->setlist_items_count === 0)
	  -
	  @else
	  {{ $show->setlist_items_count }}
	  @endif
	</td>
	<td><a href="/shows/{{ $show->id }}">{{ $show->venue }}</a></td>
      </tr>
      @empty
      <tr>
	<td colspan="4">No matches</td>
      </tr>
      @endforelse
    </tbody>
  </table>

  </form>
  @if($user && $user->admin)
  <ul class="pagination">
    <li>
      <button id="addbutton" type="button" class="pull-left btn btn-default">
    <span class="glyphicon glyphicon-plus"></span>
      </button>
    </li>
  </ul>
  @endif

  {!! $shows->render() !!}

</div>

<script src="/js/indexshows.js"></script>
@endsection
