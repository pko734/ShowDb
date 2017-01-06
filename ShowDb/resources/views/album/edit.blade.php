@extends('layouts.master')

@section('title')
Album Editor
@endsection

@section('content')

<div class="container">
  <form method="POST" action="/albums/{{ $album->id }}">

    {{ method_field('PUT') }}
    {{ csrf_field() }}

    <div class="form-group">
      <label for="album_id">Album ID</label>
      <input disabled value="{{ $album->id }}"
	     type="text"
	     class="form-control"
	     id="album_id"
	     placeholder="">
    </div>

    <div class="form-group">
      <label for="album_date">Album Release Date</label>
      <input value="{{ $album->release_date }}"
	     name="date"
	     type="text"
	     class="form-control"
	     id="album_date"
	     placeholder="YYYY-MM-DD">
    </div>
    <div class="form-group">
      <label for="album_venue">Album Title</label>
      <input value="{{ $album->title }}"
	     name="title"
	     type="text"
	     class="form-control"
	     id="album_title"
	     placeholder="Album Title">
    </div>

    <label for="album_songs">Songs</label>
    <table id="albumitemtable" class="table table-striped">
      <tbody>
	@foreach($album->albumItems->sortBy('order') as $item)
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

    <button id="albumitemaddbutton" type="button" class="btn btn-default">
      <span class="glyphicon glyphicon-plus"></span>
    </button>
    <button type="submit" class="pull-right btn btn-primary">Submit</button>
  </form>

</div>

@endsection
