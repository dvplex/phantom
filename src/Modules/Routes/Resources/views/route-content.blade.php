@if (isset($routes[0]->route) )
	<table class="table table-hover">
		<thead>
		<th>{{ __('modules::messages.Route')}}</th>
		<th>{{ __('modules::messages.Controller method')}}</th>
		<th>{{ __('modules::messages.Middlewares')}}</th>
		<th>{{ __('messages.Action')}}</th>
		</thead>
		<tbody>
		@foreach($routes as $route)
			<tr>
				<td><b>{{ mb_strtoupper($route->http_methods->implode('name','|')) }}</b>: {{ $route->route}}</td>
				<td>{{ $route->controllerMethod}}</td>
				<td>
					@foreach($route->middlewares as $mw)
						{{ $mw->name }}<br>
					@endforeach
				</td>
				<td>
					<div class="btn-group" role="group">
						<button type="button" class="btn btn-outline-primary dropdown-toggle btn-xs btn-add" id="exampleIconDropdown1" data-toggle="dropdown" aria-expanded="false">
							<i class="fas fa-bars" aria-hidden="true"></i>
						</button>
						<div class="dropdown-menu" aria-labelledby="exampleIconDropdown1" role="menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 36px, 0px); top: 0px; left: 0px; will-change: transform;">
							<a class="dropdown-item" data-target="#addRoute" data-backdrop="static" data-keyboard="false" data-toggle="modal" ref="javascript:void(0)" role="menuitem" @click="editItems({{ $route->toJson() }})"><i class="icon wb-edit" aria-hidden="true"></i>{{ __('modules::messages.edit') }}
							</a>
							<a class="dropdown-item" @click="deleteItems({{ $route->toJson() }},'/{{ app()->getLocale() }}/routes/delete/')"><i class="icon wb-trash" aria-hidden="true"></i>{{ __('Delete') }}
							</a>
						</div>
					</div>
				</td>
			</tr>
		@endforeach
		</tbody>
	</table>
	{{ $routes->links() }}
@endif
