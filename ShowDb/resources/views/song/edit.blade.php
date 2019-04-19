@extends('layouts.master')

@section('title')
Song Editor
@endsection

@section('content')

<div class="container">
  <div class="panel panel-default">
    <div class="panel-body">
      <form method="POST" action="/songs/{{ $song->id }}" enctype="multipart/form-data">

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
	<div class="form-group">
	  <label for="lyrics">Lyrics</label>
	  <textarea 
             rows="20"
	     name="lyrics"
	     class="form-control"
	     id="lyrics"
	     placeholder="Lyrics">{{ $song->lyrics }}</textarea>
	</div>
	<div class="form-group">
	  <label for="snip">10 Second Snip</label>
	  @if($song->snipUrl)
	  <br/>
	  <audio controls>
	    <source src="{{ $song->snipUrl }}" type="audio/mpeg">
	      Your browser doesn't support the audio tag
	  </audio>	  
	  @endif
	  <input id="fupload" class="form-control" name="snip" type="file">
	</div>
	<button type="submit" class="btn btn-primary">Submit</button>
      </form>
    </div>
  </div>
</div>

@endsection
