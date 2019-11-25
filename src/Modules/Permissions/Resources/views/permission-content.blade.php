@if (isset($permissions[0]->name) )
	<div class="phantom-content permissionSearch">
		<table class="table table-hover table-responsive-sm">
			<thead>
			<th class="phantom-th" @click="orderBy('name')">{{ __('modules::messages.Name')}}
				<i class="icon" :class="orderClass('name')"></i></th>
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
						<button class="btn btn-outline-info btn-xs" data-target="#addMenu1" data-backdrop="static" data-keyboard="false" data-toggle="modal" ref="javascript:void(0)" role="menuitem" @click="editItems({{ $permission->toJson() }})"><i class="icon wb-edit" aria-hidden="true"></i>{{ __('modules::messages.edit') }}
						</button>

					</td>
				</tr>
			@endforeach
			</tbody>
		</table>
		{{ $permissions->links() }}
	</div>
@endif
