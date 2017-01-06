@extends('layouts.master')

@section('title')
Show Editor
@endsection

@section('content')

<div class="container">
  <form method="POST" action="/shows/{{ $show->id }}">

    {{ method_field('PUT') }}
    {{ csrf_field() }}

    <div class="form-group">
      <label for="show_id">Show ID</label>
      <input disabled value="{{ $show->id }}"
	     type="text"
	     class="form-control"
	     id="show_id"
	     placeholder="">
    </div>

    <div class="form-group">
      <label for="show_date">Show Date</label>
      <input value="{{ $show->date }}"
	     name="date"
	     type="text"
	     class="form-control"
	     id="show_date"
	     placeholder="YYYY-MM-DD">
    </div>
    <div class="form-group">
      <label for="show_venue">Show Venue</label>
      <input value="{{ $show->venue }}"
	     name="venue"
	     type="text"
	     class="form-control"
	     id="show_venue"
	     placeholder="Venue - City, State">
    </div>

    <label for="show_setlist">Set List</label>
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
	</tr>
	@endforeach
      </tbody>
    </table>

    <button id="addbutton" type="button" class="btn btn-default">
      <span class="glyphicon glyphicon-plus"></span>
    </button>
    <button type="submit" class="pull-right btn btn-primary">Submit</button>
  </form>

</div>

@endsection
