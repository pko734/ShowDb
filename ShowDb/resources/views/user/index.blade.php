@extends('layouts.master')

@section('title')
My Stats
@endsection

@section('content')

<div class="container">
  <p><label>Past shows:</label> <a href="/myshows">{{ count($past_shows) }}</a></p>
  <p><label>Upcoming shows:</label> <a href="/myshows">{{ count($upcoming_shows) }}</a></p>
  <p><label>Unique Songs:</label> <a href="/mysongs">{{ count($songs) }}</a></p>
  <p><label>Song Performances:</label> {{ $total_songs }}</p>
  @if($first_show)
  <p>
    <label>First Show:</label>
    <a href="/shows/{{ $first_show->id }}">{{ $first_show->date }} {{ $first_show->venue }}</a>
  </p>
  <p>
    <label>Last Show:</label>
    <a href="/shows/{{ $last_show->id }}">{{ $last_show->date }} {{ $last_show->venue }}</a>
  </p>
  @endif
  <p>
    <label>Next Show:</label>
    @if($next_show)
    <a href="/shows/{{ $next_show->id }}">{{ $next_show->date }} {{ $next_show->venue }}</a>
    @else
    ???
    @endif
  </p>
  <hr/>
</div>

@endsection
