@extends('layouts.master')
@section('title')
Add Timeline Slide
@endsection
@section('content')
<div class="container">
  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-body">
	    <form method="POST" action="/admin/timeline">
	      <div class="form-group">
	        <label for="slide_headline">Slide Headline</label>
	        <input value=""
		           name="headline"
		           type="text"
		           class="form-control"
		           id="slide_headline"
		           placeholder="Slide Headline">
	      </div>
	      <div class="form-group">
	        <label for="slide_type">Slide Type</label>
            <select class="form-control">
              <option value="slide">normal</option>
              <option value="era">era</option>
              <option value="title">title (there can only be one)</option>
            </select>
	      </div>
	      <div class="form-group">
	        <label for="slide_type">Start Date</label>
            <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd" data-date-z-index-offset="9999">
              <input name="start_date" type="text" class="form-control" placeholder="YYYY-MM-DD">
              <div class="input-group-addon">
                <span class="glyphicon glyphicon-calendar"></span>
              </div>
            </div>
          </div>
	      <div class="form-group">
	        <label for="slide_type">End Date (optional)</label>
            <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd" data-date-z-index-offset="9999">
              <input name="end_date" type="text" class="form-control" placeholder="YYYY-MM-DD">
              <div class="input-group-addon">
                <span class="glyphicon glyphicon-calendar"></span>
              </div>
            </div>
          </div>
	      <div class="form-group">
	        <label for="slide_text">Slide Text (optional)</label>
            <textarea id="slide_text" name="slide_text_text"></textarea>
	      </div>
	      <div class="form-group">
	        <label for="slide_media_url">Media URL (optional)</label>
            See: <a href="https://timeline.knightlab.com/docs/media-types.html">https://timeline.knightlab.com/docs/media-types.html</a>
	        <input value=""
		           name="media_url"
		           type="text"
		           class="form-control"
		           id="slide_media_url"
		           placeholder="http://...">
	      </div>
	      <div class="form-group">
	        <label for="slide_media_caption">Media Caption (optional)</label>
	        <input value=""
		           name="media_caption"
		           type="text"
		           class="form-control"
		           id="slide_media_caption"
		           placeholder="caption goes here">
	      </div>
	      <div class="form-group">
	        <label for="slide_media_credit">Media Credit (optional)</label>
	        <input value=""
		           name="media_credit"
		           type="text"
		           class="form-control"
		           id="slide_media_credit"
		           placeholder="media credit goes here">
	      </div>
	      <div class="form-group">
	        <label for="slide_media_credit">Media Thumbnail URL (optional)</label>
	        <input value=""
		           name="media_thumbnail_url"
		           type="text"
		           class="form-control"
		           id="slide_media_thumbnail_url"
		           placeholder="http://...">
	      </div>

	      <button type="submit" class="pull-left btn btn-primary">Add Slide</button>&nbsp;
	    </form>
      </div>
    </div>
  </div>
</div>

@endsection
