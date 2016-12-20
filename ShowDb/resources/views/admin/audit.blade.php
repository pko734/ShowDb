@extends('layouts.master')

@section('title')
Admin
@endsection

@section('content')

<h2>Audit Log</h2>

    <table id="audittable" class="table table-striped">
      <tbody>
	@forelse($audits as $audit)
	<tr>
	  <td>{{ \Carbon\Carbon::createFromTimeStamp($audit->created_at->timestamp)->diffForHumans() }}</td>
	  <td>{{ $audit->user->name }}</td>
	  <td><a href="{{ $audit->route }}">{{ $audit->auditable_type }} {{ $audit->type }}</a></td>
	  <td><pre>{{ json_encode(json_decode($audit->old), JSON_PRETTY_PRINT) }}</pre></td>
	  <td><pre>{{ json_encode(json_decode($audit->new), JSON_PRETTY_PRINT) }}</pre></td>
	</tr>
	@empty
	<tr>
	  <td colspan="3">No matches</td>
	</tr>
	@endforelse
      </tbody>
    </table>
    {!! $audits->render() !!}

@endsection
