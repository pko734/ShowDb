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
