<?php

namespace dvplex\Phantom\Modules\MenuNodes\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use dvplex\Phantom\Modules\MenuNodes\Entities\MenuNode;

class MenuNodesController extends Controller {
	/**
	 * Display a listing of the resource.
	 * @return Response
	 */

	public function search(Request $request) {
		$menuNodes = MenuNode::with('roles','permissions')->where('menu_id', $request->menuId)
			->searchInit($request, 'menuNodeSearch')
			->searchFields(['name'])
			->orderByFields(['name'])
			->search(5);
		$routes = app()->routes->getRoutes();
		$parentNodes = [];
		foreach ($menuNodes as $node) {
			$role = $node->roles()->get()->map(function ($item) {
				return ['value' => $item['id'], 'label' => $item['name']];
			});
			$permission = $node->permissions()->get()->map(function ($item) {
				return ['value' => $item['id'], 'label' => $item['name']];
			});

			$node->setAttribute('role', $role);
			$node->setAttribute('permission', $permission);
			$parentNodes[$node->id] = $node->name;
			if (is_object($node->parent)) {
				$node->setAttribute('parent_name', $node->parent->name);
			}
			foreach ($routes as $rt) {
				if ($node->route != '' && $rt->getName() == $node->route) {
					$node->route = $rt->uri();
				}
			}
		}

		return view('menunodes::menu-node-content', compact('menuNodes', 'parentNodes'));
	}

	public function index() {
		return view('menunodes::index');
	}

	/**
	 * Show the form for creating a new resource.
	 * @return Response
	 */
	public function create() {
		return view('menunodes::create');
	}

	/**
	 * Store a newly created resource in storage.
	 * @param  Request $request
	 * @return Response
	 */
	public function store(Request $request) {

		@$last_seq = MenuNode::orderBy('menu_pos','desc')->first()->menu_pos+1;
		if (!$last_seq)
			$last_seq=1;
		$menu_id = 'menu_id::'.$request->menuId;
		$menu_name = 'name::'.$request->name;
		$validatedData = $request->validate([
			'name' => 'required|unique_multiple:menu_nodes,'.$menu_id.',deleted_at::NULL,'.$menu_name.'|max:255',
		]);
		$menu = new MenuNode();
		$menu->name = $request->name;
		if ($request->route['value'])
			$menu->route = $request->route['value'];
		$menu->menu_id = $request->menuId;
		if ($request->menu_icon)
			$menu->menu_icon = $request->menu_icon;
		$menu->menu_pos = $last_seq;
		$menu->save();

		if ($request->parent_name['value']) {
			$menu1 = MenuNode::find($menu->id);
			$parent = MenuNode::find($request->parent_name['value']);
			$menu1->makeChildOf($parent);
			$menu1->save();
		}

		return 'menuNodeSearch';
	}

	/**
	 * Show the specified resource.
	 * @return Response
	 */
	public function show() {
		return view('menunodes::show');
	}

	/**
	 * Show the form for editing the specified resource.
	 * @return Response
	 */
	public function edit() {
		return view('menunodes::edit');
	}

	/**
	 * Update the specified resource in storage.
	 * @param  Request $request
	 * @return Response
	 */
	public function update(Request $request) {
		$params = 'menu_id::'.$request->menuId;
		$validatedData = $request->validate([
			'name' => 'required|max:255',
		]);
		$menu = MenuNode::find($request->id);
		$menu->name = $request->name;
		if ($request->menu_icon)
			$menu->menu_icon = $request->menu_icon;
		if ($request->route) {
			if (is_array($request->route))
				$menu->route = $request->route['value'];
			else {
				$routes = app()->routes->getRoutes();
				foreach ($routes as $rt) {
					if ($rt->uri() == $request->route) {
						$menu->route = $rt->getName();
					}
				}
			}
		}
		else
			$menu->route = '';
		$menu->menu_id = $request->menuId;
		if ($request->parent_name) {
			if (is_array($request->parent_name)) {
				$parent = MenuNode::find($request->parent_name['value']);
				$menu->makeChildOf($parent);
			}
		}
		else
			$menu->parent_id = null;
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
		return 'menuNodeSearch';
	}

	/**
	 * Remove the specified resource from storage.
	 * @return Response
	 */
	public function destroy(Request $request) {
		$menu = MenuNode::find($request->id)->delete();

		return 'menuNodeSearch';
	}
}
