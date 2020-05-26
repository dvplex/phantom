@if (isset($menus[0]->name) )
		<table class="table table-hover">
			<thead>
			<th class="phantom-th" @click="orderBy('name')">{{ __('modules::messages.Name')}}
				<i class="fas" :class="orderClass('name')"></i></th>
			<th class="phantom-th" @click="orderBy('description')">{{ __('modules::messages.Description')}}
				<i class="fas" :class="orderClass('description')"></i></th>
			<th class="phantom-th">{{ __('messages.Action')}}</th>
			</thead>
			<tbody>
			@foreach($menus as $menu)
				<tr>
					<td>{{ $menu->name}}</td>
					<td>{{ $menu->description}}</td>
					<td>
                        <a class="btn btn-sm btn-details"
                           href="{{ phantom_link('menus@show',['menu'=> $menu->name]) }}"
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
                           @click="editItems({{ $menu->toJson() }})"
                           title="{{ __('modules::messages.edit') }}">
                            <i class="far fa-edit" aria-hidden="true"></i>
                        </a>
                        <a class="btn btn-sm btn-trash"
                           @click="deleteItems({{ $menu->id }},'/{{ app()->getLocale() }}/admin/menus/delete/')">
                            <i class="fas fa-trash" aria-hidden="true"></i>
                        </a>
					</td>
				</tr>
			@endforeach
			</tbody>
		</table>
		{{ $menus->links() }}
@endif
