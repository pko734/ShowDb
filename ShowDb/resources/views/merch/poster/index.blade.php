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

        <div class="col-lg-6 col-md-6" style="margin-top: 20px;">
            <form action="/merch/posters" method="GET">
                <div class="input-group">
                    <input type="hidden" name="category" value="{{ $category }}">
                    <input type="hidden" name="selector" value="search">
                    <input type="text" class="form-control" name="q"
                            placeholder="Search Posters" value="{{ $query ?? '' }}">
                    <div class="input-group-btn" style="vertical-align:top;">
                        <button type="submit" class="btn btn-default">
                            <span class="glyphicon glyphicon-search"></span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div><!-- panel-heading -->

    <div class="row">
        <div class="col-lg-12 col-md-12" style="margin-top: 20px">
            <h2>
            <strong>Group by: </strong>

            |
            @if($selector != 'year')
            <a href="/merch/posters?selector=year">
            @endif

            Year

            @if($selector != 'year')
            </a>
            @endif

            |
            @if($selector != 'artist')
            <a href="/merch/posters?selector=artist">
            @endif
            Artist
            @if($selector != 'artist')
            </a>
            @endif

            |
            @if($user)
            @if($selector != 'myshows')
            <a href="/merch/posters?selector=myshows">
            @endif
            My Shows
            @if($selector != 'myshows')
            </a>
            |
            @else
            |
            @endif
            @endif
            <!--
            @if($user && $user->admin)
            @if($selector != 'myposters')
            <a href="/merch/posters?selector=myposters">
            @endif
            My Posters
            @if($selector != 'myposters')
            </a>
            |
            @else
            |
            @endif
            @endif
            -->
            </h2>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12" style="margin-top: 10px; margin-bottom: 15px;">
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
                @endif
                @if($selector == 'artist')
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
        </div>
    </div>

    <div class="panel-body" style="table-layout: fixed">
        <div class="col-xs-12">
            <div class="row display-flex">
	            @forelse($merch as $m)
                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 col-xl-2">
                <div id="thumbnail-{{ $m->id }}" class="thumbnail panel-shadow @if($m->userHas()->count()) got-it @endif @if($m->userWants()->count()) want-it @endif">
                        <div class="caption text-center">
                            @if($m->shows()->first())
                            <div style="overflow: hidden; text-overflow: clip; white-space: nowrap">
                            @if($user && $m->shows()->first()->users->contains($user->id))
                                <a data-toggle="tooltip"
                                    data-placement="top"
                                    title="I was there">
                                <i style="color: green;"
                                    class="far fa-check-square"
                                    aria-hidden="true"></i>
                                </a>
                            @endif
                            <a href="/shows/{{ $m->shows()->first()->id }}">
                            {{ $m->shows()->first()->getShowDisplay() }}
                            </a>
                            </div>
                            @endif
                        </div>
                        <a target="_merch"
                            data-gallery
                            title="{{ $m->title() }}"
                            href="{{ $m->url }}"
                            text="text/html">

                            <img src="{{ $m->thumbnail_url }}"/>
                        </a>
                        <div class="caption text-center">
                            @if($m->artists()->first())
                            <a href="/merch/posters?selector=artist&artist_id={{ $m->artists()->first()->id }}">
                            @endif
                            {{ $m->artist }}
                            @if($m->artists()->first())
                            </a>
                            @endif
                            @if($m->notes)
                            <br/>
                            <span style="font-size: smaller">{{ $m->notes }}</span>
                            @endif
                            <br/>
                            @if($user)
                            <span class="text-left">
                            <a class="merch-claimer" href="#" data-target="merch_{{ $m->id }}">
                                <i style="color: grey;" class="fas fa-ellipsis-h" aria-hidden="true"></i>
                            </a>
                            <div id="merch_{{ $m->id }}" class="hidden">
                                <a href="#" class="claim-mine" data-merch-id="{{ $m->id }}" data-merch-status="{{ $m->userHas()->count() }}">
                                    <i id="claim-mine-{{ $m->id }}" class="far @if($m->userHas()->count() == 1) fa-check-square @else fa-square @endif" aria-hidden="true">
                                        In my collection
                                    </i>
                                </a>
                                <br>
                                <a href="#" class="claim-want" data-merch-id="{{ $m->id }}"  data-merch-status="{{ $m->userWants()->count() }}">
                                    <i id="claim-want-{{ $m->id }}" class="far @if($m->userWants()->count() == 1) fa-check-square @else fa-square @endif" aria-hidden="true">
                                        On my wishlist
                                    </i>
                                </a>
                            </div>
                            </span>
                            @endif
                        </div>
                        @if($user && $user->admin && $category != '')
                        <div class="caption">
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
                            </div>
                            @endif
                    </div>
                </div>
                @empty
                @if($query)
                    <div class="col-md-12 text-center">
                    <h2>No search results - try searching for a city, venue, or artist.</h2>
                    </div>
                @endif
                @if($selector == 'myposters')
                    <div class="col-md-12 text-center">
                    <h2>Go add some posters to your collection!</h2>
                    </div>
                @endif
                @endforelse
            </div>
        </div>
    </div><!-- panel-body is-table -->

    <div class="panel-footer row">
        {!! $merch->render() !!}
    </div>
</div><!--/.panel-->

<form id="delete-merch-form" method="POST" action="#">
  {{ csrf_field() }}
  {{ method_field('DELETE') }}
</form>

<form method="POST" id="user-add-merch-form" action="">
  {{ csrf_field() }}
  <input id="user-merch-claim-mode" type="hidden" name="mode" value="">
</form>
<form method="POST" id="user-remove-merch-form" action="">
  {{ method_field('DELETE') }}
  {{ csrf_field() }}
</form>

@endsection
