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
	    <div class="form-group">
	      <label for="show_state">State / Provence / Country</label>
	      <span class="ac-show-state">
	        <input value="{{ $show->state()->first() == null ? '' : $show->state()->first()->name }}"
                   name="state"
		           type="text"
		           class="form-control typeahead"
		           id="show_state"
		           placeholder="State Name">
	      </span>
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
            @php($encore_row_missing = true)
            @foreach($show->setlistItems->sortBy('order') as $item)
              @if($item->encore && $encore_row_missing)
	          <tr class="item-row">
		        <td>
                <span class="ac-song-title">
                  <input name="songs[]"
			             value=""
			             class="form-control typeahead"
			             type="text"
			             placeholder="Song Title">
                </span>
                </td>
              </tr>
              @php($encore_row_missing = false)
              @endif
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
