<?php

namespace dvplex\Phantom\Modules\Routes\Http\Controllers;

use dvplex\Phantom\Modules\Modules\Entities\Module;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use dvplex\Phantom\Modules\Routes\Entities\httpMethod;
use dvplex\Phantom\Modules\Routes\Entities\Middleware;
use dvplex\Phantom\Modules\Routes\Entities\Route;

class RoutesController extends Controller {

	public function search(Request $request) {
		$routes = Module::findOrFail($request->moduleId)->routes()->with('http_methods','middlewares', 'roles', 'permissions')
		->searchInit($request, 'routeSearch')
			->searchFields(['route', 'controllerMethod','http_methods::name'])
			->orderByFields(['route'])
			->search(5);
		foreach ($routes as $route) {
			$middleware = $route->middlewares->map(function ($item) {
				return ['value' => $item['id'], 'label' => $item['name']];
			});
			$role = $route->roles->map(function ($item) {
				return ['value' => $item['id'], 'label' => $item['name']];
			});
			$permission = $route->permissions->map(function ($item) {
				return ['value' => $item['id'], 'label' => $item['name']];
			});
			$http_methods = $route->http_methods->map(function ($item) {
				return ['value' => $item['id'], 'label' => $item['name']];
			});
			$route->setAttribute('middleware', $middleware);
			$route->setAttribute('role', $role);
			$route->setAttribute('permission', $permission);
			$route->setAttribute('httpMethod', $http_methods);
		}
		return view('routes::route-content', compact('routes'));
	}

	/**
	 * Display a listing of the resource.
	 * @return Response
	 */
	public function index() {
		return view('routes::index');
	}

	/**
	 * Show the form for creating a new resource.
	 * @return Response
	 */
	public function create() {
		return view('routes::create');
	}

	/**
	 * Store a newly created resource in storage.
	 * @param  Request $request
	 * @return Response
	 */
	public function store(Request $request) {
		$validatedData = $request->validate([
			'route'            => 'required|unique:routes|max:255|without_spaces',
			'controllerMethod' => 'required|max:255',
		]);

		$routes = new Route();
		$routes->route = $request->route;
		$routes->module_id = $request->moduleId;
		$routes->controllerMethod = $request->controllerMethod;
		$routes->save();

		foreach ($request->middleware as $mw) {
			$middlewares = new Middleware();
			$middlewares->name = $mw['label'];
			$middlewares->route_id = $routes->id;
			$middlewares->save();
		}

		foreach ($request->httpMethod as $hm) {
			$http_method = new httpMethod();
			$http_method->name = $hm['label'];
			$http_method->route_id = $routes->id;
			$http_method->save();
		}

		if ($request->permission) {
			foreach ($request->permission as $pm)
				$routes->givePermissionTo($pm['label']);
		}
		if ($request->role) {
			foreach ($request->role as $pm)
				$routes->assignRole($pm['label']);
		}

		$module = \Modules\Modules\Entities\Module::with('routes.middlewares', 'routes.roles', 'routes.permissions')->findOrFail($request->moduleId);
		$routes = $module->routes()->paginate(5);

		//pagination link
		$routes->withPath(url()->previous());

		return 'routeSearch';
	}

	/**
	 * Show the specified resource.
	 * @return Response
	 */
	public function show() {
		return view('routes::show');
	}

	/**
	 * Show the form for editing the specified resource.
	 * @return Response
	 */
	public function edit() {
		return view('routes::edit');
	}

	/**
	 * Update the specified resource in storage.
	 * @param  Request $request
	 * @return Response
	 */
	public function update(Request $request) {
		$route = Route::find($request->id);
		$route->route = $request->route;
		$route->module_id = $request->moduleId;
		$route->controllerMethod = $request->controllerMethod;
		$route->save();

		$route->syncPermissions();
		if ($request->permission) {
			foreach ($request->permission as $pm)
				$route->givePermissionTo($pm['label']);
		}
		$route->syncRoles();
		if ($request->role) {
			foreach ($request->role as $pm)
				$route->assignRole($pm['label']);
		}

		$middleware = Middleware::where('route_id', $request->id)->delete();
		foreach ($request->middleware as $mw) {
			$middlewares = new Middleware();
			$middlewares->name = $mw['label'];
			$middlewares->route_id = $request->id;
			$middlewares->save();
		}

		httpMethod::where('route_id', $request->id)->delete();
		foreach ($request->httpMethod as $hm) {
			$http_method = new httpMethod();
			$http_method->name = $hm['label'];
			$http_method->route_id = $request->id;
			$http_method->save();
		}

		$module = \Modules\Modules\Entities\Module::with('routes.middlewares', 'routes.roles', 'routes.permissions')->findOrFail($request->module_id);
		$routes = $module->routes()->paginate(5);

		//pagination link
		$routes->withPath(url()->previous());

		return 'routeSearch';
	}

	/**
	 * Remove the specified resource from storage.
	 * @return Response
	 */
	public function destroy(Request $request) {
		$middlewares = Middleware::where('route_id', $request->id)->delete();
		$route = Route::destroy($request->id);

		$module = \Modules\Modules\Entities\Module::with('routes.middlewares', 'routes.roles', 'routes.permissions')->findOrFail($request->module_id);
		$routes = $module->routes()->paginate(5);

		//pagination link
		$routes->withPath(url()->previous());

		return 'routeSearch';
	}
}
