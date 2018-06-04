@extends('layouts.master')
@section('title')
{{ $song->title }}
@endsection
@section('content')
<div class="container">
  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-body">
	    <form method="GET" action="/admin/timeline/{{ $slide->id }}/edit">
	      <div class="form-group">
	        <label for="slide_title">Timeline Slide Headline</label>
	        <input disabled
		           value="{{ $slide->text_headline }}"
		           name="title"
		           type="text"
		           class="form-control"
		           id="slide_headline"
		           placeholder="Slide Headline">
	      </div>
	      <button type="submit" class="pull-left btn btn-primary">Edit Slide</button>&nbsp;
	      <button id="delete-slide-btn" type="button" class="pull-right btn btn-danger">
	        <span class="glyphicon glyphicon-trash"></span>
	      </button>
	    </form>
      </div>
    </div>
  </div>
</div>
<form id="delete-timeline-form" method="POST" action="/admin/timeline/{{ $slide->id }}">
  {{ method_field('DELETE') }}
  {{ csrf_field() }}
</form>

@endsection
