@extends('layouts.master')
@section('title')
Timeline
@endsection
@section('content')

@if($user && $user->admin)
<!-- 1 -->
<link title="timeline-styles" rel="stylesheet" href="https://cdn.knightlab.com/libs/timeline3/latest/css/timeline.css">
<!-- 2 -->
<script src="https://cdn.knightlab.com/libs/timeline3/latest/js/timeline.js"></script>
<div id='timeline-embed' style="width: 100%; height: 600px"></div>
<!-- 3 -->
<script type="text/javascript">
var timeline_json = <?php echo json_encode($timeline); ?>;
 // replace make_the_json() with the JSON object you created
// two arguments: the id of the Timeline container (no '#')
// and the JSON object or an instance of TL.TimelineConfig created from
// a suitable JSON object
var options = {
     hash_bookmark: true,
     width: '100%',
     embed_id: 'timeline-embed',
     ga_property_id: 'UA-65243648-2'
}
window.timeline = new TL.Timeline('timeline-embed', timeline_json, options);

    $(document).ready(function(){
        var embed = document.getElementById('timeline-embed');
        embed.style.height = getComputedStyle(document.body).height;
        window.timeline = new TL.Timeline('timeline-embed', timeline_json, options );
        window.addEventListener('resize', function() {
          var embed = document.getElementById('timeline-embed');
          embed.style.height = getComputedStyle(document.body).height;
          timeline.updateDisplay();
        })
      });
</script>
@endif

@endsection
