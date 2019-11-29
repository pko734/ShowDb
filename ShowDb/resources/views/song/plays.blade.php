@extends('layouts.master')
@section('title')
Plays: {{ $song->title }}
@endsection
@section('content')

  <div class="panel panel-default container">
    <div class="panel-heading row">

      <div class="col-lg-6 col-md-6">
	<h1>Shows</h1>
	<p>
	  <em>
	    A listing of shows where the selected song was played
	    @if(isset($userRestriction))
	    <strong>({{ $userRestriction->username }})</strong>
	    @endif
	  </em>
	</p>
      </div>
      <div class="col-lg-6 col-md-6" style="margin-top: 20px">
      <form action="/plays" method="GET" role="search">
	<label>
	  Find Shows Where A Song Was Played
	  @if(isset($userRestriction))
	  ({{ $userRestriction->username }})
	  @endif
	</label>
	<div id="plays-input" class="input-group">
	  <span class="ac-song-title">
	    <input name="title"
		   value="{{ $song->title }}"
		   class="form-control typeahead"
		   type="text"
		   placeholder="Song Title">
	    @if(isset($userRestriction))
	    <input type="hidden" name="username" value="{{ $userRestriction->username }}">
	    @endif
	  </span>
	  <span class="input-group-btn">
	    <button type="submit" class="btn btn-default">
	      <span class="glyphicon glyphicon-search"></span>
	    </button>
	  </span>
	</div>
      </form>
      </div>

    </div><!--/.panel-heading-->
    <div class="is-table panel-body">
      <div class="is-table-col col-xs-9">
	<table id="showtable" class="table table-striped">
	  <thead>
	    <tr>
	      <th width="1px"></th>
	      <th>
		<a href="{{ Request::fullUrlWithQuery(['d' => 'asc']) }}">
		  Date
		</a>
	      </th>
	      <th>Venue</th>
	    </tr>
	  </thead>
	  <tbody>
	    @forelse($shows as $show)
	    <tr>
	      <td>
		<span style="white-space:nowrap;">
		  @if($show->incomplete_setlist)
		  <i style="color: orange"
		     class="fa fa-exclamation"
		     data-toggle="tooltip"
		     data-placement="right"
		     title="Partial or incomplete setlist"
		     aria-hidden="true"></i>
		  @endif
		  @if($show->notes_count > 0)
		  <i class="far fa-file"
		     data-toggle="tooltip"
		     data-placement="right"
		     title="{{ $show->notes_count }} notes"
		     aria-hidden="true"></i>
		  @endif
		</span>
	      </td>
	      <td>{{ $show->date }}</td>
	      <td>
		@if($user && $show->users->contains($user->id))
		<a class="remove-show-link" data-show-id="{{ $show->id }}" title="Remove from my shows" href="">
		  <i style="color: green;" class="far fa-check-square" aria-hidden="true"></i></a>
		@elseif($user)
		<a class="add-show-link" data-show-id="{{ $show->id }}" title="Add to my shows" href="">
		  <i style="color: green;" class="far fa-square" aria-hidden="true"></i></a>
		@endif
		<a href="/shows/{{ $show->id }}">{{ $show->venue }}</a>
	      </td>
	    </tr>
	    @empty
	    <tr>
	      <td colspan="2">No matches</td>
	    </tr>
	    @endforelse
	  </tbody>
	</table>
      </div><!--/.is-table-col-->
      <div class="is-table-col col-xs-3 image-col">
	@include('widgets.slider', ['slides' =>
	array_map(function($a){ return "/{$a}"; }, glob('sliderimages/*.jpg'))
	] )
      </div>
    </div><!--/.is-table-->
    <div class="panel-footer">
      <div class=" pull-right">
	{!! $shows->render() !!}
      </div>
      <div style="clear:both;"></div>
    </div>
  </div><!--/.panel-->
  <form method="POST" id="user-add-show-form" action="">
    {{ csrf_field() }}
  </form>
  <form method="POST" id="user-remove-show-form" action="">
    {{ method_field('DELETE') }}
    {{ csrf_field() }}
  </form>
@endsection
