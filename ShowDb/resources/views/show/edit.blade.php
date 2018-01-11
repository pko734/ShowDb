@extends('layouts.master')
@section('title')
Show Editor
@endsection
@section('content')
<div class="container">
  <div class="panel panel-default">
    <div class="panel-body">
      <form method="POST" action="{{ dirname(url()->current()) }}">
        {{ method_field('PUT') }}
        {{ csrf_field() }}
        @if($displayShowDate)
        <div class="form-group">
          <label for="show_date">Show Date</label>
          <input value="{{ $show->date }}"
		 name="date"
		 type="text"
		 class="form-control"
		 id="show_date"
		 placeholder="YYYY-MM-DD">
        </div>
        @else
        <input value="{{ $show->date }}"
               name="date"
               type="hidden"
               class="form-control"
               id="show_date"
               placeholder="YYYY-MM-DD">
        @endif
        <div class="form-group">
          <label for="show_venue">Show {{ $venueDisplay }}</label>
          <input value="{{ $show->venue }}"
		 name="venue"
		 type="text"
		 class="form-control"
		 id="show_venue"
		 placeholder="Venue - City, State">
        </div>
        <label for="show_setlist">Set List</label>
        @if($displayComplete)
        <div class="form-group">
          <label class="radio-inline">
            <input type="radio" name="complete" value="1"
		   @if(!$show->incomplete_setlist)
            checked
            @endif
            >Complete
          </label>
          <label class="radio-inline">
            <input type="radio" name="complete" value="0"
		   @if($show->incomplete_setlist)
            checked
            @endif
            >Incomplete
          </label>
        </div>
        @endif
        <table id="setlisttable" class="table table-striped">
          <tbody>
            @foreach($show->setlistItems->sortBy('order') as $item)
            <tr>
              <td>
                <span class="ac-song-title">
                  <input name="songs[]"
			 value="{{ $item->song->title }}"
			 class="form-control typeahead"
			 type="text"
			 placeholder="Song Title">
                </span>
              </td>
              @if($item->song->title === "Pretty Girl from Annapolis")
              <td>
                <span class="ac-song-title">
                  <input name="interlude_song"
			 value="@if($item->interludeSong){{ $item->interludeSong->title }}@endif"
			 class="form-control typeahead"
			 type="text"
			 placeholder="Interlude Song Title">
                </span>
              </td>
	      @endif
            </tr>
            @endforeach
          </tbody>
        </table>
        <button id="addbutton"
		type="button"
		class="btn btn-default">
          <span class="glyphicon glyphicon-plus"
		title="{{ $setlistItemAddTooltip}}"
		data-toggle="tooltip"
		data-placement="right"
		></span>
        </button>
        <button type="submit" class="pull-right btn btn-primary">Submit</button>
      </form>
    </div><!--/.panel-body-->
  </div><!--/.panel-->
</div>
@endsection
