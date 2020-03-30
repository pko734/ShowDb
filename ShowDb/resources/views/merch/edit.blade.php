@extends('layouts.master')
@section('title')
Merch Editor
@endsection
@section('content')
<div class="container">
  <div class="panel panel-default">
    <div class="panel-body">
      <form method="POST" action="/merch/{{ $merch->id }}">
        {{ method_field('PUT') }}
        {{ csrf_field() }}
	    <input name="category" type="hidden" value="{{ $merch->category }}">
	    <input name="referer" type="hidden" value="{{ $referer }}">
        <div class="form-group">
          <label for="merch_id">Merch ID</label>
          <input disabled value="{{ $merch->id }}"
		 type="text"
		 class="form-control"
		 id="merch_id"
		 placeholder="">
		</div>
		@if($merch->shows()->first())
        <div class="form-group">
          <label for="show_id">Show</label>
          <p><a href="/shows/{{ $merch->shows()->first()->id }}">{{ $merch->shows()->first()->getShowDisplay() }}</a></p>
		</div>
		@endif
        <div class="form-group">
		  	<label for="merch_artist">Merch Artist</label>
		  	<select name="artist_id" class="form-control" id="artist_selector_edit">
				<option value="">Select an artist</option>
				@foreach($allArtist as $a)
				<option value="{{ $a->id }}" @if($merch->artists()->first() && $a->name == $merch->artists()->first()->name) selected @endif>{{ $a->name }}</option>
				@endforeach
			</select>
        </div>

        <div class="form-group">
          <label for="merch_name">Merch Name</label>
          <input value="{{ $merch->name }}"
				name="name"
				type="text"
				class="form-control"
				id="merch_name"
				maxlength="40"
				placeholder="A Short merch Name">
        </div>
        <div class="form-group">
          <label for="merch_image">Merch Image</label>
	  <br>
	  <img src="{{ $merch->thumbnail_url }}"/>
	</div>

        <div class="form-group">
          <label for="merch_year">Merch Year</label>
          <input value="{{ $merch->year }}"
		 name="year"
		 type="text"
		 class="form-control"
		 id="merch_year"
		 size="4"
		 maxlength="4"
		 minlength="4"
		 placeholder="2004">
        </div>

        <div class="form-group">
          <label for="merch_dimensions">Merch Dimensions</label>
          <input value="{{ $merch->dimensions }}"
		 name="dimensions"
		 type="text"
		 class="form-control"
		 maxlength="10"
		 id="merch_dimensions"
		 placeholder="...">
        </div>

        <div class="form-group">
          <label for="merch_description">Merch Description</label>
          <input value="{{ $merch->description }}"
		 name="description"
		 type="text"
		 maxlength="255"
		 class="form-control"
		 id="merch_description"
		 placeholder="A description of this merch">
        </div>
        <div class="form-group">
          <label for="merch_notes">Merch Notes</label>
          <input value="{{ $merch->notes }}"
		 name="notes"
		 type="text"
		 class="form-control"
		 maxlength="255"
		 id="merch_notes"
		 placeholder="Any special notes about this merch">
        </div>
        <button type="submit" class="pull-right btn btn-primary">Submit</button>
      </form>
    </div>
  </div>
</div>
@endsection