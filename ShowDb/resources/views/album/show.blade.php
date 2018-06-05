@extends('layouts.master')
@section('title')
{{ $album->title }}
@endsection
@section('content')
<div class="container">
  <div class="col-md-6">
    <div class="panel panel-default">
      <div class="panel-body">
	    <form method="GET" action="/albums/{{ $album->id }}/edit">
	      <div class="form-group">
	        <label for="album_date">Album Date</label>
	        <input disabled value="{{ $album->release_date }}"
		           type="text"
		           class="form-control"
		           id="album_date"
		           placeholder="YYYY-MM-DD">
	      </div>
	      <div class="form-group">
	        <label for="album_venue">Album Title</label>
	        <input disabled value="{{ $album->title }}"
		           type="text"
		           class="form-control"
		           id="album_title"
		           placeholder="Album Title">
	      </div>
          @if($album->spotify_link)
	      <div class="form-group">
	        <label for="album_spotify">Listen</label>
            <div>
	        {!! $album->spotify_link !!}
            </div>
	      </div>
          @endif
	      <label>
	        Song List
	      </label>
	      <table class="table table">
	        <tbody>
	          @foreach($album->albumItems->sortBy('order') as $item)
	          <tr class="item-row">
		        <td>{{ $item->order }}.
		          <a href="/songs/{{ $item->song->id }}">{{ $item->song->title }}</a>
		        </td>
		        <td>
		          @if( (count($item->notes) > 0) && ($item->notes->get(0)->published || ($user && $user->id == $item->notes->get(0)->creator->id)))
		          <i data-toggle="tooltip"
		             data-placement="left"
		             title="{{ $item->notes->get(0)->note }}"
		             class="fa fa-files-o" aria-hidden="true"></i>
		          @endif
		        </td>
		        <td>
		          @if($user && $user->admin)
		          @if( count($item->notes) === 0)
		          <small class="edit-item-btn"
			             data-item-id="{{ $item->id }}">
		            <span class="glyphicon glyphicon-pencil"></span>
		          </small>
		          @else
		          <small class="delete-item-btn"
			             data-item-id="{{ $item->id }}"
			             data-item-note-id="{{ $item->notes->get(0)->id }}">
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
		            <button type="submit" class="pull-left btn btn-primary">Edit Album</button>
		          </span>
		          <span class="input-grp-btn">
		            <button id="delete-album-btn"
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
      </div><!--/.panel-body-->
    </div><!--/.panel-->
  </div>
  <form id="delete-album-form" method="POST" action="/albums/{{ $album->id }}">
    {{ method_field('DELETE') }}
    {{ csrf_field() }}
  </form>
  <div class="col-md-6">
    <form id="album-note-form" method="POST" action="/albums/{{ $album->id }}/notes">
      {{ csrf_field() }}
      <div class="form-group">
	    <table id="notetable" class="table">
	      <tbody>
	        @include('notes', ['notes' => $album->notes, 'type' => 'album', 'add_tooltip' => 'What made this album special?'])
	      </tbody>
	    </table>
      </div>
    </form>
    <form id="delete-album-note-form" method="POST" action="/albums/{{ $album->id }}/notes/">
      {{ method_field('DELETE') }}
      {{ csrf_field() }}
    </form>
    <form id="edit-album-note-form" method="POST" action="/albums/{{ $album->id }}/notes/">
      {{ method_field('PUT') }}
      {{ csrf_field() }}
      <input type="hidden" name="note" value="">
    </form>
    <form id="add-item-form" method="POST" action="#">
      <input id="iteminput" type="hidden" name="item_note" value="">
      {{ csrf_field() }}
    </form>
    <form id="delete-item-form" method="POST" action="#">
      {{ csrf_field() }}
      {{ method_field('DELETE') }}
    </form>
  </div>
</div>
</div>
@endsection
