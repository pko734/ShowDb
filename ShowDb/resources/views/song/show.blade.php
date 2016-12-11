@extends('layouts.master')

@section('head')
<link href='/css/song.css' rel='stylesheet'>
@endsection

@section('title')
Song Viewer
@endsection

@section('content')

<div class="container">
  <div class="row">
    <div class="col-md-6">

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
      <input disabled
	 value="{{ $song->title }}"
	 name="title"
	 type="text"
	 class="form-control"
	 id="song_title"
	 placeholder="Song Title">
    </div>

    <div>
      <label>
	<a href="/songs/{{ $song->id }}/plays">
	  Times played: {{ count($song->setlistItems) }}
	</a>
      </label>
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
    </div>
    <div class="col-md-6">
      <form method="POST" action="/songs/{{ $song->id }}/notes">
    {{ csrf_field() }}
    <div class="form-group">
      <label>Song Notes</label>
      <table id="notetable" class="table table-striped">
	<tbody>
	  @foreach($song->notes as $note)
	  <tr>
	<td>
	  {!! $note->note !!}
	  @if(($user && $user->admin) || ($user && $user->id == $note->user_id))
	  <span class="input-grp-btn">
	    <button type="button" class="notedeletebutton pull-right pull-up btn btn-default"
		data-note-id="{{ $note->id }}">
	      <span class="glyphicon glyphicon-trash"></span>
	    </button>
	  </span>
	  @endif
	  <div class="form-group">
	  <small class="form-text text-muted">
	    <em>by {{ $note->creator->username or $note->creator->name }}</em>
	  </small>
	  </div>
	</td>
	  </tr>
	  @endforeach

	  <tr>
	<td>
	  @if($user)
	  <span class="input-grp-btn">
	    <button id="noteaddbutton" type="button" class="pull-left btn btn-default">
	      <span class="glyphicon glyphicon-plus"></span>
	    </button>
	  </span>
	  <span class="input-grp-btn">
	    <!-- right hand button -->
	  </span>
	  @endif
	</td>
	  </tr>

	</tbody>
      </table>
    </div>
      </form>
      <form id="deletenoteform" method="POST" action="/songs/{{ $song->id }}/notes/">
    {{ method_field('DELETE') }}
    {{ csrf_field() }}
      </form>
    </div>
  </div>
</div>
    <script src="/js/showsong.js"></script>
@endsection
