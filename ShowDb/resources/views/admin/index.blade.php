@extends('layouts.master')

@section('head')
<link href='/css/show.css' rel='stylesheet'>
@endsection

@section('title')
Admin
@endsection

@section('content')

<div class="container">
  <div class="row">

    <div id="show-note-column" class="col-md-4">
      <label>Show Notes</label>
      @include('admin.notes', ['notes' => $show_notes, 'type' => 'show'])
    </div>

    <div id="song-note-column" class="col-md-4">
      <label>Song Notes</label>
	@include('admin.notes', ['notes' => $song_notes, 'type' => 'song'])
    </div>

    <div id="video-note-column" class="col-md-4">
      <label>Videos</label>
	@include('admin.videos', ['notes' => $videos])
    </div>

  </div>
</div>

<form id="show-note-delete-form" method="POST" action="#">
  {{ method_field('DELETE') }}
  {{ csrf_field() }}
</form>

<form id="song-note-delete-form" method="POST" action="#">
  {{ method_field('DELETE') }}
  {{ csrf_field() }}
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

<form id="video-note-approve-form" method="POST" action="#">
  {{ method_field('PUT') }}
  {{ csrf_field() }}
  <input type="hidden" name="published" value="1">
</form>

<script src="/js/admin.js"></script>
@endsection
