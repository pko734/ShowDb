@extends('layouts.master')
@section('title')
Song Finder
@endsection
@section('content')
  <div class="panel panel-default container">
    <div class="panel-heading row">
      <div class="col-lg-6 col-md-6">
	<h1>Songs</h1>
	<p><em>A listing of songs The Avett Brothers have performed</em></p>
      </div>
      <div class="col-lg-6 col-md-6" style="margin-top: 20px">
	<form action="{{ url()->current() }}" method="GET" role="search">
	  <div class="input-group">
	    <input type="text" class="form-control" name="q"
		   placeholder="Search Songs" value="{{ $query or '' }}">
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
	<form action="/songs" method="POST">
	  {{ csrf_field() }}
	  <table id="songtable" class="table table-striped">
	    <thead>
	      <tr>
		<th width="1px"></th>
		<th>
		  <a href="{{ Request::fullUrlWithQuery(['o' => $titleOrder]) }}">
		    Title
		  </a>
		</th>
		<th style="text-align:center;">
		  <a href="{{ Request::fullUrlWithQuery(['o' => $setlistItemOrder]) }}">
		    Play Count
		  </a>
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
		<td><a href="/songs/{{ $song->id }}">{{ $song->title }}</a></td>
		<td style="text-align: center;">
		  <a href="/songs/{{ $song->id }}/plays">
		    <strong>{{ $song->setlist_items_count }}</strong>
		  </a>
		</td>
	      </tr>
	      @empty
	      <tr>
		<td colspan="2">No Matches</td>
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
      @if($user && $user->admin)
      <ul class="pagination">
	<li>
	  <button id="addbutton" type="button" class="pull-left btn btn-default">
	    <span class="glyphicon glyphicon-plus"></span>
	  </button>
	</li>
      </ul>
      @endif
      <div class="pull-right">
	{!! $songs->render() !!}
      </div>
      <div style="clear:both;"></div>
    </div>
  </div><!--/.panel-->
@endsection
