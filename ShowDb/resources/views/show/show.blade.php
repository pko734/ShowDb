@extends('layouts.master')

@section('head')
<link href='/css/show.css' rel='stylesheet'>
@endsection

@section('title')
Show Viewer
@endsection

@section('content')


<div class="container">
  <div class="row">
    <div class="col-md-6">
      <form method="GET" action="/shows/{{ $show->id }}/edit">

    <div class="form-group">
      <label for="show_id">Show ID</label>
      <input disabled value="{{ $show->id }}"
	 type="text"
	 class="form-control"
	 id="show_id"
	 placeholder="">
    </div>

    <div class="form-group">
      <label for="show_date">Show Date</label>
      <input disabled value="{{ $show->date }}"
	 type="text"
	 class="form-control"
	 id="show_date"
	 placeholder="YYYY-MM-DD">
    </div>
    <div class="form-group">
      <label for="show_venue">Show Venue</label>
      <input disabled value="{{ $show->venue }}"
	 type="text"
	 class="form-control"
	 id="show_venue"
	 placeholder="Venue - City, State">
    </div>

    <label>Set List</label>
    <table class="table table-striped">
      <tbody>
	@foreach($show->setlistItems->sortBy('order') as $item)
	<tr class="item-row">
	  <td>{{ $item->order }}.
	<a href="/songs/{{ $item->song->id }}">{{ $item->song->title }}</a>
	  </td>
	  <td>
	@if( count($item->notes) > 0)
	<a target="_vids" href="{{ $item->notes->get(0)->note }}">
	  <i class="fa fa-youtube-play" aria-hidden="true"></i>
	</a>
	@endif
	  </td>
	  <td>
	@if($user && $user->admin)
	@if( count($item->notes) === 0)
	<small class="edit-video-btn"
	       data-item-id="{{ $item->id }}">
	  <span class="glyphicon glyphicon-pencil"></span>
	</small>
	@else
	<small class="delete-video-btn"
	       data-item-id="{{ $item->id }}"
	       data-video-id="{{ $item->notes->get(0)->id }}">
	  <span class="glyphicon glyphicon-remove"></span>
	</small>
	@endif
	@endif
	  </td>
	</tr>
	@endforeach

	<tr>
	  <td colspan="3">
	@if($user && $user->admin)
	<span class="input-grp-btn">
	  <button type="submit" class="pull-left btn btn-primary">Edit Show</button>
	</span>
	<span class="input-grp-btn">
	  <button id="deletebtn"
	      type="button"
	      class="pull-right btn btn-danger">
	    <span class="glyphicon glyphicon-trash"></span>
	  </button>
	</span>
	@endif
	  </td>
	</tr>
      </tbody>
    </table>
      </form>
    </div>
    <form id="deleteform" method="POST" action="/shows/{{ $show->id }}">
      {{ method_field('DELETE') }}
      {{ csrf_field() }}
    </form>
    <div class="col-md-6">
      <form method="POST" action="/shows/{{ $show->id }}/notes">
    {{ csrf_field() }}
    <div class="form-group">
      <label for="show_id">Show Notes</label>
      <table id="notetable" class="table table-striped">
	<tbody>
	  @forelse($show->notes as $note)
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
	  <!--
	  <div class="form-group">
	    <small class="form-text text-muted">
	      <em>{{ $note->creator->username or $note->creator->name }}</em>
	    </small>
	  </div>
	  -->
	</td>
	  </tr>
	  @empty
	  <tr><td>No notes</td></tr>
	  @endforelse
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

      <form id="deletenoteform" method="POST" action="/shows/{{ $show->id }}/notes/">
    {{ method_field('DELETE') }}
    {{ csrf_field() }}
      </form>

      <form id="addvideoform" method="POST" action="#">
    <input id="videoinput" type="hidden" name="video_url" value="">
    {{ csrf_field() }}
      </form>

      <form id="deletevideoform" method="POST" action="#">
    {{ csrf_field() }}
    {{ method_field('DELETE') }}
      </form>

    </div>
  </div>

</div>

<script src="/js/showshow.js"></script>

@endsection
