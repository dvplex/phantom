@if (isset($modules[0]->module_name) )
	<table class="table table-hover table-responsive-sm">
		<thead>
		<th class="phantom-th" @click="orderBy('module_name')">{{ __('modules::messages.Name')}}
			<i class="fas" :class="orderClass('module_name')"></i></th>
		<th class="phantom-th" @click="orderBy('module_description')">{{ __('modules::messages.Description')}}
			<i class="fas" :class="orderClass('module_description')"></i></th>
		<th class="phantom-th">{{ __('messages.Action')}}</th>
		</thead>
		<tbody>
		@foreach($modules as $module)
			<tr>
				<td>{{ $module->module_name }}</td>
				<td>{{ $module->module_description }}</td>
				<td>

                    <a class="btn btn-sm btn-details"
                       href="{{ phantom_link('modules@show',['module'=> $module->id]) }}"
                       title="{{ __('messages.details') }}">
                        <i class="fas fa-info-circle" aria-hidden="true"></i>
                    </a>
                    <a class="btn btn-sm btn-edit"
                       data-target="#addMenu"
                       data-backdrop="static"
                       data-keyboard="false"
                       data-toggle="modal"
                       ref="javascript:void(0)"
                       role="menuitem"
                       @click="editItems({{ $module->toJson() }})"
                       title="{{ __('modules::messages.edit') }}">
                        <i class="far fa-edit" aria-hidden="true"></i>
                    </a>
				</td>
			</tr>
		@endforeach
		</tbody>
	</table>
	{{ $modules->links() }}
@endif
