@extends('layouts.master')

@section('title')
Album Finder
@endsection

@section('content')

<div class="container">
  <form action="/albums" method="GET" role="search">
    <div class="input-group">
      <input type="text" class="form-control" name="q"
	     placeholder="Search Albums" value="{{ $query or '' }}">
      <small class="form-text text-muted">examples: <em>2013, 2016-05, raleigh, jerry, etc</em></small>
      <span class="input-group-btn" style="vertical-align:top;">
	<button type="submit" class="btn btn-default">
	  <span class="glyphicon glyphicon-search"></span>
	</button>
      </span>
    </div>
  </form>
</div>

<div class="container">
  <form action="/albums" method="POST">
    {{csrf_field() }}
    <table id="albumtable" class="table table-striped">
      <thead>
	<tr>
	  <th width="1px"></th>
	  <th>
	    <a href="{{ Request::fullUrlWithQuery(['o' => $date_order]) }}">
	      Release Date
	    </a>
	  </th>

	  <th>
	    <a href="{{ Request::FullUrlWithQuery(['o' => $album_item_order]) }}">
	      Songs
	    </a>
	  </th>
	  <th>Album Title</th>
	</tr>
      </thead>
      <tbody>
	@forelse($albums as $album)
	<tr>
	  <td>
	    <span style="white-space:nowrap;">
	  @if($album->notes_count > 0)
	  <i class="fa fa-files-o"
	     data-toggle="tooltip"
	     data-placement="right"
	     title="{{ $album->notes_count }} notes"
	     aria-hidden="true"></i>
	  @endif

	    </span>
	  </td>
	  <td>{{ $album->release_date }}</td>
	  <td>
	    @if ($album->album_items_count === 0)
	    -
	    @else
	    {{ $album->album_items_count }}
	    @endif
	  </td>
	  <td>
	    <a href="/albums/{{ $album->id }}">
	      {{ $album->title }}
	    </a>
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
  @if($user && $user->admin)
  <ul class="pagination">
    <li>
      <button id="albumaddbutton" type="button" class="pull-left btn btn-default">
	<span class="glyphicon glyphicon-plus"></span>
      </button>
    </li>
  </ul>
  @endif

  {!! $albums->render() !!}

</div>

<form method="POST" id="user-add-album-form" action="">
    {{ csrf_field() }}
</form>

<form method="POST" id="user-remove-album-form" action="">
    {{ method_field('DELETE') }}
    {{ csrf_field() }}
</form>

@endsection
