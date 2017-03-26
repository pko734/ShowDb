@extends('layouts.master')
@section('title')
Song Finder
@endsection
@section('content')
<div class="container">
  <div class="panel panel-default">
    <div class="panel-heading">
      <form action="/songs" method="GET" role="search">
        <div class="input-group">
          <input type="text" class="form-control" name="q"
          placeholder="Search Songs" value="{{ $query or '' }}">
          <small class="form-text text-muted">examples: <em>november blue, cover, bob dylan, etc</em></small>
          <span class="input-group-btn" style="vertical-align:top;">
            <button type="submit" class="btn btn-default">
            <span class="glyphicon glyphicon-search"></span>
            </button>
          </span>
        </div>
      </form>
    </div><!--/.panel-heading-->
    <div class="is-table panel-body">

      <div class="is-table-col col-xs-3">
        @include('widgets.slider', ['slides' => [
        'http://thelstory.weebly.com/uploads/2/1/7/1/21710700/3103595.jpg']
        ])
      </div><!--/.is-table-col-->

      <div class="is-table-col col-xs-9">
        <form action="/songs" method="POST">
          {{ csrf_field() }}
          <table id="songtable" class="table table-striped">
            <thead>
              <tr>
                <th width="1px"></th>
                <th>
                  <a href="{{ Request::fullUrlWithQuery(['o' => $title_order]) }}">
                    Title
                  </a>
                </th>
                <th style="text-align:center;">
                  <a href="{{ Request::fullUrlWithQuery(['o' => $setlist_item_order]) }}">
                    Play Count
                  </a>
                </th>
              </tr>
            </thead>
            <tbody>
              @forelse($songs as $song)
              <tr>
                <td>
                  @if($song->notes_count > 0)
                  <i class="fa fa-files-o"
                  data-toggle="tooltip"
                  data-placement="right"
                  title="{{ $song->notes_count }} notes"
                  aria-hidden="true"></i>
                  @endif
                </td>
                <td><a href="/songs/{{ $song->id }}">{{ $song->title }}</a></td>
                <td style="text-align: center;">
                  <a href="/songs/{{ $song->id }}/plays">
                    <strong>{{ $song->setlist_items_count }}</strong>
                  </a>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="2">No Matches</td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </form>
      </div><!--/.is-table-col-->
      </div><!--/.is-table-->
      <div class="panel-footer">
        @if($user && $user->admin)
        <ul class="pagination">
          <li>
            <button id="addbutton" type="button" class="pull-left btn btn-default">
            <span class="glyphicon glyphicon-plus"></span>
            </button>
          </li>
        </ul>
        @endif
        <div class="pull-right">
          {!! $songs->render() !!}
        </div>
      </div>
  </div><!--/.panel-->
</div><!--/.container-->
@endsection