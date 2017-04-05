@extends('layouts.master')

@section('title')
Albums ({{ $user->username }})
@endsection

@section('content')

<div class="container">
  <div class="panel panel-default">
    <div class="panel-heading">

      <h3>Album Songs ({{ $user->username }})</h3>
      <form id="album-form" action="{{ url()->current() }}" method="GET" role="search">
	<div class="form-group">
	  <select class="form-control" id="album-select" name="id">
	    @foreach($albums as $album)
	    <option value="{{ $album->id }}"
		    @if($album_id == $album->id)
	      SELECTED
	      @endif
	      >
	      {{ $album->title }} ({{ date_format(new DateTime($album->release_date),'Y') }})
	    </option>
	    @endforeach
	  </select>
	</div>
      </form>
    </div><!--/.panel-heading-->
    <div class="panel-body is-table">
      <div class="is-table-col col-xs-3 image-col">
	@include('widgets.slider', ['slides' => [
	'http://thelstory.weebly.com/uploads/2/1/7/1/21710700/3103595.jpg']
	])
      </div><!--/.is-table-col-->
      <div class="is-table-col col-xs-9">  <form action="/songs" method="POST">
	  {{ csrf_field() }}
	  <table id="songtable" class="table table-striped">
	    <thead>
	      <tr>
		<th width="1px"></th>
		<th>
		  Title
		</th>
		<th style="text-align:center;">
		  Play Count
		</th>
	      </tr>
	    </thead>
	    <tbody>
	      @forelse($songs as $song)
	      <tr>
		<td>
		  @if($song->notes_count > 0)
		  <i class="fa fa-files-o"
		     data-toggle="tooltip"
		     data-placement="right"
		     title="{{ $song->notes_count }} notes"
		     aria-hidden="true"></i>
		  @endif
		</td>
		<td>
		  @if(!$song_counts[$song->id])
		  <i class="fa"></i>
		  @else
		  <i class="fa fa-check" style="color:green;"></i>
		  @endif
		  <a href="/songs/{{ $song->id }}">
		    {{ $song->title }}
		  </a>
		</td>
		<td style="text-align: center;">
		  <a href="/stats/{{ $user->username }}/songs/{{ $song->id }}/plays">
		    <strong>{{ $song_counts[$song->id] }}</strong>
		  </a>
		</td>
	      </tr>
	      @empty
	      <tr>
		<td colspan="3">No Matches</td>
	      </tr>
	      @endforelse

	    </tbody>
	  </table>
	</form>
      </div><!--/.is-table-col-->
    </div><!--/.is-table-->
    <div class="panel-footer">
    </div><!--/.panel-footer-->
  </div><!--/.panel-->
</div><!--/.container-->

@endsection
