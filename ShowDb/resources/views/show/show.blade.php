@extends('layouts.master')

@section('head')
<link href='/css/show.css' rel='stylesheet'>
@endsection

@section('title')
Show Viewer
@endsection

@section('content')

<div class="container">

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

    <label for="show_venue">Set List</label>
    <table class="table table-striped">
      <tbody>
	@foreach($show->setlistItems->sortBy('order') as $item)
	<tr>
	  <td>{{ $item->order }}. {{ $item->song->title }}</td>
	</tr>
	@endforeach
      </tbody>
    </table>

    @if($user && $user->admin)
    <span class="input-grp-btn">
      <button type="submit" class="pull-left btn btn-primary">Edit Show</button>
    </span>
    <span class="input-grp-btn">
      <button id="deletebtn" type="button" class="pull-right btn btn-primary">Delete Show</button>
    </span>

    @endif

  </form>

  <form id="deleteform" method="POST" action="/shows/{{ $show->id }}">
    {{ method_field('DELETE') }}
    {{ csrf_field() }}

  </form>

</div>

<script src="/js/showshow.js"></script>

@endsection
