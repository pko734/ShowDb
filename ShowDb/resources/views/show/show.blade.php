@extends('layouts.master')
@section('title')
Show Viewer
@endsection
@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-6">
			<form method="GET" action="{{ url()->current() }}/edit">
				@if($display_show_date)
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
					<label for="show_venue">Show {{ $venue_display }}</label>
					<input disabled value="{{ $show->venue }}"
					type="text"
					class="form-control"
					id="show_venue"
					placeholder="Venue - City, State">
				</div>
				<label>
					Set List
				</label>
				@if($display_complete)
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
							</td>
							<td>
								@if( (count($item->notes) > 0) && ($item->notes->get(0)->published || ($user && $user->id == $item->notes->get(0)->creator->id)))
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
		</div>
		<form id="delete-show-form" method="POST" action="{{ url()->current() }}">
			{{ method_field('DELETE') }}
			{{ csrf_field() }}
		</form>
		<div class="col-md-6">
			<form id="show-note-form" method="POST" action="{{ url()->current() }}/notes">
				{{ csrf_field() }}
				<div class="form-group">
					<label for="show_id">Show Notes</label>
					<table id="notetable" class="table">
						<tbody>
							@include('notes', ['notes' => $show->notes, 'type' => 'show', 'add_tooltip' => $note_tooltip])
						</tbody>
					</table>
				</div>
			</form>
			<form id="delete-show-note-form" method="POST" action="{{ url()->current() }}/notes/">
				{{ method_field('DELETE') }}
				{{ csrf_field() }}
			</form>
			<form id="edit-show-note-form" method="POST" action="{{ url()->current() }}/notes/">
				{{ method_field('PUT') }}
				{{ csrf_field() }}
				<input type="hidden" name="note" value="">
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