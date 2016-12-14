@extends('layouts.master')

@section('title')
Show Viewer
@endsection

@section('content')


<div class="container">
  <div class="row">
    <div class="col-md-6">
      <form method="GET" action="/shows/{{ $show->id }}/edit">

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
    <table class="table table">
      <tbody>
    @foreach($show->setlistItems->sortBy('order') as $item)
    <tr class="item-row">
      <td>{{ $item->order }}.
    <a href="/songs/{{ $item->song->id }}">{{ $item->song->title }}</a>
      </td>
      <td>
    @if( (count($item->notes)) > 0 && $item->notes->get(0)->published)
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
      <button id="delete-show-btn"
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
    <form id="delete-show-form" method="POST" action="/shows/{{ $show->id }}">
      {{ method_field('DELETE') }}
      {{ csrf_field() }}
    </form>
    <div class="col-md-6">
      <form method="POST" action="/shows/{{ $show->id }}/notes">
    {{ csrf_field() }}
    <div class="form-group">
      <label for="show_id">Show Notes</label>

      <table id="notetable" class="table">
    <tbody>
      @include('notes', ['notes' => $show->notes, 'type' => 'show'])
    </tbody>
      </table>
    </div>
      </form>

      <form id="delete-show-note-form" method="POST" action="/shows/{{ $show->id }}/notes/">
    {{ method_field('DELETE') }}
    {{ csrf_field() }}
      </form>

      <form id="add-video-form" method="POST" action="#">
    <input id="videoinput" type="hidden" name="video_url" value="">
    {{ csrf_field() }}
      </form>

      <form id="delete-video-form" method="POST" action="#">
    {{ csrf_field() }}
    {{ method_field('DELETE') }}
      </form>

    </div>
  </div>

</div>

@endsection
