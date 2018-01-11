@extends('layouts.master')

@section('title')
Admin
@endsection

@section('content')

<div class="container">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h3>Admin Panel</h3>
    </div>
    <div class="panel-body">
      <div class="row">
	<div class="col-md-12">
	  <label>Approve Photos</label>
	  <p>
	  @forelse($photoShows as $show)
	  <a href="/shows/{{ $show->id }}">
	    {{ $show->date }} {{ $show->venue }}
	  </a>
	  <br />
	  @empty
	  N/A
	  @endforelse
	  </p>
	</div>
      </div>
      <div class="row">
      <div id="show-note-column" class="col-md-3">
        <label>Show Notes</label>
        @include('admin.notes', ['notes' => $showNotes, 'type' => 'show'])
      </div>

      <div id="song-note-column" class="col-md-3">
        <label>Song Notes</label>
        @include('admin.notes', ['notes' => $songNotes, 'type' => 'song'])
      </div>

      <div id="album-note-column" class="col-md-3">
        <label>Album Notes</label>
        @include('admin.notes', ['notes' => $albumNotes, 'type' => 'album'])
      </div>

      <div id="video-note-column" class="col-md-3">
        <label>Videos</label>
        @include('admin.videos', ['notes' => $videos])
      </div>
      </div>
    </div>
  </div>
</div>

<form id="show-note-delete-form" method="POST" action="#">
  {{ method_field('DELETE') }}
  {{ csrf_field() }}
</form>

<form id="show-note-edit-form" method="POST" action="#">
  {{ method_field('PUT') }}
  {{ csrf_field() }}
  <input type="hidden" name="note" value="">
</form>

<form id="album-note-delete-form" method="POST" action="#">
  {{ method_field('DELETE') }}
  {{ csrf_field() }}
</form>

<form id="album-note-edit-form" method="POST" action="#">
  {{ method_field('PUT') }}
  {{ csrf_field() }}
  <input type="hidden" name="note" value="">
</form>

<form id="song-note-delete-form" method="POST" action="#">
  {{ method_field('DELETE') }}
  {{ csrf_field() }}
</form>

<form id="song-note-edit-form" method="POST" action="#">
  {{ method_field('PUT') }}
  {{ csrf_field() }}
  <input type="hidden" name="note" value="">
</form>

<form id="video-note-delete-form" method="POST" action="#">
  {{ method_field('DELETE') }}
  {{ csrf_field() }}
</form>

<form id="show-note-approve-form" method="POST" action="#">
  {{ method_field('PUT') }}

  {{ csrf_field() }}
  <input type="hidden" name="published" value="1">
</form>

<form id="song-note-approve-form" method="POST" action="#">
  {{ method_field('PUT') }}
  {{ csrf_field() }}
  <input type="hidden" name="published" value="1">
</form>

<form id="album-note-approve-form" method="POST" action="#">
  {{ method_field('PUT') }}
  {{ csrf_field() }}
  <input type="hidden" name="published" value="1">
</form>

<form id="video-note-approve-form" method="POST" action="#">
  {{ method_field('PUT') }}
  {{ csrf_field() }}
  <input type="hidden" name="published" value="1">
</form>

@endsection
