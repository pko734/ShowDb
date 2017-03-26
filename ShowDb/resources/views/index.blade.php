@extends('layouts.master')


@section('before_content')
  @include('widgets.slider', ['slides' => [
  'https://media.npr.org/assets/img/2016/06/14/avett-brothers_wide-86bcd6a92ae39d1f3e21d10fa0e450269b0e1533.jpg?s=1400',
  'https://static1.squarespace.com/static/581140ab3e00be2c5f3cb0bf/58116f242e69cfc85d02863c/58116f7237c5813b8c978ed0/1478223164004/Avett+Bros-08684-2.jpg?format=1500w',
  'https://musicmattersmagazine.files.wordpress.com/2016/09/avett-bros-08646.jpg']
  ])
@endsection

@section('content')



@endsection
