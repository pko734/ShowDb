@extends('layouts.master')
@section('title')
Avett Brothers Stats: ({{ $user->username }})
@endsection
@section('content')
<div class="wrap">

  <div class="container-fluid">
    
    <div class="col-lg-7 col-md-7">
      <div class="row">
	<div class="stats">
	  <h1>Show Stats ({{ $user->username }})</h1>
	  <p><em>Stats about your Avett Brother shows.</em></p>
	  <div class="col-lg-6 col-md-6 space-above">
	    <p>
	      <img src="/img/calendar-past.png" alt="Past Shows icon"><a href="{{ url()->current() }}/shows"><span class="number">{{ count($pastShows) }}</span></a><br>
	      Past Shows
	    </p>
	    <hr>
	    <p>
	      First Show<br>
	      @if($firstShow)
	      <a href="/shows/{{ $firstShow->id }}">{{ $firstShow->date }} {{ $firstShow->venue }}</a>
	    </p>
	    @else
	    N/A
	    @endif
	    <hr>
	    <p>
	      Most Recent Show<br>
	      @if($firstShow)
	      <a href="/shows/{{ $lastShow->id }}">{{ $lastShow->date }} {{ $lastShow->venue }}</a>
	    </p>
	    @else
	    N/A
	    @endif
	    <hr>
	    <p>
	      Unique Songs You've Seen<br>
	      <a href="{{ url()->current() }}/songs">{{ count($songs) }}</a>
	    </p>
	    <hr>
	    <p>
	      Total Song Performances<br>
	      {{ $totalSongs }}
	    </p>
	    <hr>
	  </div> <!-- past shows column -->
	  <div class="col-lg-6 col-md-6 space-above">
	    <p><img src="/img/calendar-upcoming.png" alt="Upcoming Shows icon"><a href="{{ url()->current() }}/shows"><span class="number">{{count($upcomingShows) }}</span></a><br>
	      Upcoming Shows</p>
	    <hr>
	    <p>Next Show<br>
	      @if($nextShow)
	      <a href="/shows/{{ $nextShow->id }}">{{ $nextShow->date }} {{ $nextShow->venue }}</a></p>
	    @else
	    ???
	    @endif
	    <hr>
	    <p>Photos Uploaded<br>
	    @forelse($photos as $img)
	       @if($img->published ||
	           ($user && $user->admin) ||
	           ($user && ($user->id == $img->user_id)))
	    <a href="{{ $img->url }}" 
	       data-gallery
	       data-photo-id="{{ $img->id }}"
	       title="{{ $img->show->date }} {{ $img->show->venue }} @if($img->caption) {{ $img->caption }} - @endif @if($img->photo_credit) Photo Credit: {{ $img->photo_credit }} @endif @if(!$img->published)  - Pending approval @endif"
	       @if($user && $user->admin)
	       data-deletable="1"
	       @if(!$img->published)
	       data-approvable="1"
	       @endif
	       @endif
	       '
	       >
	       <i class="fa fa-image fa-lg
			 @if($img->published)
			 text-primary
			 @else 
			 text-danger
			 @endif" 
		  aria-hidden="true"></i>
	    </a>
	    @endif
            @empty
            N/A
	    @endforelse
	  </div> <!-- upcoming shows column -->
	</div> <!-- stats -->

      </div> <!-- row -->
      <div class="row">
	<div class="albums">
	  <h1>Album Stats</h1>
	  <p><em>The percentage of each Avett Brothers album you have seen live.</em></p>
	  <ul>
            @php($al_percentage = 0)
	    @foreach($albums as $album)
	    @php($found = false)
	    @foreach($albumInfo as $al)
	    @if($al->album_id == $album->id)
  	    @php($al_percentage = round(100*($al->album_songs / $al->total),0))
	    @php($found = true)
            @else
            @if(!$found)
            @php($al_percentage = 0)
	    @endif
	    @endif
	    @endforeach
	    <li>
	      <span class="stat-number">
		{{ $al_percentage }}%
	      </span>
	      <a href="{{ url()->current() }}/albums?id={{ $album->id }}">
		<img src="/img/{{ trim($album->title) }}_dk.jpg" alt="album cover dark" class="dark">
		<img src="/img/{{ trim($album->title) }}.jpg" alt="album cover" class="light">
		<div style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap">
		  {{ $album->title }}
		</div>
	      </a>
	      @if(substr($album->release_date, 0, 4) != "9999")
              {{ substr($album->release_date, 0, 4) }}
              @else
              &nbsp;
	      @endif
	    </li>
	    @endforeach
	  </ul>
          <p><br/></p>
	</div> <!-- albums -->
	
      </div> <!-- row -->
    </div> <!-- left column -->
    <div class="col-lg-5 col-md-5">
      <div class="row">
        <div class="fb-like" data-href="https://www.facebook.com/db.nov.blue/" data-layout="button" data-action="like" data-size="small" data-show-faces="false" data-share="false"></div>
        <div class="fb-share-button" data-href="{{ url()->current() }}" data-layout="button" data-size="small" data-mobile-iframe="true"><a class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}&amp;src=sdkpreparse">Share</a></div>
	<div class="badges">
	  <h2>My Badges</h2>
	  <ul>
	    @foreach($badges as $badge)
	    @if(strpos($badge->code, 'STATE_') === false)
            <li><img src="{{ $badge->image_url }}" alt="{{ $badge->title }}" data-toggle="tooltip" title="{{ $badge->description }}" width="73" height="105"></li>
	    @endif
            @endforeach
	  </ul>
	</div><!-- badges section -->

	@if(count($badges) > 0)
	<div class="badges">
	  <h2>And I Will Travel...</h2>
	  <ul>
	    @foreach($badges as $badge)
	    @if(strpos($badge->code, 'STATE_') !== false)
            <li><img src="{{ $badge->image_url }}" alt="{{ $badge->title }}" data-toggle="tooltip" title="{{ $badge->description }}" width="73" height="105"></li>
	    @endif
            @endforeach
	  </ul>
	</div><!-- badges section -->
	@endif

      </div> <!-- row -->
      
      <div class="row">
	<div class="states">
	  <h1>Location Breakdown</h1>
	  <p><em>It's not the chase that I love, it's me following you...</em></p>
          <p>US States</p>
          <div id="chart_div4"></div>
	</div>

	<div class="yearly">
	  <h1>Yearly Breakdown</h1>
	  <p><em>A comparison of shows and songs across years.</em></p>
          <p>Shows by Year</p>
          <div id="chart_div1"></div>
          <p><br/></p>
          <p>Unique Songs by Year</p>
          <div id="chart_div2"></div>
          <p><br/></p>
          <p>Songs Performances by Year</p>
          <div id="chart_div3"></div>
          <p><br/></p>
	</div> <!-- yearly breakdown section -->

      </div> <!-- row -->
      
      
    </div> <!-- right column -->

  </div> <!-- container -->

<script language="javascript">
    function drawCharts(data1, max1, data2, max2, data3, max3, data4) {
	if(data1.length > 1) {
	    drawChart1( data1, max1 );
	}
	if(data2.length > 1) {
	    drawChart2( data2, max2 );
	}
	if(data3.length > 1) {
	    drawChart3( data3, max3 );
	}
	drawChart4( data4 );
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
		title: 'Number of shows',
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

	chart.draw(data, options);
    }

    function drawChart2(data, max) {
	var data = google.visualization.arrayToDataTable(data);
	var options = {
	    titlePosition: 'none',
	    legend:{position:'none'},
	    height: 300,
	    width: '100%',
	    tooltip: { trigger: 'selection' },
	    chartArea: {'width': '80%', 'height': '80%'},
	    hAxis: {
		title: 'Year',
		titleTextStyle: {
		    fontName: 'Lato',
		},
	    },
	    vAxis: {
		title: 'Number of Unique Songs',
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
	    document.getElementById('chart_div2'));

	chart.setAction({
	    id: 'songs',
	    text: 'See Songs',
	    action: function() {
		var selection = chart.getSelection();
		var row = selection[0].row;
		var year = data.getValue(row, 0);
		location.href="{{ url()->current() }}/songs/?q=" + year;
	    }
	});

	chart.draw(data, options);
    }

    function drawChart3(data, max) {
	var data = google.visualization.arrayToDataTable(data);
	var options = {
	    titlePosition: 'none',
	    legend:{position:'none'},
	    height: 300,
	    width: '100%',
	    tooltip: { trigger: 'selection' },
	    chartArea: {'width': '80%', 'height': '80%'},
	    hAxis: {
		title: 'Year',
		titleTextStyle: {
		    fontName: 'Lato',
		},
	    },
	    vAxis: {
		title: 'Number of Song Performances',
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
	    document.getElementById('chart_div3'));

	chart.draw(data, options);
    }

    function drawChart4(data) {
        var data = google.visualization.arrayToDataTable(data);
        var geochart = new google.visualization.GeoChart(
            document.getElementById('chart_div4')
        );
        var options = {
            region: "US", 
            resolution: "provinces",
            colorAxis: {colors: ['#ccffcc', '#008800']},
	    height: '100%',
            width: '100%',
	    chartArea: {'width': '80%', 'height': '80%'},
        }
        geochart.draw(data, options);
    }


  function drawChartsLocal() {
  
    var data1 = JSON.parse('<?php echo json_encode($yearlyGraphData['shows']) ?>');
    var data2 = JSON.parse('<?php echo json_encode($yearlyGraphData['unique_songs']) ?>');
    var data3 = JSON.parse('<?php echo json_encode($yearlyGraphData['songs']) ?>');
    var data4 = JSON.parse('<?php echo json_encode($stateGraphData) ?>');
    var max1  = {{ $maxShows }};
    var max2  = {{ $maxUnique }};
    var max3  = {{ $maxSongs }};

    drawCharts(data1, max1, data2, max2, data3, max3, data4);
    window.onresize = drawChartsLocal;
  }

</script>
</div> <!-- wrap -->

@endsection
