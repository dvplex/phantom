@if (isset($menuNodes[0]->name) )
	<div class="phantom-content menuNodeSearch">
		<table class="table table-hover table-responsive-sm">
			<thead>
			<th class="phantom-th" @click="orderBy('name')">{{ __('modules::messages.Name')}} <i class="fas" :class="orderClass('name')"></i></th>
			<th class="phantom-th" @click="orderBy('route')">{{ __('modules::messages.Route')}} <i class="fas" :class="orderClass('route')"></i></th>
			<th class="phantom-th">{{ __('messages.Action')}}</th>
			</thead>
			<tbody>
			@foreach($menuNodes as $menuNode)
				<tr>
					<td>{{ $menuNode->name }}</td>
					<td>{{ $menuNode->route }}</td>
					<td>
                        <a class="btn btn-sm btn-edit"
                           data-target="#addRoute"
                           data-backdrop="static"
                           data-keyboard="false"
                           data-toggle="modal"
                           ref="javascript:void(0)"
                           role="menuitem"
                           @click="editItems({{ $menuNode->toJson() }})"
                           title="{{ __('modules::messages.edit') }}">
                            <i class="far fa-edit" aria-hidden="true"></i>
                        </a>
                        <a class="btn btn-sm btn-trash"
                           @click="deleteItems({{ $menuNode->id }},'/{{ app()->getLocale() }}/admin/menuNodes/delete/')">
                            <i class="fas fa-trash" aria-hidden="true"></i>
                        </a>
					</td>
				</tr>
			@endforeach
			</tbody>
		</table>
		{{ $menuNodes->appends(['menuId'=>$menuNodes[0]->menu_id])->links() }}
	</div>
@endif
