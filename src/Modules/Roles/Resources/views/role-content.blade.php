@if (isset($roles[0]->name) )

	<table class="table table-hover">
		<thead>
		<th class="phantom-th" @click="orderBy('name')">{{ __('modules::messages.Name')}}
			<i class="fas" :class="orderClass('name')"></i></th>
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
                    <a class="btn btn-sm btn-edit"
                       data-target="#addMenu"
                       data-backdrop="static"
                       data-keyboard="false"
                       data-toggle="modal"
                       ref="javascript:void(0)"
                       role="menuitem"
                       @click="editItems({{ $role->toJson() }})"
                       title="{{ __('modules::messages.edit') }}">
                        <i class="far fa-edit" aria-hidden="true"></i>
                    </a>
				</td>
			</tr>
		@endforeach
		</tbody>
	</table>
	{{ $roles->links() }}
@endif
