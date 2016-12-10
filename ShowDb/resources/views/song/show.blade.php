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
    <span class="input-grp-btn">
      <button type="submit" class="pull-left btn btn-primary">Edit Song</button>
    </span>
    <span class="input-grp-button">
      <button id="deletebtn" type="button" class="pull-right btn btn-primary">Delete Song</button>
    </span>
    @endif
  </form>

  <form id="deleteform" method="POST" action="/songs/{{ $song->id }}">
    {{ method_field('DELETE') }}
    {{ csrf_field() }}
  </form>

</div>

<script src="/js/showsong.js"></script>
@endsection
