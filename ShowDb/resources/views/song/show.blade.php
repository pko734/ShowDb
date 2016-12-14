@extends('layouts.master')

@section('head')
<link href='/css/song.css' rel='stylesheet'>
@endsection

@section('title')
Song Viewer
@endsection

@section('content')

<div class="container">
  <div class="row row-grid">
    <div class="col-md-6">

      <form method="GET" action="/songs/{{ $song->id }}/edit">

	<div class="form-group">
	  <label for="song_title">Song Title</label>
	  <input disabled
		 value="{{ $song->title }}"
		 name="title"
		 type="text"
		 class="form-control"
		 id="song_title"
		 placeholder="Song Title">
	</div>


	<div class="form-group">
	  <a href="/songs/{{ $song->id }}/plays">
	    Times played: {{ count($song->setlistItems) }}
	  </a>
	</div>

	@if($user && $user->admin)
	<button type="submit" class="pull-left btn btn-primary">Edit Song</button>&nbsp;
	<button id="deletebtn" type="button" class="btn btn-danger">
	  <span class="glyphicon glyphicon-trash"></span>
	</button>
	@endif
      </form>
    </div>

    <div class="col-md-6">

      <div class="form-group">
	<label>Song Notes</label>

	<form method="POST" action="/songs/{{ $song->id }}/notes">
	  {{ csrf_field() }}

	  <table id="notetable" class="table">
	    <tbody>
	      @include('notes', ['notes' => $song->notes])
	    </tbody>
	  </table>
	</form>

	<form id="deleteform" method="POST" action="/songs/{{ $song->id }}">
	  {{ method_field('DELETE') }}
	  {{ csrf_field() }}
	</form>

	<form id="deletenoteform" method="POST" action="/songs/{{ $song->id }}/notes/">
	  {{ method_field('DELETE') }}
	  {{ csrf_field() }}
	</form>

      </div>
    </div>
  </div>
</div>
<script src="/js/showsong.js"></script>
@endsection
