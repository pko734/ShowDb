@extends('layouts.master')
@section('title')Timeline @endsection
@section('content')

@if($user)
<script src="/js/timeline.js"></script>
<div id='timeline-embed' style="width: 100%; height: 100%;"></div>
<script type="text/javascript">
    $(document).ready(function() {
        $(document).on('click', '.setlist_open a', function(e) {
            e.stopPropagation();
            e.preventDefault();
            $(e.target.parentElement.nextElementSibling).slideToggle();
        });
    });
    $(document).ready(function(){
              
              var timeline_json = <?php echo json_encode($timeline); ?>;
              // replace make_the_json() with the JSON object you created
              // two arguments: the id of the Timeline container (no '#')
              // and the JSON object or an instance of TL.TimelineConfig created from
              // a suitable JSON object
              var options = {
                  hash_bookmark: true,
                  embed_id: 'timeline-embed',
                  ga_property_id: 'UA-65243648-2',
                  skinny_size: 800,
                  medium_size: 1200,
                  slide_padding_lr: 50,
                  timenav_height_min: 50,
                  timenav_height_percentage: 25,
                  timenav_mobile_height_percentage: 25,
                  dragging: false
              }
              window.timeline = new TL.Timeline('timeline-embed', timeline_json, options);


        var embed = document.getElementById('timeline-embed');
        embed.style.height = getComputedStyle(document.body).height;
        window.timeline = new TL.Timeline('timeline-embed', timeline_json, options );
        window.addEventListener('resize', function() {
          var embed = document.getElementById('timeline-embed');
          embed.style.height = getComputedStyle(document.body).height;
          timeline.updateDisplay();
        });
      });
</script>
@endif

@endsection
