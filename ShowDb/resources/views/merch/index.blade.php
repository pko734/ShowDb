@extends('layouts.master')
@section('title')
{{ $heading }}
@endsection
@section('content')

<div class="panel panel-default container">
  <div class="panel-heading row">
    <div class="col-lg-6 col-md-6">
      <h1>{{ $heading }}</h1>
      <p><em>{!! $subheader !!}</em></p>
    </div>
    <div class="col-lg-6 col-md-6" style="margin-top: 20px">
<!--
      <form action="{{ url()->current() }}" method="GET" role="search">
	<div class="input-group">
	  <input type="text" class="form-control" name="q"
		 placeholder="Search Stickers" value="{{ $query ?? '' }}">
	  <span class="input-group-btn" style="vertical-align:top;">
	    <button type="submit" class="btn btn-default">
	      <span class="glyphicon glyphicon-search"></span>
	    </button>
	  </span>
	</div>
      </form>
-->
	  @if($user && $user->admin)
	  <span class="input-group-btn" style="vertical-align:top;">
	    <button id="merchaddbutton" type="button" class="btn btn-default">
	      <span class="glyphicon glyphicon-plus"></span>
	    </button>
	  </span>
	  @endif

    </div>
  </div>

  <div class="panel-body is-table">
    <div class="is-table-col col-xs-12">
      <form action="/merch" method="POST" enctype="multipart/form-data">
	  {{ csrf_field() }}
	  <input type="hidden" name="category" value="{{ $category }}">
		<table id="merchtable" class="table table-striped">
<!--	  <thead>
	    <tr>
	      <th width="1px"></th>
	      <th>
		Image
	      </th>
	      <th>
		Year
	      </th>
	      <th>
		Description
	      </th>
	    </tr>
	  </thead>
-->
	  <tbody>
	    @forelse($merch as $m)
	    <tr>
	      <td width="150px">
		<a target="_merch"
		   data-gallery
		   title="{{ $m->year }} @if($m->description) - {{ $m->description }}@endif @if($m->artist)- Artist: {{ $m->artist }}@endif"
		   href="{{ $m->url }}"
		   text="text/html">
		<img src="{{ $m->thumbnail_url }}"/>
		</a>
	  @if($user && $user->admin)
	  <span class="input-group-btn" style="vertical-align:top;">
	    <a href="/merch/{{ $m->id }}/edit">
	    <button type="button" class="edit-merch-btn btn btn-default">
	      <span class="glyphicon glyphicon-edit"></span>
	    </button>
	    </a>
	    <button type="button"
		    class="delete-merch-btn btn pull-right btn-danger"
			data-merch-id="{{ $m->id }}"
			data-merch-category="{{ $m->category}}">
	      <span class="glyphicon glyphicon-trash"></span>
	    </button>
	  </span>
	  @endif

	      </td>
	      <td>
		@if($m->name)
		<p><strong>Name: </strong>{{ $m->name }}</p>
		@endif
		@if($m->dimensions)
		<p><strong>Dimensions: </strong>{{ $m->dimensions }}</p>
		@endif
		@if($m->year)
		<p><strong>Year: </strong>{{ $m->year }}</p>
		@endif
		@if($m->artist)
		<p><strong>Artist: </strong>{{ $m->artist }}</p>
		@endif
		@if($m->description)
		<p><strong>Description: </strong>{{ $m->description }}</p>
		@endif
		@if($m->notes)
		<p><strong>Notes: </strong>{{ $m->year }}</p>
		@endif

	      </td>
	    </tr>
	    @empty
	    <tr>
	      <td colspan="4">No matches</td>
	    </tr>
	    @endforelse
	  </tbody>
	</table>
      </form>
    </div><!--/.is-table-col-->
  </div><!--/.is-table-->

  <div class="panel-footer row">
    {!! $merch->render() !!}
  </div><!--/.panel-footer-->
</div><!--/.panel-->

<form id="delete-merch-form" method="POST" action="#">
  {{ csrf_field() }}
  {{ method_field('DELETE') }}
</form>

@endsection
