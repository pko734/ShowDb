@extends('layouts.master')
@section('title')
Album Finder
@endsection
@section('content')

<div class="panel panel-default container">
  <div class="panel-heading row">
    <div class="col-lg-6 col-md-6">
      <h1>Albums</h1>
      <p><em>A listing of The Avett Brothers Albums</em></p>
    </div>
    <div class="col-lg-6 col-md-6" style="margin-top: 20px">
      <form action="{{ url()->current() }}" method="GET" role="search">
	<div class="input-group">
	  <input type="text" class="form-control" name="q"
		 placeholder="Search Albums" value="{{ $query ?? '' }}">
	  <span class="input-group-btn" style="vertical-align:top;">
	    <button type="submit" class="btn btn-default">
	      <span class="glyphicon glyphicon-search"></span>
	    </button>
	  </span>
	  @if($user && $user->admin)
	  <span class="input-group-btn" style="vertical-align:top;">
	    <button id="albumaddbutton" type="button" class="btn btn-default">
	      <span class="glyphicon glyphicon-plus"></span>
	    </button>
	  </span>
	  @endif
	</div>
      </form>
    </div>
  </div>

  <div class="panel-body is-table">
    <div class="is-table-col col-xs-9">
      <form action="/albums" method="POST">
	{{csrf_field() }}
	<table id="albumtable" class="table table-striped">
	  <thead>
	    <tr>
	      <th width="1px"></th>
	      <th>
		<a href="{{ Request::fullUrlWithQuery(['o' => $dateOrder]) }}">
		  Release Date
		</a>
	      </th>
	      <th>
		<a href="{{ Request::FullUrlWithQuery(['o' => $albumItemOrder]) }}">
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
		  <i class="far fa-file"
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
    </div><!--/.is-table-col-->
    <div class="is-table-col col-xs-3 image-col">
      @include('widgets.slider', ['slides' =>
      array_map(function($a){ return "/{$a}"; }, glob('sliderimages/*.jpg'))
      ] )
    </div><!--/.is-table-col-->
  </div><!--/.is-table-->

  <div class="panel-footer row">
    {!! $albums->render() !!}
  </div><!--/.panel-footer-->
</div><!--/.panel-->

<form method="POST" id="user-add-album-form" action="">
  {{ csrf_field() }}
</form>
<form method="POST" id="user-remove-album-form" action="">
  {{ method_field('DELETE') }}
  {{ csrf_field() }}
</form>
@endsection
