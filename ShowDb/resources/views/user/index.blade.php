@extends('layouts.master')

@section('title')
Stats ({{ $user->username }})
@endsection

@section('content')

<div class="container">
  <h3>Stats ({{ $user->username }})</h3>
  <div class="well">
  <dl class="dl-horizontal">
    <dt>Past Shows</dt>
    <dd><a href="{{ url()->current() }}/shows">{{ count($past_shows) }}</a></dd>
    <dt>Upcoming shows</dt>
    <dd><a href="{{ url()->current() }}/shows">{{ count($upcoming_shows) }}</a></dd>
    <dt>Unique Songs</dt>
    <dd><a href="{{ url()->current() }}/songs">{{ count($songs) }}</a></dd>
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
  </div>
  <h3>Yearly Breakdown</h3>
  @foreach($yearly_data as $str => $year)
  <h4>{{ $str }}</h4>
  <div class="well">
  <dl class="dl-horizontal">
    <dt>Shows</dt>
    <dd><a href="{{ url()->current() }}/shows?q={{ $str }}">{{ $year->shows }}</a></dd>
    <dt>Unique Songs</dt>
    <dd><a href="{{ url()->current() }}/songs/?q={{ $str }}">{{ $year->unique_songs }}</a></dd>
    <dt>Song Performances</dt>
    <dd>{{ $year->songs }}</dd>
  </dl>
  </div>
  @endforeach
</div>

@endsection
