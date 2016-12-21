@extends('layouts.master')

@section('title')
User Stats ({{ $user->username }})
@endsection

@section('content')

<div class="container">
  <h3>User Stats ({{ $user->username }})</h3>
  <dl class="dl-horizontal">
    <dt>Past Shows</dt>
    <dd><a href="/myshows">{{ count($past_shows) }}</a></dd>
    <dt>Upcoming shows</dt>
    <dd><a href="/myshows">{{ count($upcoming_shows) }}</a></dd>
    <dt>Unique Songs</dt>
    <dd><a href="/mysongs">{{ count($songs) }}</a></dd>
    <dt>Song Performances</dt>
    <dd>{{ $total_songs }}</dd>
    @if($first_show)
    <dt>First Show</dt>
    <dd><a href="/shows/{{ $first_show->id }}">{{ $first_show->date }} {{ $first_show->venue }}</a></dd>
    <dt>Last Show</dt>
    <dd><a href="/shows/{{ $last_show->id }}">{{ $last_show->date }} {{ $last_show->venue }}</a></dd>
    @endif
    <dt>Next Show</dt>
    <dd>
      @if($next_show)
      <a href="/shows/{{ $next_show->id }}">{{ $next_show->date }} {{ $next_show->venue }}</a>
      @else
      ???
      @endif
    </dd>
  </dl>
  <hr/>
  <h3>Yearly Breakdown</h3>
  @foreach($yearly_data as $str => $year)
  <h4>{{ $str }}</h4>
  <dl class="dl-horizontal">
    <dt>Shows</dt>
    <dd><a href="/myshows?q={{ $str }}">{{ $year->shows }}</a></dd>
    <dt>Unique Songs</dt>
    <dd>{{ $year->unique_songs }}</dd>
    <dt>Song Performances</dt>
    <dd>{{ $year->songs }}</dd>
    <hr/>
    @endforeach
</div>

@endsection
