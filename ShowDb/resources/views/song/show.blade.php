@extends('layouts.master')
@section('title')
{{ $song->title }}
@endsection
@section('content')
<div class="container">
  <div class="col-md-6">
    <div class="panel panel-default">
      <div class="panel-body">
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
	      Times played: {{ $song->getShowCount() }}
	    </a>
	  </div>
	  @if($user && $user->admin)
	  <button type="submit" class="pull-left btn btn-primary">Edit Song</button>&nbsp;
	  <button id="delete-song-btn" type="button" class="pull-right btn btn-danger">
	    <span class="glyphicon glyphicon-trash"></span>
	  </button>
	  @endif
	</form>
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group">
      <form id="song-note-form" method="POST" action="/songs/{{ $song->id }}/notes">
	{{ csrf_field() }}
	<table id="notetable" class="table">
	  <tbody>
	    @include('notes', ['notes' => $song->notes, 'type' => 'song', 'add_tooltip' => 'Why is this song special to you?'])
	  </tbody>
	</table>
      </form>
      <form id="delete-song-form" method="POST" action="/songs/{{ $song->id }}">
	{{ method_field('DELETE') }}
	{{ csrf_field() }}
      </form>
      <form id="edit-song-note-form" method="POST" action="/songs/{{ $song->id }}/notes/">
	{{ method_field('PUT') }}
	{{ csrf_field() }}
	<input type="hidden" name="note" value="">
      </form>
      <form id="delete-song-note-form" method="POST" action="/songs/{{ $song->id }}/notes/">
	{{ method_field('DELETE') }}
	{{ csrf_field() }}
      </form>
    </div>
  </div>
</div>
@endsection
