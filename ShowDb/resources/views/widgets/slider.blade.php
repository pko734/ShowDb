<div class="bg-slider" data-bg-images="
  @foreach ($slides as $slide)
     '{{$slide}}',
  @endforeach">
  @include('widgets.loading')
</div>
