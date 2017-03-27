@extends('layouts.master')
@section('title')
Admin
@endsection
@section('content')
<div class="container">
  <div class="panel panel-default">
  <div class="panel-heading">
    <h3>Users</h3>
  </div>
  <table id="audittable" class="table table-striped">
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
      @foreach($users as $user)
      <tr>
        <td>{{ $user->id }}</td>
        <td><img width="50px" src="{{ $user->avatar}}"></td>
        <td>
          {{ $user->name }}
          @if($user->admin)
          <strong>(admin)</strong>
          @endif
        </td>
        <td>{{ $user->username ?: "none"}}</td>
        <td>{{ $user->email }}</td>
        <td>{{ count($user->shows) }}</td>
        <td>{{ $user->created_at }}</td>
      </tr>
      @endforeach
    </tbody>
  </table>
  {!! $users->render() !!}
  </div>
  </div>
</div>
@endsection