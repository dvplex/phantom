@if (isset($permissions[0]->name) )
	<div class="phantom-content permissionSearch">
		<table class="table table-hover">
			<thead>
			<th class="phantom-th" @click="orderBy('name')">{{ __('modules::messages.Name')}}
				<i class="fas" :class="orderClass('name')"></i></th>
			<th class="phantom-th">{{ __('roles::messages.Roles')}}</th>
			<th class="phantom-th">{{ __('messages.Action')}}</th>
			</thead>
			<tbody>
			@foreach($permissions as $permission)
				<tr>
					<td>{{ $permission->name}}</td>
					<td>
						@foreach($permission->roles as $role)
							{{ $role->name}}
							<br>
						@endforeach
					</td>
					<td>
                        <a class="btn btn-sm btn-edit"
                           data-target="#addMenu1"
                           data-backdrop="static"
                           data-keyboard="false"
                           data-toggle="modal"
                           ref="javascript:void(0)"
                           role="menuitem"
                           @click="editItems({{ $permission->toJson() }})"
                           title="{{ __('modules::messages.edit') }}">
                            <i class="far fa-edit" aria-hidden="true"></i>
                        </a>
					</td>
				</tr>
			@endforeach
			</tbody>
		</table>
		{{ $permissions->links() }}
	</div>
@endif
