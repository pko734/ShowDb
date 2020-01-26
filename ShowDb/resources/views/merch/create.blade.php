@extends('layouts.master')
@section('title')
Merch Editor
@endsection
@section('content')
<div class="container">
  <div class="panel panel-default">
    <div class="panel-body">
      <form method="POST" action="/merch" enctype="multipart/form-data">
        {{ csrf_field() }}
	    <input name="category" type="hidden" value="{{ $category }}">
	    <input name="referer" type="hidden" value="{{ $referer }}">

        <div class="form-group">
          <label for="show_id">Show</label>
          <p><a href="/shows/{{ $show->id }}">{{ $show->getShowDisplay() }}</a></p>
          <input type="hidden" name="show_id" value="{{ $show->id }}">
        </div>

        <div class="form-group">
          <label for="merch_image">Merch Image</label>
    	  <input id="fupload" name="image" class="form-control" type="file" required="">
	    </div>

        <div class="form-group">
		  	<label for="merch_artist">Merch Artist</label>
		  	<select name="artist_id" class="form-control" id="artist_selector_edit">
				<option value="">Select an artist</option>
				@foreach($allArtist as $a)
				<option value="{{ $a->id }}">{{ $a->name }}</option>
				@endforeach
			</select>
        </div>

        <div class="form-group">
          <label for="merch_name">Merch Name</label>
          <input value=""
                 name="name"
                 type="text"
                 class="form-control"
                 id="merch_name"
                 maxlength="25"
                 placeholder="A Short merch Name">
        </div>

        <div class="form-group">
          <label for="merch_year">Merch Year</label>
          <input value="{{ substr($show->date, 0, 4) }}"
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
          <input value=""
                 name="dimensions"
                 type="text"
                 class="form-control"
                 maxlength="10"
                 id="merch_dimensions"
                 placeholder="...">
        </div>

        <div class="form-group">
          <label for="merch_description">Merch Description</label>
          <input value=""
                 name="description"
                 type="text"
                 maxlength="255"
                 class="form-control"
                 id="merch_description"
                 placeholder="A description of this merch">
        </div>
        <div class="form-group">
          <label for="merch_notes">Merch Notes</label>
          <input value=""
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
