@extends('layouts.master')
@section('title')
Avett Brothers Stats: ({{ $user->username }})
@endsection
@section('content')
<div class="wrap">

        <div class="container-fluid">
			
			<div class="col-lg-6 col-md-6">
				<div class="row">
				<div class="stats">
			<h1>Show Stats ({{ $user->username }})</h1>
			<p><em>Stats about your Avett Brother shows.</em></p>
			<div class="col-lg-6 col-md-6 space-above">
				<p><img src="/img/calendar-past.png" alt="Past Shows icon"><a href="{{ url()->current() }}/shows"><span class="number">{{ count($past_shows) }}</span></a><br>
				Past Shows</p>
				<hr>
				<p>First Show<br>
				@if($first_show)
				<a href="/shows/{{ $first_show->id }}">{{ $first_show->date }} {{ $first_show->venue }}</a></p>
				@else
				N/A
				@endif
				<hr>
				<p>Most Recent Show<br>
				@if($first_show)
				<a href="/shows/{{ $last_show->id }}">{{ $last_show->date }} {{ $last_show->venue }}</a></p>
				@else
				N/A
				@endif
				<hr>
				<p>Unique Songs You've Seen<br>
				<a href="{{ url()->current() }}/songs">{{ count($songs) }}</a></p>
				<hr>
				<p>Total Song Performances<br>
				{{ $total_songs }}</p>
					</div> <!-- past shows column -->
			<div class="col-lg-6 col-md-6 space-above">
				<p><img src="/img/calendar-upcoming.png" alt="Upcoming Shows icon"><a href="{{ url()->current() }}/shows"><span class="number">{{count($upcoming_shows) }}</span></a><br>
				Upcoming Shows</p>
				<hr>
				<p>Next Show<br>
				@if($next_show)
				<a href="/shows/{{ $next_show->id }}">{{ $next_show->date }} {{ $next_show->venue }}</a></p>
				@else
				???
				@endif
				<hr>
<!--
				<p>Incomplete Shows<br>
				<a href="">4 Show(s) with incomplete setlist data</a></p>
				<hr>
-->
				</div> <!-- upcoming shows column -->
				</div> <!-- stats -->

				</div> <!-- row -->
				<div class="row">
				<div class="albums">
				<h1>Album Stats</h1>
				<p><em>The percentage of each Avett Brothers album you have seen live.</em></p>
				<ul>
				  @foreach($albums as $album)
				  @php($found = false)
				  @foreach($album_info as $al)
				  @if($al->album_id == $album->id)
  				    @php($al_percentage = round(100*($al->album_songs / $al->total),0))
				    @php($found = true)
                                  @else
                                    @if(!$found)
                                    @php($al_percentage = 0)
				    @endif
				  @endif
				  @endforeach
				  <li><span class="stat-number">{{ $al_percentage }}%</span><a href="{{ url()->current() }}/albums?id={{ $album->id }}"><img src="/img/{{ trim($album->title) }}_dk.jpg" alt="album cover dark" class="dark"><img src="/img/{{ trim($album->title) }}.jpg" alt="album cover" class="light"><div style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap">{{ $album->title }}</div></a>
				    @if(substr($album->release_date, 0, 4) != "9999")
                                     {{ substr($album->release_date, 0, 4) }}
				    @endif
				  </li>
				  @endforeach
					</ul>
					</div> <!-- albums -->
				
				</div> <!-- row -->
			</div> <!-- left column -->
			<div class="col-lg-6 col-md-6">
				<div class="row">
				<div class="badges">
				<h2>My Badges</h2>
					<ul>
				<li><img src="/img/early-adopter.png" alt="Early Adopter icon"></li>
				<li><img src="/img/year-club.png" alt="Year Club icon"></li>
				<li><img src="/img/donor.png" alt="Donor icon"></li>
				<li><img src="/img/shows.png" alt="Shows icon"></li>
				<li><img src="/img/songs.png" alt="Songs icon"></li>
				<li><img src="/img/unique-songs.png" alt="Unique Songs icons"></li>
				<li><img src="/img/notes.png" alt="Notes icon"></li>
				<li><img src="/img/album.png" alt="Album icon"></li>
						</ul>
						</div><!-- badges section -->
					</div> <!-- row -->
				
				<div class="row">

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">

      // Load the Visualization API and the corechart package.
      google.charts.load('current', {'packages':['corechart']});

      // Set a callback to run when the Google Visualization API is loaded.
      google.charts.setOnLoadCallback(drawCharts);
 
      window.onresize = drawCharts;

      function drawCharts() {
        drawChart1( JSON.parse('<?php echo json_encode($yearly_graph_data['shows']) ?>') );
        drawChart2( JSON.parse('<?php echo json_encode($yearly_graph_data['unique_songs']) ?>') );
        drawChart3( JSON.parse('<?php echo json_encode($yearly_graph_data['songs']) ?>') );
      }

      function drawChart1(data) {
        console.log(data);
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
          gridlines: {count: 6},
          viewWindow:{
              max:{{ $max_shows }},
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

    function drawChart2(data) {
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
          gridlines: {count: 6},
          viewWindow:{
              max: {{ $max_unique }},
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

    function drawChart3(data) {
      var data = google.visualization.arrayToDataTable(data);
      var options = {
        titlePosition: 'none',
        legend:{position:'none'},
        height: 300,
        width: '100%',
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
          gridlines: {count: 6},
          viewWindow:{
              max: {{ $max_songs }},
              min:0
          }          
        }
      };

      var chart = new google.visualization.ColumnChart(
        document.getElementById('chart_div3'));

      chart.draw(data, options);
    }


    </script>

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
					</div> <!-- yearly breakdown section -->

				</div> <!-- row -->
				
				
				</div> <!-- right column -->

        </div> <!-- container -->
	
	</div> <!-- wrap -->
