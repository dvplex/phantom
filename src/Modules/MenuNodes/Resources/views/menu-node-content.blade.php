@if (isset($menuNodes[0]->name) )
	<div class="phantom-content menuNodeSearch">
		<table class="table table-hover table-responsive-sm">
			<thead>
			<th class="phantom-th" @click="orderBy('name')">{{ __('modules::messages.Name')}} <i class="icon" :class="orderClass('name')"></i></th>
			<th class="phantom-th" @click="orderBy('route')">{{ __('modules::messages.Route')}} <i class="icon" :class="orderClass('route')"></i></th>
			<th class="phantom-th">{{ __('messages.Action')}}</th>
			</thead>
			<tbody>
			@foreach($menuNodes as $menuNode)
				<tr>
					<td>{{ $menuNode->name }}</td>
					<td>{{ $menuNode->route }}</td>
					<td>
						<div class="btn-group" role="group">
							<button type="button" class="btn btn-outline-primary dropdown-toggle btn-xs btn-add" id="exampleIconDropdown1" data-toggle="dropdown" aria-expanded="false">
								<i class="fas fa-bars" aria-hidden="true"></i>
							</button>
							<div class="dropdown-menu" aria-labelledby="exampleIconDropdown1" role="menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 36px, 0px); top: 0px; left: 0px; will-change: transform;">
								<a class="dropdown-item" data-target="#addRoute" data-backdrop="static" data-keyboard="false" data-toggle="modal" ref="javascript:void(0)" role="menuitem" @click="editItems({{ $menuNode->toJson() }})"><i class="icon wb-edit" aria-hidden="true"></i>{{ __('modules::messages.edit') }}
								</a>
								<a class="dropdown-item" @click="deleteItems({{ $menuNode->toJson() }},'/{{ app()->getLocale() }}/menuNodes/delete/')"><i class="icon wb-trash" aria-hidden="true"></i>{{ __('Delete') }}
								</a>
							</div>
						</div>
					</td>
				</tr>
			@endforeach
			</tbody>
		</table>
		{{ $menuNodes->appends(['menuId'=>$menuNodes[0]->menu_id])->links() }}
	</div>
@endif
