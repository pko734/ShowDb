@extends('layouts.master')

@section('title')
Database Stats
@endsection

@section('content')

<div class="container">
  <div class="panel panel-default">
    <h3>Database Stats</h3>
    <dl class="dl-horizontal">
      <dt>Past Shows</dt>
      <dd><a href="/shows">{{ count($past_shows) }}</a></dd>
      <dt>Upcoming shows</dt>
      <dd><a href="/shows">{{ count($upcoming_shows) }}</a></dd>
      <dt>Unique Songs</dt>
      <dd><a href="/songs">{{ count($songs) }}</a></dd>
      <dt>Song Performances</dt>
      <dd>{{ $total_songs }}</dd>
    </dl>
    <hr/>
    <h3>Database Yearly Breakdown</h3>
    @foreach($yearly_data as $str => $year)
    <h4>{{ $str }}</h4>
    <dl class="dl-horizontal">
      <dt>Shows</dt>
      <dd><a href="/shows?q={{ $str }}">{{ $year->shows }}</a></dd>
      <dt>Unique Songs</dt>
      <dd>{{ $year->unique_songs }}</dd>
      <dt>Song Performances</dt>
      <dd>{{ $year->songs }}</dd>
    </dl>
    <hr/>
    @endforeach
  </div>
</div>

@endsection
