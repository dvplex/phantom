<?php

namespace dvplex\Phantom\Modules\Menus\Http\Controllers;

use dvplex\Phantom\Models\Permission;
use dvplex\Phantom\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Routing\Router;
use dvplex\Phantom\Modules\MenuNodes\Entities\MenuNode;
use dvplex\Phantom\Modules\Menus\Entities\Menu;
use dvplex\Phantom\Modules\Routes\Entities\Route;

class MenusController extends Controller {
	/**
	 * Display a listing of the resource.
	 * @return Response
	 */

	public function search(Request $request) {
		$menus = Menu::with('roles', 'permissions')
			->searchInit($request, 'menuSearch')
			->searchFields(['description', 'name'])
			->orderByFields(['description', 'name'])
			->search(5);
		foreach ($menus as $menu) {
			$role = $menu->roles()->get()->map(function ($item) {
				return ['value' => $item['id'], 'label' => $item['name']];
			});
			$permission = $menu->permissions()->get()->map(function ($item) {
				return ['value' => $item['id'], 'label' => $item['name']];
			});
			$menu->setAttribute('role', $role);
			$menu->setAttribute('permission', $permission);
	}

		return view('menus::menu-content', compact('menus'));
	}

	public function index() {
		$permissions = Permission::all();
		$mid = [];
		$n = 0;
		foreach ($permissions as $permission) {
			$mid[$n]['label'] = $permission['name'];
			$mid[$n]['value'] = $permission['id'];
			$n++;
		}
		$permissions = json_encode($mid);

		$roles = Role::all();
		$mid = [];
		$n = 0;
		foreach ($roles as $role) {

			$mid[$n]['label'] = $role['name'];
			$mid[$n]['value'] = $role['id'];
			$n++;
		}
		$roles = json_encode($mid);

		return view('menus::index', compact('roles', 'permissions'));
	}

	/**
	 * Show the form for creating a new resource.
	 * @return Response
	 */
	public function create() {
		return view('menus::create');
	}

	/**
	 * Store a newly created resource in storage.
	 * @param  Request $request
	 * @return Response
	 */
	public function store(Request $request) {
		$validatedData = $request->validate([
			'name'        => 'required|unique:menu_nodes|max:255|without_spaces',
			'description' => 'required|min:2',
		]);
		$menu = new Menu();
		$menu->name = $request->name;
		$menu->description = $request->description;
		$menu->save();

		if ($request->permission) {
			foreach ($request->permission as $pm) {
				$menu->givePermissionTo($pm['label']);
			}
		}
		if ($request->role) {
			foreach ($request->role as $pm) {
				$menu->assignRole($pm['label']);
			}
		}

		return 'menuSearch';
	}

	/**
	 * Show the specified resource.
	 * @return Response
	 */
	public function show($lang, $menu_id) {
		$fa_icons = get_fa_icons();
		$route = [];
		$routes = app()->routes->getRoutes();
		$n = 0;
		foreach ($routes as $rt) {

			if ($rt->getName() && preg_match_all('/\}/', $rt->uri(), $m)) {
				if (count($m[0]) == 1 && preg_match('/^{lang/', $rt->uri())) {
					$route[$n]['label'] = $rt->uri();
					$route[$n]['value'] = $rt->getName();
					$n++;
				}
			}
		}
		$menu = Menu::with('nodes')->findOrFail($menu_id);
		$menuNodes = $menu->nodes()->get();
		$parentNodes = [];
		$m = 0;
		foreach ($menuNodes as $node) {
			$parentNodes[$m]['value'] = $node->id;
			$parentNodes[$m]['label'] = $node->name;
			$m++;

		}
		$routes = json_encode($route);
		$parentNodes = json_encode($parentNodes);
		$fa_icons = json_encode($fa_icons);

		$permissions = Permission::all();
		$mid = [];
		$n = 0;
		foreach ($permissions as $permission) {
			$mid[$n]['label'] = $permission['name'];
			$mid[$n]['value'] = $permission['id'];
			$n++;
		}
		$permissions = json_encode($mid);

		$roles = Role::all();
		$mid = [];
		$n = 0;
		foreach ($roles as $role) {

			$mid[$n]['label'] = $role['name'];
			$mid[$n]['value'] = $role['id'];
			$n++;
		}
		$roles = json_encode($mid);
		$pn='';

		return view('menus::show', compact('menu', 'menuNodes', 'routes', 'parentNodes', 'pn', 'fa_icons', 'roles', 'permissions'));
	}

	/**
	 * Show the form for editing the specified resource.
	 * @return Response
	 */
	public function edit() {
		return view('menus::edit');
	}

	/**
	 * Update the specified resource in storage.
	 * @param  Request $request
	 * @return Response
	 */
	public function update(Request $request) {
		$validatedData = $request->validate([
			'name'        => 'required|unique:menus,name,' . $request->id . '|max:255|without_spaces',
			'description' => 'required|min:2',
		]);

		$menu = Menu::find($request->id);
		$menu->name = $request->name;
		$menu->description = $request->description;

		$menu->save();

		$menu->syncPermissions();
		if ($request->permission) {
			foreach ($request->permission as $pm) {
				$menu->givePermissionTo($pm['label']);
			}
		}
		$menu->syncRoles();
		if ($request->role) {
			foreach ($request->role as $pm) {
				$menu->assignRole($pm['label']);
			}
		}

		return 'menuSearch';
	}

	private static function orderNodes($tree, $order, $is_leaf = false) {
		$node = MenuNode::find($tree['id']);
		$node->menu_pos = $order;
		$node->save();
		if (!isset($tree['children']) && !$is_leaf) {
			$node->makeRoot();
		}
		elseif (isset($tree['children'])) {
			foreach ($tree['children'] as $nd) {
				self::orderNodes($nd, 1);

			}
		}
		return;
	}

	public function buildTree(Request $request) {
		$tree = array_values(array_filter($request->menuTree));
		$n = 0;
		foreach ($tree as $tt) {
			self::orderNodes($tt, $n);
			$n++;
		}
		MenuNode::buildTree($tree);

		return 'menuSearch';

	}

	/**
	 * Remove the specified resource from storage.
	 * @return Response
	 */
	public function destroy() {
	}
}
