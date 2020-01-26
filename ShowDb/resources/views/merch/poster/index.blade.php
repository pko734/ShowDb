@extends('layouts.master')
@section('title')
{{ $heading }}
@endsection
@section('content')

<div class="panel panel-default container">
    <div class="panel-heading row">
        <div class="col-lg-12 col-md-12">
        <h1>{{ $heading }}</h1>
        <p><em>{!! $subheader !!}</em></p>
    </div>
    <div class="row">
        <div class="col-lg-3 col-md-3" style="margin-top: 20px">
        <strong>Group by: </strong>
        <a href="/merch/posters?selector=year">| Year </a> | <a href="/merch/posters?selector=artist">Artist |</a>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12" style="margin-top: 20px">
            <form action="{{ url()->current() }}" method="GET" role="search">
                @if($selector == 'year')
                    <label for="year_selector">Year: </label>
                    |
                    @foreach($allYears as $y)
                        @if($year != $y)
                        <a href="/merch/posters?selector=year&year={{ $y }}">
                        @endif
                        {{ $y }}
                        @if($year != $y)
                        </a>
                        @endif
                        |
                    @endforeach
                    <!--
                    <select class="form-control" id="year_selector">
                        <option value="">Select a year</option>
                        @foreach($allYears as $y)
                        <option value="{{ $y }}" @if($y == $year) selected @endif>{{ $y }}</option>
                        @endforeach
                    </select>
                    -->
                @endif
                @if($selector == 'artist')
                    <label for="artist_selector">Artist</label>
                    <select class="form-control" id="artist_selector">
                        <option value="">Select an artist</option>
                        @foreach($allArtist as $a)
                        <option value="{{ $a->id }}" @if($artist && $a->name == $artist->name) selected @endif>{{ $a->name }} ({{ $a->posters->count() }})</option>
                        @endforeach
                    </select>
                    @if($artist && $artist->url)
                    <a href="{{ $artist->url }}">{{ $artist->url }}</a>
                    @endif
                @endif
            </form>
        </div>
    </div>
</div>
<!--
    	    <div class="input-group">
	        <input type="text" class="form-control" name="q"
		     placeholder="Search Stickers" value="{{ $query ?? '' }}">
    	    <span class="input-group-btn" style="vertical-align:top;">
	        <button type="submit" class="btn btn-default">
	        <span class="glyphicon glyphicon-search"></span>
	        </button>
	    </span>
	    </span>
        </div>
-->

  <div class="panel-body is-table">
    <div class="is-table-col col-xs-12">
      <form action="/merch" method="POST" enctype="multipart/form-data">
	  {{ csrf_field() }}
	  <input type="hidden" name="category" value="{{ $category }}">
      <div class="">
      <div class="row display-flex">
	    @forelse($merch as $m)
            <div class="col-xs-12 col-sm-3 col-md-3 col-lg-2 col-xl-1">
                <div class="thumbnail">
                    <div class="caption">
                    @if( $selector != 'artist' && $m->artist)
                       <p><strong>Artist: </strong>
                        @if($m->artists()->first())
                            <a href="/merch/posters?selector=artist&artist_id={{ $m->artists()->first()->id }}">
                        @endif
                                {{ $m->artist }}
                        @if($m->artists()->first())
                            </a>
                        @endif
                        </p>
                    @endif
                    @if($m->shows()->first())
                        <p><strong>Show: </strong> <a href="/shows/{{ $m->shows()->first()->id }}">{{ $m->shows()->first()->date }}</a> </p>
                    @endif
                    </div>

                    <a target="_merch"
                        data-gallery
                        title="{{ $m->year }} @if($m->description) - {{ $m->description }}@endif @if($m->artist)- Artist: {{ $m->artist }}@endif"
                        href="{{ $m->url }}"
                        text="text/html">

                        <img src="{{ $m->thumbnail_url }}"/>
                    </a>
                    <div class="caption">
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
                        @endif
                    </div>
                </div>
            </div>
	    @empty
        @endforelse
        </div>
        </div>
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
