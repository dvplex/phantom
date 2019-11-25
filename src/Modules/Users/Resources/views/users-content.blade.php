@if (isset($users[0]->username) )
	<table class="table table-hover table-condensed">
		<thead>
		<tr>
			<th>{{ __('users::messages.Name') }}</th>
			<th>{{ __('users::messages.Email') }}</th>
			<th>{{ __('messages.Action') }}</th>
		</tr>
		</thead>
		<tbody>
		@foreach($users as $user)
			<tr>
				<td>
					<div class="user-avatar">
						<img class="img-circle img-bordered-sm" src="/images/avatar/{{ $user->user_avatar }}" alt="">
					</div>
					<span style="color:#000">{{ $user->name }}</span> ({{ $user->username }})
				</td>
				<td>{{ $user->email }}</td>
				<td>
					<button class="btn btn-sm btn-primary" data-target="#addUser" data-backdrop="static" data-keyboard="false" data-toggle="modal" @click="editItems({{ $user->toJson() }})">{{ __('modules::messages.edit') }}</button>
				</td>
			</tr>
		@endforeach
		</tbody>
	</table>
	{{ $users->links() }}
@endif
