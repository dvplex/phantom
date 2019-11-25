@if (isset($roles[0]->name) )

	<table class="table table-hover">
		<thead>
		<th class="phantom-th" @click="orderBy('name')">{{ __('modules::messages.Name')}}
			<i class="icon" :class="orderClass('name')"></i></th>
		<th class="phantom-th">{{ __('roles::messages.Permissions')}}
		<th class="phantom-th">{{ __('messages.Action')}}</th>
		</thead>
		<tbody>
		@foreach($roles as $role)
			<tr>
				<td>{{ $role->name}}</td>
				<td>
					@foreach($role->permissions as $permission)
						{{ $permission->name}}
						<br>
					@endforeach
				</td>
				<td>
					<button class="btn btn-outline-info btn-xs" data-target="#addMenu" data-backdrop="static" data-keyboard="false" data-toggle="modal" ref="javascript:void(0)" role="menuitem" @click="editItems({{ $role->toJson() }})"><i class="icon wb-edit" aria-hidden="true"></i>{{ __('modules::messages.edit') }}</button>
				</td>
			</tr>
		@endforeach
		</tbody>
	</table>
	{{ $roles->links() }}
@endif
