@extends('layouts.master')

@section('title')
Song Editor
@endsection

@section('content')

<div class="container">
  <div class="panel panel-default">
    <div class="panel-body">
      <form method="POST" action="/songs/{{ $song->id }}">

	    {{ method_field('PUT') }}
	    {{ csrf_field() }}

	    <div class="form-group">
	      <label for="show_id">Song ID</label>
	      <input disabled value="{{ $song->id }}"
		         type="text"
		         class="form-control"
		         id="song_id"
		         placeholder="">
	    </div>

	    <div class="form-group">
	      <label for="song_title">Song Title</label>
	      <input value="{{ $song->title }}"
		         name="title"
		         type="text"
		         class="form-control"
		         id="song_title"
		         placeholder="Song Title">
	    </div>
	    <div class="form-group">
	      <label for="spotify_link">Spotify Link</label>
	      <input value="{{ $song->spotify_link }}"
		         name="spotify_link"
		         type="text"
		         class="form-control"
		         id="spotify_link"
		         placeholder="Spotify Link">
	    </div>
	    <button type="submit" class="btn btn-primary">Submit</button>
      </form>
    </div>
  </div>
</div>

@endsection
