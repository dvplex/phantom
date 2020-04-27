@if (isset($users[0]->username) )
	<table class="table table-hover table-condensed">
		<thead>
		<tr>
            <th class="phantom-th" @click="orderBy('name')">{{ __('users::messages.Name')}}
                <i class="fas" :class="orderClass('name')"></i></th>
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
                    <a class="btn btn-sm btn-edit"
                       data-target="#addUser"
                       data-backdrop="static"
                       data-keyboard="false"
                       data-toggle="modal"
                       ref="javascript:void(0)"
                       role="menuitem"
                       @click="editItems({{ $user->toJson() }})"
                       title="{{ __('modules::messages.edit') }}">
                        <i class="far fa-edit" aria-hidden="true"></i>
                    </a>
				</td>
			</tr>
		@endforeach
		</tbody>
	</table>
	{{ $users->links() }}
@endif
