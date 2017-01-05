@extends('layouts.master')

@section('title')
Show Finder
@endsection

@section('content')

<div class="container">
  <form action="/shows" method="GET" role="search">
    <div class="input-group">
      <input type="text" class="form-control" name="q"
	     placeholder="Search Shows" value="{{ $query or '' }}">
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
  <form action="/shows" method="POST">
    {{csrf_field() }}
    <table id="showtable" class="table table-striped">
      <thead>
	<tr>
	  <th width="1px"></th>
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
	    @if ($show->setlist_items_count === 0)
	    -
	    @else
	    {{ $show->setlist_items_count }}
	    @endif
	  </td>
	  <td>
	    @if($user && $show->users->contains($user->id))
	    <a data-toggle="tooltip"
	       data-placement="left"
	       class="remove-show-link"
	       data-show-id="{{ $show->id }}"
	       title="Remove from my shows" href="">
	      <i style="color: green;" class="fa fa-check-square-o" aria-hidden="true"></i></a>

	    @elseif($user)
	    <a data-toggle="tooltip"
	       data-placement="left"
	       class="add-show-link"
	       data-show-id="{{ $show->id }}"
	       title="Add to my shows" href="">
	      <i style="color: green;" class="fa fa-square-o" aria-hidden="true"></i></a>
	    @endif
	    <a href="/shows/{{ $show->id }}">
	      {{ $show->venue }}
	    </a>
	  </td>
	</tr>
	@empty
	<tr>
	  <td colspan="3">No matches</td>
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

<form method="POST" id="user-add-show-form" action="">
    {{ csrf_field() }}
</form>

<form method="POST" id="user-remove-show-form" action="">
    {{ method_field('DELETE') }}
    {{ csrf_field() }}
</form>

@endsection
