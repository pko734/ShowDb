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
var timeline_json = '{}'; // replace make_the_json() with the JSON object you created
// two arguments: the id of the Timeline container (no '#')
// and the JSON object or an instance of TL.TimelineConfig created from
// a suitable JSON object
window.timeline = new TL.Timeline('timeline-embed', timeline_json);
</script>
@endif
@endsection
