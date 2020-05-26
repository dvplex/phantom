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
                    <a class="btn btn-sm btn-edit"
                       data-target="#addRoute"
                       data-backdrop="static"
                       data-keyboard="false"
                       data-toggle="modal"
                       ref="javascript:void(0)"
                       role="menuitem"
                       @click="editItems({{ $route->toJson() }})"
                       title="{{ __('modules::messages.edit') }}">
                        <i class="far fa-edit" aria-hidden="true"></i>
                    </a>
                    <a class="btn btn-sm btn-trash"
                       @click="deleteItems({{ $route->id }},'/{{ app()->getLocale() }}/admin/routes/delete/')">
                        <i class="fas fa-trash" aria-hidden="true"></i>
                    </a>
                </td>
			</tr>
		@endforeach
		</tbody>
	</table>
	{{ $routes->links() }}
@endif
