@foreach($notes as $note)
@if($note->published || ($user && ($note->creator->id == $user->id)))
@php ($at_least_one = true)
<tr>
  <td>
    <div class="row">
      <div class="col-sm-12">
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
		made a note. @if($note->published == false) <em style="color: red;">Pending approval</em> @endif
	      </div>
	      <h6 class="text-muted time">
		{{ \Carbon\Carbon::createFromTimeStamp($note->created_at->timestamp)->diffForHumans() }}
	      </h6>
	    </div>
	  </div>
	  <div data-note-id="{{ $note->id }}" class="post-description">
	    <span class="note-content">{!! $note->note !!}</span>
	    @if(($user && $user->admin) || ($user && $user->id == $note->creator_id))
	    <div class="stats">
	      <span class="input-grp-btn stat-item">
		<button type="button" class="edit-{{ $type }}-note-btn btn btn-default"
			data-note-id="{{ $note->id }}"
			title="Edit Show Note">
		  <span class="glyphicon glyphicon-edit"></span>
		</button>
	      </span>
	      <span class="input-grp-btn stat-item">
		<button type="button" class="delete-{{ $type }}-note-btn btn btn-default"
			data-note-id="{{ $note->id }}"
			title="Delete Show Note">
		  <span class="glyphicon glyphicon-trash"></span>
		</button>
	      </span>
	    </div>
	    @endif
	  </div>
	</div>
      </div>
    </div>

  </td>
</tr>
@endif
@endforeach

@if(!isset($at_least_one))
<tr><td>No notes</td></tr>
@endif

<tr>
  <td>
    @if($user)
    <span class="input-grp-btn">
      <button id="add-{{ $type }}-note-btn" type="button" class="pull-left btn btn-default">
	<span class="glyphicon glyphicon-plus"></span>
      </button>
    </span>
    <span class="input-grp-btn">
      <!-- right hand button -->
    </span>
    @endif
  </td>
</tr>
