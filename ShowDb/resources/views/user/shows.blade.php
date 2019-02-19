@extends('layouts.master')
@section('title')
Shows ({{ $user->username }})
@endsection
@section('content')

<div class="panel panel-default container">
  <div class="panel-heading row">
    <h1>Shows</h1>
    <p><em>A listing of past and future The Avett Brothers shows for user: <b>{{ $user->username }}</b>
	@if($q)
	in <b>{{ $q }}</b>
	@endif
    </em></p>
  </div><!--/.panel-heading -->
  <div class="is-table panel-body">

    <div class="is-table-col col-xs-9">
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
	    <th width="1px"></th>
	  </tr>
	</thead>
	<tbody>
	  @forelse($shows as $show)
	  <tr>
	    <td style="white-space:nowrap">{{ $show->date }}</td>
	    <td>
	      @if ($show->setlist_items_count === 0)
	      -
	      @else
	      <strong>{{ $show->setlist_items_count }}</strong>
	      @endif
	    </td>
	    <td>
	      <a href="/shows/{{ $show->id }}">
		{{ $show->venue }}
	      </a>
	    </td>
	      <td>
		<span class="table-icons" style="white-space:nowrap;">
		  @if($displayComplete && $show->incomplete_setlist && $show->date < date('Y-m-d'))
		  <i style="color: orange"
		     class="fa fa-exclamation"
		     data-toggle="tooltip"
		     data-placement="right"
		     title="Partial or incomplete setlist"
		     aria-hidden="true"></i>
		  @else
		  <i class="icon-hidden fa fa-exclamation"
		     data-placement="right"
		     aria-hidden="true"></i>
		  @endif
		  @if($show->notes_count > 0)
		  <i class="far fa-file"
		     data-toggle="tooltip"
		     data-placement="right"
		     title="{{ $show->notes_count }} notes"
		     aria-hidden="true"></i>
		  @else
		  <i class="icon-hidden far fa-file"
		     data-placement="right"
		     aria-hidden="true"></i>
		  @endif
		  @if($show->setlist_items_notes_count > 0)
		  <i class="fab fa-youtube"
		     data-toggle="tooltip"
		     data-placement="right"
		     title="{{ $show->setlist_items_notes_count }} videos"
		     aria-hidden="true"></i>
		  @else
		  <i class="icon-hidden fab fa-youtube"
		     data-placement="right"
		     aria-hidden="true"></i>
		  @endif
		  @if($show->images_count > 0)
		  <i class="far fa-image"
		     data-toggle="tooltip"
		     data-placement="right"
		     title="{{ $show->images_count }} photos"
		     aria-hidden="true"></i>
		  @else
		  <i class="icon-hidden far fa-image"
		     data-placement="right"
		     aria-hidden="true"></i>
		  @endif

		</span>
 	      </td>

	  </tr>
	  @empty
	  <tr>
	    <td colspan="3">No matches</td>
	  </tr>
	  @endforelse
	</tbody>
      </table>
    </div><!--.is-table-col-->
    <div class="is-table-col col-xs-3 image-col">
      @include('widgets.slider', ['slides' =>
      array_map(function($a){ return "/{$a}"; }, glob('sliderimages/*.jpg'))
      ] )
    </div>
  </div><!--/.is-table-->
  <div class="panel-footer row">
    <div class="pull-right">
      {!! $shows->render() !!}
    </div>
    <div style="clear:both;"></div>
  </div>
</div><!--/.panel-->

@endsection
