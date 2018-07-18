@extends('layouts.master')
@section('title')
{{ $show->date }} {{ $show->venue }}
@endsection
@section('content')
<script>
  window.Laravel = <?php echo json_encode([
                         'csrfToken' => csrf_token(),
  'showId' => $show->id,
  'username' => (isset($user)) ? $user->name : '',
  'showDetail' => "{$show->date} {$show->venue}",
  ]); ?>
</script>
<div class="container">

  <div class="col-md-6">
    <div class="panel panel-default">
      <div class="panel-body">
	    <form method="GET" action="{{ url()->current() }}/edit">
	      @if($displayShowDate)
	      <div class="form-group">
	        <label for="show_date">Show Date</label>
		    <div class="input-group">
	          <input disabled value="{{ $show->date }}"
		             type="text"
		             class="form-control"
		             id="show_date"
		             placeholder="YYYY-MM-DD">
		        @if($user && $show->users->contains($user->id))
                <span class="input-group-addon">
		          <a data-toggle="tooltip"
		             data-placement="bottom"
		             class="remove-show-link"
		             data-show-id="{{ $show->id }}"
		             title="Remove from my shows" href="">
		            <i style="color: green;" class="far fa-check-square" aria-hidden="true"></i></a>
                </span>
		          @elseif($user)
                <span class="input-group-addon">
		          <a data-toggle="tooltip"
		             data-placement="bottom"
		             class="add-show-link"
		             data-show-id="{{ $show->id }}"
		             title="Add to my shows" href="">
		            <i style="color: green;" class="far fa-square" aria-hidden="true"></i></a>
                </span>
                @endif
                <span class="input-group-addon">
                  @if($prevShow)
                    <a title="Previous Show" 
                       href="/shows/{{ $prevShow->id }}"
                       data-placement="bottom"
                       data-toggle="tooltip">
                  @endif
                    <span class="glyphicon glyphicon-step-backward"></span>
                  @if($prevShow)
                  </a>
                  @endif
                </span>
                <span class="input-group-addon">
                  @if($nextShow)
                  <a title="Next Show" 
                     href="/shows/{{ $nextShow->id }}"
                     data-placement="bottom"
                     data-toggle="tooltip">
                  @endif
                  <span class="glyphicon glyphicon-step-forward"></span>
                  @if($nextShow)              
                  </a>
                  @endif
                </span>
	        </div>
          </div>
	      @else
	      <input disabled value="{{ $show->date }}"
		         type="hidden"
		         class="form-control"
		         id="show_date"
		         placeholder="YYYY-MM-DD">
	      @endif
	      <div class="form-group">
	        <label for="show_venue">Show {{ $venueDisplay }}</label>
	        <input disabled value="{{ $show->venue }}"
		           type="text"
		           class="form-control"
		           id="show_venue"
		           placeholder="Venue - City, State">
	      </div>
	      <div class="form-group">
	        <label for="show_state">State / Provence / Country</label>
	        <input disabled value="{{ $show->state()->first() == null ? '' : $show->state()->first()->name }}"
		           type="text"
		           class="form-control"
		           id="show_state"
		           placeholder="State Name">
	      </div>
	      <div class="form-group">
	        <label>Photos</label>
	        <div>
	          @if($user)
	          <i class="clickable photo-add-btn fa fa-plus" title="Add a photo"></i>&nbsp;
	          @endif
	          &nbsp;
	          @foreach($images as $img)
	          @if($img->published ||
	          ($user && $user->admin) ||
	          ($user && ($user->id == $img->user_id)))
	          <a href="{{ $img->url }}" 
	             data-gallery
	             data-photo-id="{{ $img->id }}"
	             title="@if($img->caption) {{ $img->caption }} - @endif @if($img->photo_credit) Photo Credit: {{ $img->photo_credit }} @endif @if(!$img->published)  - Pending approval @endif"
	             @if($user && $user->admin)
	            data-deletable="1"
	            @if(!$img->published)
	            data-approvable="1"
	            @endif
	            @endif
	            '
	            >
	            <i class="far fa-image fa-lg
			              @if($img->published)
			              text-primary
			              @else 
			              text-danger
			              @endif" 
		           aria-hidden="true"></i>
	          </a>
	          @endif
	          @endforeach
	        </div>
	      </div>
	      <label>
	        Set List
	      </label>
	      @if($displayComplete)
	      @if($show->incomplete_setlist)
	      <span class="incomplete-setlist">(incomplete)</span>
	      @else
	      <span class="complete-setlist">(complete)</span>
	      @endif
	      @endif
	      <table class="table table">
	        <tbody>
              @php($encore_row_missing = true)
	          @foreach($show->setlistItems->sortBy('order') as $item)
              @if($item->encore && $encore_row_missing)
	          <tr class="item-row">
		        <td colspan="3"><i>Encore</i></td>
              </tr>
              @php($encore_row_missing = false)
              @endif
	          <tr class="item-row">
		        <td>{{ $item->order }}.
		          <a href="/songs/{{ $item->song->id }}">{{ $item->song->title }}</a>
		          @if($item->interlude_song_id)
		          <br/><em>Interlude: {{ $item->interludeSong->title }}</em>
		          @endif
		        </td>
		        <td>
		          @if( (count($item->notes) > 0) && ($item->notes->get(0)->published || ($user && $user->id == $item->notes->get(0)->creator->id)))
		          <a class="video_link"
		             target="_vids"
		             data-gallery
		             title="{{ $show->date }} {{ $show->venue }} {{ $item->song->title }}"
		             href="{{ $item->notes->get(0)->note }}"
		             type="text/html"
		             >
		            <i class="fab fa-youtube" aria-hidden="true"></i>
		          </a>
		          @endif
		        </td>
		        <td>
		          @if($user && $user->admin)
		          @if( count($item->notes) === 0)
		          <small class="edit-video-btn"
			             data-item-id="{{ $item->id }}">
		            <span class="glyphicon glyphicon-pencil"></span>
		          </small>
		          @else
		          <small class="delete-video-btn"
			             data-item-id="{{ $item->id }}"
			             data-video-id="{{ $item->notes->get(0)->id }}">
		            <span class="glyphicon glyphicon-remove"></span>
		          </small>
		          @endif
		          @endif
		        </td>
	          </tr>
	          @endforeach
	          <tr>
		        <td colspan="3">
		          @if(($user && $user->admin) || ($user && ($show->user_id == $user->id)))
		          <span class="input-grp-btn">
		            <button type="submit" class="pull-left btn btn-primary">Edit Show</button>
		          </span>
		          <span class="input-grp-btn">
		            <button id="delete-show-btn"
			                type="button"
			                class="pull-right btn btn-danger">
		              <span class="glyphicon glyphicon-trash"></span>
		            </button>
		          </span>
		          @endif
		        </td>
	          </tr>
	        </tbody>
	      </table>
	    </form>
    </div></div>
  </div>
  <form id="delete-show-form" method="POST" action="{{ url()->current() }}">
    {{ method_field('DELETE') }}
    {{ csrf_field() }}
  </form>
  <div class="col-md-6">
    @if(count($show->setlistItems) > 0)
    <div class="panel panel-default">
      <div class="panel-body">
        <div id="chart_div1" style="height: 300px;">
          <div style="height: 100%; width: 100%; text-align: center; text-align: center;">
            <div style="height: 100%; opacity: 0.5; padding: 100px">
              <p><i class="fas fa-spinner fa-4x faa-spin animated"></i></p>
              <p>
                <i>I am a Breathing Time Machine</i>
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
    @endif
    <form id="show-note-form" method="POST" action="{{ url()->current() }}/notes">
      {{ csrf_field() }}
      <div class="form-group">
	    <table id="notetable" class="table">
	      <tbody>
	        @include('notes', ['notes' => $show->notes, 'type' => 'show', 'add_tooltip' => $noteTooltip])
	      </tbody>
	    </table>
      </div>
    </form>
    <form id="delete-show-note-form" method="POST" action="{{ url()->current() }}/notes/">
      {{ method_field('DELETE') }}
      {{ csrf_field() }}
    </form>
    <form id="delete-photo-form" method="POST" action="{{ url()->current() }}/photos/">
      {{ method_field('DELETE') }}
      {{ csrf_field() }}
    </form>
    <form id="edit-show-note-form" method="POST" action="{{ url()->current() }}/notes/">
      {{ method_field('PUT') }}
      {{ csrf_field() }}
      <input type="hidden" name="note" value="">
    </form>
    <form id="approve-photo-form" method="POST" action="{{ url()->current() }}/photos/">
      {{ method_field('PUT') }}
      {{ csrf_field() }}
      <input type="hidden" name="published" value="1">
    </form>
    <form id="add-video-form" method="POST" action="#">
      <input id="videoinput" type="hidden" name="video_url" value="">
      {{ csrf_field() }}
    </form>
    <form id="delete-video-form" method="POST" action="#">
      {{ csrf_field() }}
      {{ method_field('DELETE') }}
    </form>
  </div>

</div>
<form method="POST" id="user-add-show-form" action="">
  {{ csrf_field() }}
</form>
<form method="POST" id="user-remove-show-form" action="">
  {{ method_field('DELETE') }}
  {{ csrf_field() }}
</form>
<script language="javascript">
    function drawCharts(data1, max1, data2, max2, data3, max3, data4) {
    	if(data1.length > 1) {
	        drawChart1( data1, max1 );	    
	    }
    }
  function drawChart1(data, max) {
    var dataTable = new google.visualization.DataTable();
    dataTable.addColumn('string', 'Album');
    dataTable.addColumn('number', 'Songs');
    dataTable.addColumn({type: 'string', role: 'tooltip', p: {html: true}});
    dataTable.addRows(data);
    //var data = google.visualization.arrayToDataTable(data);

    //data.setColumnProperty(2, 'role', 'tooltip');
    //data.setColumnProperty(2, 'html', true);

   	var options = {
        title: 'Setlist Breakdown by Album',
   	    //titlePosition: 'none',
   	    //legend:{position:'none'},
        //legend: 'none',
        tooltip: {isHtml: true},
        pieSliceText: 'value-and-percentage',
   	    height: 300,
   	    width: '100%',
   	    chartArea: {'width': '90%', 'height': '85%'},
   	    tooltip: { trigger: 'selection', isHtml: true },
    };
   
    if(document.getElementById('chart_div1')) {
     	var chart = new google.visualization.PieChart(
     	    document.getElementById('chart_div1')
   	    );
      	chart.draw(dataTable, options);
    }
  }

  function drawChartsLocal() {
  
    var data1 = <?php echo json_encode($albumChartData) ?>;
    drawCharts(data1);
    window.onresize = drawChartsLocal;
  }

</script>

@endsection
