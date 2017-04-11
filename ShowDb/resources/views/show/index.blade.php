@extends('layouts.master')
@section('title')
Show Finder
@endsection
@section('content')
<div class="container">
  <div class="panel panel-default">
    <div class="panel-heading">
      <form action="{{ url()->current() }}" method="GET" role="search">
    <div class="input-group">
      <input type="text" class="form-control" name="q"
      placeholder="Search Shows" value="{{ $query or '' }}">
      @if($display_search_examples)
      <small class="form-text text-muted">examples: <em>2013, 2016-05, raleigh, jerry, etc</em></small>
      @endif
      <span class="input-group-btn" style="vertical-align:top;">
        <button type="submit" class="btn btn-default">
        <span class="glyphicon glyphicon-search"></span>
        </button>
      </span>
    </div>
      </form>
      </div><!--/.panel-heading-->

      <div class="is-table panel-body">

    <div class="is-table-col col-xs-3 image-col">
    @include('widgets.slider', ['slides' => 
      array_map(function($a){ return "/{$a}"; }, glob('sliderimages/*.jpg'))
      ] )
    </div>
    <div class="is-table-col col-xs-9">
      <form action="{{ url()->current() }}" method="POST">
        {{csrf_field() }}
        <table id="showtable" class="table table-striped" data-display-creator-notice="{{ $display_creator_notice }}">
          <thead>
        <tr>
          <th width="1px"></th>
          @if($display_show_date)
          <th>
            <a href="{{ Request::fullUrlWithQuery(['o' => $date_order]) }}">
              Date
            </a>
          </th>
          @endif
          @if($display_show_creator)
          <th>
            <a href="{{ Request::fullUrlWithQuery(['o' => $date_order]) }}">
              Creator
            </a>
          </th>
          @endif
          <th>
            <a href="{{ Request::FullUrlWithQuery(['o' => $setlist_item_order]) }}">
              Songs
            </a>
          </th>
          <th>{{ $venue_display }}</th>
        </tr>
          </thead>
          <tbody>
        @forelse($shows as $show)
        <tr>
          <td>
            <span style="white-space:nowrap;">
              @if($display_complete)
              @if($show->incomplete_setlist)
              <i style="color: orange"
              class="fa fa-exclamation"
              data-toggle="tooltip"
              data-placement="right"
              title="Partial or incomplete setlist"
              aria-hidden="true"></i>
              @endif
              @endif
              @if($show->notes_count > 0)
              <i class="fa fa-files-o"
              data-toggle="tooltip"
              data-placement="right"
              title="{{ $show->notes_count }} notes"
              aria-hidden="true"></i>
              @endif
            </span>
          </td>
          @if($display_show_date)
          <td>{{ $show->date }}</td>
          @endif
          @if($display_show_creator)
          <td>{{ $show->creator->username }}</td>
          @endif
          <td>
            @if ($show->setlist_items_count === 0)
            -
            @else
            <strong>{{ $show->setlist_items_count }}</strong>
            @endif
          </td>
          <td>
            @if($display_show_checkbox)
            @if($user && $show->users->contains($user->id))
            <a data-toggle="tooltip"
              data-placement="left"
              class="remove-show-link"
              data-show-id="{{ $show->id }}"
              title="Remove from my shows" href="">
            <i style="color: green;" class="fa fa-check-square-o" aria-hidden="true"></i></a>
            @elseif($user)
            <a data-toggle="tooltip"
              data-placement="left"
              class="add-show-link"
              data-show-id="{{ $show->id }}"
              title="Add to my shows" href="">
            <i style="color: green;" class="fa fa-square-o" aria-hidden="true"></i></a>
            @endif
            @endif
            <a href="{{ url()->current() }}/{{ $show->id }}">
              {{ $show->venue }}
            </a>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="4">No matches</td>
        </tr>
        @endforelse
          </tbody>
        </table>
      </form>
    </div><!--.is-table-col-->

      </div><!--/.is-table-->


      <div class="panel-footer">
    @if($user && ($user->admin || $user_can_add_show))
    <ul class="pagination">
      <li>
        <button id="addbutton"
        type="button"
        class="pull-left btn btn-default"
        data-show-date="{{ $display_show_date }}">
        <span class="glyphicon glyphicon-plus"
          title="{{ $show_add_tooltip }}"
          data-toggle="tooltip"
        data-placement="right"></span>
        </button>
      </li>
    </ul>
    @endif
    <div class="pull-right">
      {!! $shows->render() !!}
    </div>
    <div style="clear:both;"></div>
      </div>
      </div><!--/.panel-->
      </div><!--/container-->
      <form method="POST" id="user-add-show-form" action="" data-default-date="{{ $default_date }}">
    {{ csrf_field() }}
      </form>
      <form method="POST" id="user-remove-show-form" action="">
    {{ method_field('DELETE') }}
    {{ csrf_field() }}
      </form>
      @endsection
