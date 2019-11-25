<?php

namespace dvplex\Phantom\Modules\Roles\Http\Controllers;


use dvplex\Phantom\Models\Role;
use dvplex\Phantom\Models\Permission;
use function foo\func;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class RolesController extends Controller {
	public function search(Request $request) {
		$roles = Role::with('permissions')
			->searchInit($request, 'roleSearch')
			->searchFields(['guard_name', 'name'])
			->orderByFields(['guard_name', 'name'])
			->search(5);
		foreach ($roles as $role) {
			$permission = $role->permissions()->get()->map(function ($item) {
				return ['value' => $item['id'], 'label' => $item['name']];
			});
			$role->setAttribute('permission', $permission);
		}
		return view('roles::role-content', compact('roles'));
	}

	/**
	 * Display a listing of the resource.
	 * @return Response
	 */
	public function index() {
		$permissions = Permission::all()->map(function($item){
			return ['value' => $item['id'], 'label' => $item['name']];
		});
		$permissions = json_encode($permissions);

		$roles = Role::all()->map(function($item){
			return ['value' => $item['id'], 'label' => $item['name']];
		});
		$roles = json_encode($roles);
		return view('roles::index', compact('permissions','roles'));
	}

	/**
	 * Show the form for creating a new resource.
	 * @return Response
	 */
	public
	function create() {
		return view('roles::create');
	}

	/**
	 * Store a newly created resource in storage.
	 * @param  Request $request
	 * @return Response
	 */
	public
	function store(Request $request) {
		$validatedData = $request->validate([
			'name' => 'required|unique:roles|max:255',
		]);
		$role = new Role();
		$role->name = $request->name;
		$role->guard_name = 'web';
		$role->save();
		if ($request->permission) {
			foreach ($request->permission as $permission) {
				$role->givePermissionTo($permission['label']);

			}
		}

		return 'roleSearch';
	}

	/**
	 * Show the specified resource.
	 * @return Response
	 */
	public
	function show() {
		return view('roles::show');
	}

	/**
	 * Show the form for editing the specified resource.
	 * @return Response
	 */
	public
	function edit() {
		return view('roles::edit');
	}

	/**
	 * Update the specified resource in storage.
	 * @param  Request $request
	 * @return Response
	 */
	public
	function update(Request $request) {
		$validatedData = $request->validate([
			'name' => 'required|unique:roles,name,' . $request->id . '|max:255',
		]);
		$role = Role::find($request->id);
		$role->name = $request->name;
		$role->save();
		$role->syncPermissions();
		if ($request->permission) {
			foreach ($request->permission as $pm) {
				$role->givePermissionTo($pm['label']);
			}
		}


		return 'roleSearch';

	}

	/**
	 * Remove the specified resource from storage.
	 * @return Response
	 */
	public
	function destroy() {
	}
}
