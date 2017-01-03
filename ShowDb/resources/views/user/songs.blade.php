@extends('layouts.master')

@section('title')
Songs ({{ $user->username }})
@endsection

@section('content')

<div class="container">
  <h3>Songs ({{ $user->username }}) {{ $q ? " ($q)" : '' }}</h3>
  <form action="/songs" method="POST">
    {{ csrf_field() }}
    <table id="songtable" class="table table-striped">
      <thead>
	<tr>
	  <th>
	    Title
	  </th>
	  <th style="text-align:center;">
	    Play Count
	  </th>
	</tr>
      </thead>
      <tbody>
	@forelse($songs as $song)
	<tr>
	  <td><a href="/songs/{{ $song->id }}">{{ $song->title }}</a></td>
	  <td style="text-align: center;"><a href="/stats/{{ $user->username }}/songs/{{ $song->id }}/plays">{{ $song->setlist_items_count }}</a></td>
	</tr>
	@empty
	<tr>
	  <td colspan="2">No Matches</td>
	</tr>
	@endforelse

      </tbody>
    </table>
  </form>
  {!! $songs->render() !!}
</div>

<script src="/js/indexsongs.js"></script>
@endsection
