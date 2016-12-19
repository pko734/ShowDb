@extends('layouts.master')

@section('title')
My Stats
@endsection

@section('content')

<div class="container">
  <p><label>Number of shows:</label> <a href="/myshows">{{ count($user->shows) }}</a></p>
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
  <p>
    <label>Next Show:</label>
    @if($next_show)
    <a href="/shows/{{ $last_show->id }}">{{ $next_show->date }} {{ $next_show->venue }}</a>
    @else
    ???
    @endif
  </p>
  @endif
<!--
  <p><label>Top 5 Songs</label>
    <br>
    @foreach(array_slice($songs, 0, 5) as $song)
      {{ $song->title }}: {{ $song->setlist_items_count }} <br>
    @endforeach
  </p>
-->
  <hr/>
</div>

@endsection
