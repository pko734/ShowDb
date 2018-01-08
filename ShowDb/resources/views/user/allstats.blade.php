@extends('layouts.master')

@section('title')
Database Stats
@endsection

@section('content')

<div class="panel panel-default container">
  <div class="panel-heading row">
    <h1>Database Stats</h1>
    <p>
    <em>
    General Database Statistics.  PLEASE NOTE: data from the early years is sparse and incomplete!
    </em>
    </p>
  </div><!--/.panel-heading -->

  <div class="panel-body">
          <div id="chart_div1"></div>
          <div id="chart_div2"></div>
          <div id="chart_div3"></div>
          <div id="chart_div4"></div>
  </div>
<script language="javascript">
    function drawCharts(data1, max1, data2, max2, data3, max3, histogram) {
	if(data1.length > 1) {
	    drawChart1( data1, max1 );
	}
	if(data2.length > 1) {
	    drawChart2( data2, max2 );
	}
	if(data3.length > 1) {
	    drawChart3( data3, max3 );
	}
	drawHisto(histogram);
    }

    function drawHisto(data) {
	var data = google.visualization.arrayToDataTable(data);

        var chart = new google.visualization.Histogram(
            document.getElementById('chart_div4')
        );
	var options = {
	    title: 'Distribution of users by number of shows',
	    legend:{position:'none'},
	    height: 400,
	    width: '100%',
	    colors: ['#377bb5'],
            histogram: {
	        bucketSize: 5,
            },
            vAxis: { 
	    	scaleType: 'none', 
                title: 'Number of users',
	    },
	    hAxis: {
	        title: 'Number of shows',
            },
//	    histogram: { bucketSize: 2 }
        };
        chart.draw(data, options);
    }

    function getChartOptions(title, vaxis_title, haxis_title, max, height) {
        return options = {
	    title: title,
	    legend:{position:'none'},
	    height: height,
	    width: '100%',
	    tooltip: { trigger: 'selection' },
	    hAxis: {
	        title: haxis_title,
                textStyle: {
                    fontSize: 12
                },
	    },
	    vAxis: {
		title: vaxis_title,
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
    }

    function drawChart1(data, max) {
	var data = google.visualization.arrayToDataTable(data);

	var options = getChartOptions('Number of shows per year in the database', 'Number of shows', 'Year', max, 400);

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
		location.href="/shows?q=" + year;
	    }
	});

	chart.draw(data, options);
    }

    function drawChart2(data, max) {
	var data = google.visualization.arrayToDataTable(data);
	var options = getChartOptions('Number of unique songs per year in the database', 'Number of unique songs', 'Year', max, 400);

	var chart = new google.visualization.ColumnChart(
	    document.getElementById('chart_div2'));

	chart.draw(data, options);
    }

    function drawChart3(data, max) {
	var data = google.visualization.arrayToDataTable(data);
	var options = getChartOptions('Number of song performances per year in the database', 'Number of song performances','Year', max, 400);

	var chart = new google.visualization.ColumnChart(
	    document.getElementById('chart_div3'));

	chart.draw(data, options);
    }


  function drawChartsLocal() {
  
    var data1 = JSON.parse('<?php echo json_encode($yearly_graph_data['shows']) ?>');
    var data2 = JSON.parse('<?php echo json_encode($yearly_graph_data['unique_songs']) ?>');
    var data3 = JSON.parse('<?php echo json_encode($yearly_graph_data['songs']) ?>');
    var max1  = {{ $max_shows }};
    var max2  = {{ $max_unique }};
    var max3  = {{ $max_songs }};
    var histogram = JSON.parse('<?php echo json_encode($all_user_show_data) ?>');

    drawCharts(data1, max1, data2, max2, data3, max3, histogram);
    window.onresize = drawChartsLocal;
  }
</script>

@endsection
