@extends('layouts.master')
@section('title')
{{ $song->title }}
@endsection
@section('content')
<div class="container">
  <div class="col-md-7">
    <div class="panel panel-default">
      <div class="panel-body">
	    <form method="GET" action="/songs/{{ $song->id }}/edit">
	      <div class="form-group">
	        <label for="song_title">Song Title</label>
	        <input disabled
		           value="{{ $song->title }}"
		           name="title"
		           type="text"
		           class="form-control"
		           id="song_title"
		           placeholder="Song Title">
	      </div>
          @if($song->getShowCount() > 0)
	      <div class="form-group">
          <label for="first_play">First Time Played</label>
            <div>
              <a href="/shows/{{ $song->shows()->orderBy('date', 'asc')->first()->show_id }}">{{ $song->shows()->orderBy('date', 'asc')->first()->getShowDisplay() }}</a>
            </div>
	      </div>
	      <div class="form-group">
          <label for="recent_play">Most Recent Time Played</label>
            <div>
              <a href="/shows/{{ $song->shows()->orderBy('date', 'desc')->first()->show_id }}">{{ $song->shows()->orderBy('date', 'desc')->first()->getShowDisplay() }}</a>
            </div>
	      </div>
          @endif
	      <div class="form-group">
	        <label for="times_played">Total Times Played</label>
            <div>
              <a href="/songs/{{ $song->id }}/plays">
	            {{ $song->getShowCount() }}
	          </a>
            </div>
	      </div>
          @if($song->spotify_link)
	      <div class="form-group">
	        <label for="spotify_link">Listen</label>
            <div>
              {!! $song->spotify_link !!}
            </div>
	      </div>
          @endif
          <div>
            <div id="chart_div1"></div>
          </div>
	      @if($user && $user->admin)
	      <button type="submit" class="pull-left btn btn-primary">Edit Song</button>&nbsp;
	      <button id="delete-song-btn" type="button" class="pull-right btn btn-danger">
	        <span class="glyphicon glyphicon-trash"></span>
	      </button>
	      @endif
	    </form>
      </div>
    </div>
  </div>
  <div class="col-md-5">
    <div class="form-group">
      <form id="song-note-form" method="POST" action="/songs/{{ $song->id }}/notes">
	    {{ csrf_field() }}
	    <table id="notetable" class="table">
	      <tbody>
	        @include('notes', ['notes' => $song->notes, 'type' => 'song', 'add_tooltip' => 'Why is this song special to you?'])
	      </tbody>
	    </table>
      </form>
      <form id="delete-song-form" method="POST" action="/songs/{{ $song->id }}">
	    {{ method_field('DELETE') }}
	    {{ csrf_field() }}
      </form>
      <form id="edit-song-note-form" method="POST" action="/songs/{{ $song->id }}/notes/">
	    {{ method_field('PUT') }}
	    {{ csrf_field() }}
	    <input type="hidden" name="note" value="">
      </form>
      <form id="delete-song-note-form" method="POST" action="/songs/{{ $song->id }}/notes/">
	    {{ method_field('DELETE') }}
	    {{ csrf_field() }}
      </form>
    </div>
  </div>

<script language="javascript">
    function drawCharts(data1, max1, data2, max2, data3, max3, data4) {
    	if(data1.length > 1) {
	        drawChart1( data1, max1 );
	    }
    }

  function drawChart1(data, max) {
	    var data = google.visualization.arrayToDataTable(data);

   	var options = {
   	    titlePosition: 'none',
   	    legend:{position:'none'},
   	    height: 300,
   	    width: '100%',
   	    chartArea: {'width': '80%', 'height': '80%'},
   	    tooltip: { trigger: 'selection' },
   	    hAxis: {
   		title: 'Year',
   		titleTextStyle: {
   		    fontName: 'Lato',
   		},
   	    },
   	    vAxis: {
   		title: 'Times Performed',
   		titleTextStyle: {
   		    fontName: 'Lato',           
   		},
   		gridlines: {count: -1},
   		viewWindow:{
   		    max: Math.ceil(max/5)*5,
   		    min:0
   		}          
   	    }
   	};
   
   	var chart = new google.visualization.ColumnChart(
   	    document.getElementById('chart_div1')
   	);
/*
   	chart.setAction({
   	    id: 'shows',
   	    text: 'See Shows',
   	    action: function() {
   		var selection = chart.getSelection();
   		var row = selection[0].row;
   		var year = data.getValue(row, 0);
   		location.href="{{ url()->current() }}/shows?q=" + year;
   	    }
   	});
*/   
   	chart.draw(data, options);
  }

  function drawChartsLocal() {
  
    var data1 = JSON.parse('<?php echo json_encode($songStats) ?>');
    drawCharts(data1);
    window.onresize = drawChartsLocal;
  }

</script>
</div>
@endsection
