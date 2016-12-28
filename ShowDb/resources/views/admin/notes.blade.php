@forelse($notes as $note)
<div class="row">
  <div class="col-xs-12">
    <div class="panel panel-white post panel-shadow">
      <div class="post-heading">
	<div class="pull-left image">
	  @if($note->creator->avatar)
	  <img src="{{ $note->creator->avatar }}" class="img-circle avatar" alt="user profile image">
	  @endif
	</div>
	<div class="pull-left meta">
	  <div class="title h5">
	    <a href="#"><b>{{ $note->creator->name }}</b></a>
	    made a note.
	  </div>
	  <h6 class="text-muted time">
	    {{ \Carbon\Carbon::createFromTimeStamp($note->created_at->timestamp)->diffForHumans() }}</h6>
	</div>
      </div>
      <div class="post-description" data-parent-id="{{ $note->$type->id }}" data-note-id="{{ $note->id }}">
	<p>
	  @if(isset($note->show))
	  <a href="/shows/{{ $note->show->id }}">
	    {{ $note->show->date }} {{ $note->show->venue }}
	  </a>
	  @else
	  <a href="/songs/{{ $note->song->id }}">
	    {{ $note->song->title }}
	  </a>
	  @endif
	</p>
	<hr/>

	<span class="note-content">
	  {!! $note->note !!}
	</span>
	@if(($user && $user->admin) || ($user && $user->id == $note->user_id))
	<div class="stats">
	  <span class="input-grp-btn stat-item">
	    <button type="button" class="noteapprovebutton btn btn-success"
		    data-parent-id="{{ $note->$type->id }}"
		    data-note-id="{{ $note->id }}" title="Approve Note">
	      <span class="glyphicon glyphicon-check"></span>
	    </button>
	  </span>
	  <span class="input-grp-btn stat-item">
	    <button type="button" class="noteeditbutton btn btn-default"
		    title="Edit Note">
	      <span class="glyphicon glyphicon-edit"></span>
	    </button>
	  </span>
	  <span class="input-grp-btn stat-item">
	    <button type="button" class="notedeletebutton btn btn-default"
		    data-parent-id="{{ $note->$type->id }}"
		    data-note-id="{{ $note->id }}" title="Delete Note">
	      <span class="glyphicon glyphicon-trash"></span>
	    </button>
	  </span>
	</div>
	@endif
      </div>
    </div>
  </div>
</div>
@empty
<div>No new notes</div>

@endforelse
