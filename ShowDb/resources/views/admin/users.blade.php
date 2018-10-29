@extends('layouts.master')
@section('title')
Admin
@endsection
@section('content')
<div class="container">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h3>Users ({{ $userCount }} total)</h3>
    </div>
    <table id="audittable" class="table table-striped infinitable">
      <tbody>
	    <thead>
          <th>ID</th>
          <th>Avatar</th>
          <th>Name</th>
          <th>Username</th>
          <th>Email</th>
          <th>Shows</th>
          <th>Created</th>
	    </thead>
        @include('admin/userdata')
      </tbody>
    </table>
    {!! $users->render() !!}
    <div class="ajax-load text-center" style="display:none">
      <p><img src="http://demo.itsolutionstuff.com/plugin/loader.gif">Loading More post</p>
    </div>
  </div>
</div>
</div>

@endsection
