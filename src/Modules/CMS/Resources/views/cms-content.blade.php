@if ($layouts->count() )
		<table class="table table-hover">
			<thead>
			<th class="phantom-th">{{ __('modules::messages.Name')}}</th>
			<th class="phantom-th">{{ __('modules::messages.Description')}}</th>
			<th class="phantom-th">{{ __('messages.Action')}}</th>
			</thead>
			<tbody>
			@foreach($layouts as $layout)
				<tr>
					<td>{{ $layout['file_name']}}</td>
					<td>{{ $layout['description']}}</td>
					<td>

						<div class="btn-group" role="group">
							<button type="button" class="btn btn-outline-info dropdown-toggle btn-xs btn-add" id="exampleIconDropdown1" data-toggle="dropdown" aria-expanded="false">
								<i class="fas fa-bars" aria-hidden="true"></i>
							</button>
							<div class="dropdown-menu" aria-labelledby="exampleIconDropdown1" role="menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 36px, 0px); top: 0px; left: 0px; will-change: transform;">
								<a class="dropdown-item" href="{{ phantom_link('menus@show',['menu'=> $layout['id']]) }}"><i class="icon wb-info" aria-hidden="true"></i>{{ __('messages.details') }}
								</a>
								<a class="dropdown-item" data-target="#addMenu" data-backdrop="static" data-keyboard="false" data-toggle="modal" ref="javascript:void(0)" role="menuitem" @click="editItems({{ $layout->toJson() }})"><i class="icon wb-edit" aria-hidden="true"></i>{{ __('modules::messages.edit') }}
								</a>
							</div>
						</div>
					</td>
				</tr>
			@endforeach
			</tbody>
		</table>
		{{ $layouts->links() }}
@endif
