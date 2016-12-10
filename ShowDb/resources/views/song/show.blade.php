@extends('layouts.master')

@section('head')
<link href='/css/song.css' rel='stylesheet'>
@endsection

@section('title')
Song Viewer
@endsection

@section('content')

<div class="container">

  <form method="GET" action="/songs/{{ $song->id }}/edit">

    <div class="form-group">
      <label for="song_id">Song ID</label>
      <input disabled value="{{ $song->id }}"
         type="text"
         class="form-control"
         id="song_id"
         placeholder="">
    </div>

    <div class="form-group">
      <label for="song_title">Song Title</label>
      <input disabled value="{{ $song->title }}"
         name="title"
         type="text"
         class="form-control"
         id="song_title"
         placeholder="Song Title">
    </div>
    @if($user && $user->admin)
    <button type="submit" class="btn btn-primary">Edit</button>
    @endif
  </form>

</div>

@endsection
