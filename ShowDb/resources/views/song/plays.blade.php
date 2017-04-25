@extends('layouts.master')
@section('title')
Plays
@endsection
@section('content')
<div class="container">
<div class="panel panel-default">
  <div class="panel-heading">
    <form action="/plays" method="GET" role="search">
      <label>
	Find Shows Where A Song Was Played
	@if(isset($user_restriction))
	({{ $user_restriction->username }})
	@endif
      </label>
      <div id="plays-input" class="input-group">
	<span class="ac-song-title">
	  <input name="title"
	  value="{{ $song->title }}"
	  class="form-control typeahead"
	  type="text"
	  placeholder="Song Title">
	  @if(isset($user_restriction))
	  <input type="hidden" name="username" value="{{ $user_restriction->username }}">
	  @endif
	</span>
	<span class="input-group-btn">
	  <button type="submit" class="btn btn-default">
	  <span class="glyphicon glyphicon-search"></span>
	  </button>
	</span>
      </div>
    </form>
  </div><!--/.panel-heading-->
  <div class="is-table panel-body">
  <div class="is-table-col col-xs-3 image-col">
      @include('widgets.slider', ['slides' =>
	array_map(function($a){ return "/{$a}"; }, glob('sliderimages/*.jpg'))
      ] )
  </div>
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
		<i class="fa fa-files-o"
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
	      <i style="color: green;" class="fa fa-check-square-o" aria-hidden="true"></i></a>
	      @elseif($user)
	      <a class="add-show-link" data-show-id="{{ $show->id }}" title="Add to my shows" href="">
	      <i style="color: green;" class="fa fa-square-o" aria-hidden="true"></i></a>
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
</div><!--/.container-->
@endsection
