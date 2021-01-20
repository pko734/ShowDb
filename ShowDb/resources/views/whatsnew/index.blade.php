@extends('layouts.master')
@section('title')
What's New
@endsection
@section('content')

<div class="panel panel-default container">
  <div class="panel-heading row">
    <div class="col-lg-12 col-md-12">
      <h1>What's New</h1>
      <p><em>Check out what's new in the database!</em></p>
    </div>
  </div>

  <div class="panel-body">
  @foreach($stuff as $date => $data)
    <h2>{{ date('F jS Y', strtotime($date)) }}</h2>
    @if(isset($data['users']))
    <p><b>{{ count($data['users']) }} new {{ Str::plural('user', count($data['users'])) }}</b></p>
    @endif
    @if(isset($data['shows']))
    <p><b>{{ count($data['shows']) }} new {{ Str::plural('show', count($data['shows'])) }}</b>
      <br>
      @php
      sort($data['shows']);
      @endphp
      @foreach($data['shows'] as $show_id)
      @php
      $show = \ShowDb\Show::find($show_id);
      @endphp
      <a href="/shows/{{ $show->id }}">{{ $show->getShowDisplay() }}</a><br>
      @endforeach
    </p>
    @endif

    @if(isset($data['songs']))
    <p><b>{{ count($data['songs']) }} new {{ Str::plural('song', count($data['songs'])) }}</b>
      <br>
      @foreach($data['songs'] as $song_id)
      @php
      $song = \ShowDb\Song::find($song_id);
      @endphp
      <a href="/songs/{{ $song->id }}">{{ $song->title }}</a><br>
      @endforeach
    </p>

    @endif

    @if(isset($data['notes']))
    <p><b>{{ count($data['notes']) }} new show {{ Str::plural('note', count($data['notes'])) }}</b>
      <br>
      @foreach($data['notes'] as $note_id)
      @php
      $note = \ShowDb\ShowNote::find($note_id);
      @endphp
      <a href="/shows/{{ $note->show->id }}">{{ $note->show->getShowDisplay() }}</a><br>
      @endforeach
    </p>
    @endif

    @if(isset($data['photos']))
    <p><b>{{ count($data['photos']) }} new {{ Str::plural('photo', count($data['photos'])) }}</b>
      <br>
      @foreach($data['photos'] as $photo_id)
      @php
      $img = \ShowDb\ShowImage::find($photo_id);
      @endphp
	  @if($img->published ||
	  ($user && $user->admin) ||
	  ($user && ($user->id == $img->user_id)))
	  <a href="{{ $img->url }}"
	     data-gallery="{{ $date }}"
	     data-photo-id="{{ $img->id }}"
	     title="{{ $img->show->date }} {{ $img->show->venue }} @if($img->caption) {{ $img->caption }} - @endif @if($img->photo_credit) - Photo Credit: {{ $img->photo_credit }} @endif @if(!$img->published)  - Pending approval @endif"
	     @if($user && $user->admin)
	    data-deletable="1"
	    @if(!$img->published)
	    data-approvable="1"
	    @endif
	    @endif
	    '
	    >
	    <i class="far fa-image fa-lg
			      @if($img->published)
			      text-primary
			      @else
			      text-danger
			      @endif"
		   aria-hidden="true"></i></a>
	  @endif
      @endforeach
    </p>
    @endif

    @if(isset($data['videos']))
    <p><b>{{ count($data['videos']) }} new {{ Str::plural('video', count($data['videos'])) }}</b>
      <br>
      @foreach($data['videos'] as $video_id)
      @php
      $note = \ShowDb\SetlistItemNote::find($video_id);
      @endphp

	  @if($note->published || ($user && $user->id == $note->creator->id))
	  <a class="video_link"
		 target="_vids"

		 title="{{ $note->setlistItem->show->date }} {{ $note->setlistItem->show->venue }} {{ $note->setlistItem->song->title }}"
		 href="{{ $note->note }}"
		 type="text/html"
		 >
		<i class="fab fa-youtube" aria-hidden="true"></i></a>
	  @endif
      @endforeach
    </p>
    @endif
    <hr>
    @if(isset($data['merch']))
    <p><b>{{ count($data['merch']) }} new merch</b>
      <br>
      @foreach($data['merch'] as $merch_id)
      @php
      $merch = \ShowDb\Merch::find($merch_id);
      @endphp
      <img width="50px" src="{{ $merch->thumbnail_url }}"/>
      @endforeach
    </p>
    <hr>
    @endif

  @endforeach
  </div>

  <div class="is-table panel-body">

  </div><!--/.is-table-->


  <div class="panel-footer row">
    <div class="pull-right">
      @if($order != "random")
      {!! $stuff->render() !!}
      @else
      <i>Cannot paginate random order!</i>
      @endif
    </div>
    <div style="clear:both;"></div>
  </div>
</div><!--/.panel-->
@endsection
