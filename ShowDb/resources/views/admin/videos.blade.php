@forelse($videos as $video)
    <div class="row">
      <div class="col-xs-12">
	<div class="panel panel-white post panel-shadow">
	  <div class="post-heading">
	    <div class="pull-left image">
	      @if($video->creator->avatar)
	      <img src="{{ $video->creator->avatar }}" class="img-circle avatar" alt="user profile image">
	      @endif
	    </div>
	    <div class="pull-left meta">
	      <div class="title h5">
		<a href="#"><b>{{ $video->creator->name }}</b></a>
		made a note.
	      </div>
	      <h6 class="text-muted time">
		{{ \Carbon\Carbon::createFromTimeStamp($video->created_at->timestamp)->diffForHumans() }}</h6>
	    </div>
	  </div>
	  <div class="post-description">
	    <p>
	      <a href="/songs/{{ $video->setlistItem->song->id }}">
		{{ $video->setlistItem->song->title }}
	      </a>
	    </p>
	    <p>
	      <a href="/shows/{{ $video->setlistItem->show->id }}">
		{{ $video->setlistItem->show->date }} {{ $video->setlistItem->show->venue }}
	      </a>
	    </p>
	    <p>
	      <a href="{{ $video->note }}">
		{{ $video->note }}
	      </a>
	    </p>
	    @if(($user && $user->admin) || ($user && $user->id == $video->user_id))
	    <div class="stats">
	      <span class="input-grp-btn stat-item">
		<button type="button" class="noteapprovebutton btn btn-success"
			data-parent-id="{{ $video->setlistItem->id }}"
			data-note-id="{{ $video->id }}">
		  <span class="glyphicon glyphicon-check"></span>
		</button>
	      </span>
	      <span class="input-grp-btn stat-item">
		<button type="button" class="notedeletebutton btn btn-default"
			data-parent-id="{{ $video->setlistItem->id }}"
			data-note-id="{{ $video->id }}">
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
<div>No new videos</div>
@endforelse
