@extends('layouts.master')
@section('title')
{{ $show->date }} {{ $show->venue }}
@endsection
@section('content')
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
            'showId' => $show->id,
	    'username' => (isset($user)) ? $user->name : '',
            'showDetail' => "{$show->date} {$show->venue}",
        ]); ?>
    </script>
<div class="container">

  <div class="col-md-6">
    <div class="panel panel-default">
      <div class="panel-body">
	<form method="GET" action="{{ url()->current() }}/edit">
	  @if($displayShowDate)
	  <div class="form-group">
	    <label for="show_date">Show Date</label>
	    <input disabled value="{{ $show->date }}"
		   type="text"
		   class="form-control"
		   id="show_date"
		   placeholder="YYYY-MM-DD">
	  </div>
	  @else
	  <input disabled value="{{ $show->date }}"
		 type="hidden"
		 class="form-control"
		 id="show_date"
		 placeholder="YYYY-MM-DD">
	  @endif
	  <div class="form-group">
	    <label for="show_venue">Show {{ $venueDisplay }}</label>
	    <input disabled value="{{ $show->venue }}"
		   type="text"
		   class="form-control"
		   id="show_venue"
		   placeholder="Venue - City, State">
	  </div>
	  <div class="form-group">
	    <label>Photos</label>
	    <div>
	       <i class="clickable photo-add-btn fa fa-plus" title="Add a photo"></i>&nbsp;
	    @foreach($images as $img)
	       @if($img->published ||
	           ($user && $user->admin) ||
	           ($user && ($user->id == $img->user_id)))
	    <a href="{{ $img->url }}" 
	       data-toggle="lightbox" 
	       data-gallery="show_photos"
	       title="@if(!$img->published) Pending approval @endif"
	       data-footer='
	       @if($img->caption)
	       <b>Photo Caption: </b>{{ $img->caption }}
	       <br/>
	       @endif
	       @if($img->photo_credit)
	       <b>Photo Credit:</b> {{ $img->photo_credit }}
	       @endif
	       @if($user && $user->admin)
	       <div class="stats"
	       <span class="input-grp-btn stat-item">
		 <button type="button"
			 class="photo-delete-btn btn btn-danger pull-right"
			 title="Delete Photo"
			 data-photo-id="{{ $img->id }}">
		   <span class="glyphicon glyphicon-trash"></span>
		 </button>
	       </span>
	       @if(!$img->published)
	       <span class="input-grp-btn stat-item">
		 <button type="button" class="photo-approve-btn btn btn-success"
			 data-photo-id="{{ $img->id }}" 
			 title="Approve Photo">
		   <span class="glyphicon glyphicon-check"></span>
		 </button>
	       </span>
	       @endif
	       @endif
	       '
	       >
	       <i class="fa fa-camera fa-lg
			 @if($img->published)
			 text-primary
			 @else 
			 text-danger
			 @endif" 
		  aria-hidden="true"></i>
	    </a>
	    @endif
	    @endforeach
	    </div>
	  </div>
	  <label>
	    Set List
	  </label>
	  @if($displayComplete)
	  @if($show->incomplete_setlist)
	  <span class="incomplete-setlist">(incomplete)</span>
	  @else
	  <span class="complete-setlist">(complete)</span>
	  @endif
	  @endif
	  <table class="table table">
	    <tbody>
	      @foreach($show->setlistItems->sortBy('order') as $item)
	      <tr class="item-row">
		<td>{{ $item->order }}.
		  <a href="/songs/{{ $item->song->id }}">{{ $item->song->title }}</a>
		  @if($item->interlude_song_id)
		  <br/><em>Interlude: {{ $item->interludeSong->title }}</em>
		  @endif
		</td>
		<td>
		  @if( (count($item->notes) > 0) && ($item->notes->get(0)->published || ($user && $user->id == $item->notes->get(0)->creator->id)))
		  <a target="_vids" data-toggle="lightbox" data-width="1280" href="{{ $item->notes->get(0)->note }}">
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
		  @if(($user && $user->admin) || ($user && ($show->user_id == $user->id)))
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
    </div></div>
  </div>
  <form id="delete-show-form" method="POST" action="{{ url()->current() }}">
    {{ method_field('DELETE') }}
    {{ csrf_field() }}
  </form>
  <div class="col-md-6">
    <form id="show-note-form" method="POST" action="{{ url()->current() }}/notes">
      {{ csrf_field() }}
      <div class="form-group">
	<table id="notetable" class="table">
	  <tbody>
	    @include('notes', ['notes' => $show->notes, 'type' => 'show', 'add_tooltip' => $noteTooltip])
	  </tbody>
	</table>
      </div>
    </form>
    <form id="delete-show-note-form" method="POST" action="{{ url()->current() }}/notes/">
      {{ method_field('DELETE') }}
      {{ csrf_field() }}
    </form>
    <form id="delete-photo-form" method="POST" action="{{ url()->current() }}/photos/">
      {{ method_field('DELETE') }}
      {{ csrf_field() }}
    </form>
    <form id="edit-show-note-form" method="POST" action="{{ url()->current() }}/notes/">
      {{ method_field('PUT') }}
      {{ csrf_field() }}
      <input type="hidden" name="note" value="">
    </form>
    <form id="approve-photo-form" method="POST" action="{{ url()->current() }}/photos/">
      {{ method_field('PUT') }}
      {{ csrf_field() }}
      <input type="hidden" name="published" value="1">
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
@endsection
