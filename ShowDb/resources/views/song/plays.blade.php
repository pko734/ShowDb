@extends('layouts.master')

@section('head')
<link href='/css/book.css' rel='stylesheet'>
@endsection

@section('title')
Shows where songs were played
@endsection

@section('content')

<div class="container">
  <form action="/plays" method="GET" role="search">
    <label>
      Find Shows Where A Song Was Played
    </label>
    <div class="input-group">
      <span class="ac-song-title">
    <input name="title"
           value="{{ $song->title }}"
           class="form-control typeahead"
           type="text"
           placeholder="Song Title">
      </span>
      <span class="input-group-btn">
    <button type="submit" class="btn btn-default">
      <span class="glyphicon glyphicon-search"></span>
    </button>
      </span>
    </div>
  </form>
</div>

<div class="container">
    <table id="showtable" class="table table-striped">
      <thead>
    <tr>
      <th>ID</th>
      <th>
        <a href="{{ Request::fullUrlWithQuery(['d' => 'asc']) }}">
          Date
        </a>
      </th>
      <th>Venue</th>
    </tr>
      </thead>
      <tbody>
    @foreach($shows as $show)
    <tr>
      <td>{{ $show->id }}</td>
      <td>{{ $show->date }}</td>
      <td><a href="/shows/{{ $show->id }}">{{ $show->venue }}</a></td>
    </tr>
    @endforeach
      </tbody>
    </table>

  {!! $shows->render() !!}

</div>

<script src="/js/playssong.js"></script>
@endsection
