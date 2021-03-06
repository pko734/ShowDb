@extends('layouts.master')

@section('title')
Songs ({{ $user->username }})
@endsection

@section('content')

<div class="panel panel-default container">
  <div class="panel-heading row">
    <h1>Songs</h1>
    <p><em>A listing of songs performed by The Avett Brothers for user: <b>{{ $user->username }}</b>
	@if($q)
	in <b>{{ $q }}</b>
	@endif
    </em></p>
  </div>

  <div class="is-table panel-body">
    <div class="is-table-col col-xs-9">

      <form action="/songs" method="POST">
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
		<i class="far fa-file"
		   data-toggle="tooltip"
		   data-placement="right"
		   title="{{ $song->notes_count }} notes"
		   aria-hidden="true"></i>
		@endif
	      </td>
	      <td><a href="/songs/{{ $song->id }}">{{ $song->title }}</a></td>
	      <td style="text-align: center;">
		<a href="/stats/{{ $user->username }}/songs/{{ $song->id }}/plays">
		  <strong>{{ $song->setlist_items_count }}</strong>
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
    <div class="is-table-col col-xs-3 image-col">
      @include('widgets.slider', ['slides' =>
      array_map(function($a){ return "/{$a}"; }, glob('sliderimages/*.jpg'))
      ] )
    </div><!--/.is-table-col-->
  </div><!--/.is-table-->
  <div class="panel-footer row">
    <div class="pull-right">
      {!! $songs->render() !!}
    </div>
    <div style="clear:both;"></div>
  </div>
</div><!--/.panel-->

@endsection
