@extends('layouts.master')

@section('title')
My Shows
@endsection

@section('content')

<div class="container">
  <h3>My Shows{{ $q ? " ($q)" : ''}}</h3>
    <table id="showtable" class="table table-striped">
      <thead>
	<tr>
	  <th>
	    Date
	  </th>
	  <th>
	    Songs
	  </th>
	  <th>Venue</th>
	</tr>
      </thead>
      <tbody>
	@forelse($shows as $show)
	<tr>
	  <td>{{ $show->date }}</td>
	  <td>
	    @if ($show->setlist_items_count === 0)
	    -
	    @else
	    {{ $show->setlist_items_count }}
	    @endif
	  </td>
	  <td>
	    <a href="/shows/{{ $show->id }}">
	      {{ $show->venue }}
	    </a>
	  </td>
	</tr>
	@empty
	<tr>
	  <td colspan="3">No matches</td>
	</tr>
	@endforelse
      </tbody>
    </table>

  {!! $shows->render() !!}

</div>

@endsection
