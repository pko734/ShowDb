@extends('layouts.master')
@section('title')
Timeline Admin
@endsection
@section('content')
<div class="panel panel-default container">
  <div class="panel-heading row">
    <div class="col-lg-6 col-md-6">
	  <h1>Timeline Slides</h1>
	  <p><em>Timeline slides</em></p>
    </div>
    <div class="col-lg-6 col-md-6" style="margin-top: 20px">
	  <form action="{{ url()->current() }}" method="GET" role="search">
	    <div class="input-group">
	      <input type="text" class="form-control" name="q"
		         placeholder="Search Timeline" value="{{ $query or '' }}">
	      <span class="input-group-btn" style="vertical-align:top;">
	        <button type="submit" class="btn btn-default">
		      <span class="glyphicon glyphicon-search"></span>
	        </button>
	      </span>
	    </div>
	  </form>
    </div>
  </div>
  
  <div class="is-table panel-body">

    <div class="is-table-col col-xs-12">
	  <form action="/admin/timeline" method="POST">
	    {{ csrf_field() }}
	    <table id="timelinetable" class="table table-striped">
	      <thead>
	        <tr>
		      <th>
		        <a href="">
		          Date
		        </a>
		      </th>
		      <th>
		        <a href="">
		          Headline
		        </a>
		      </th>
	        </tr>
	      </thead>
	      <tbody>
	        @forelse($slides as $slide)
	        <tr>
		      <td>{{ $slide->start_date }}</td>
		      <td><a href="/admin/timeline/{{ $slide->id }}">{{ $slide->text_headline }}</a></td>
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

  <div class="panel-footer row">
    <ul class="pagination">
	  <li>
	    <a href="/admin/timeline/create"
           id="timeline_add_button" 
           type="button" 
           class="pull-left btn btn-default">
	      <span class="glyphicon glyphicon-plus"></span>
	    </a>
	  </li>
    </ul>
    <div class="pull-right">
	  {!! $slides->render() !!}
    </div>
    <div style="clear:both;"></div>
  </div>
</div><!--/.panel-->
@endsection
