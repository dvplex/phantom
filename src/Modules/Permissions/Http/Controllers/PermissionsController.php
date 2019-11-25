<?php

namespace dvplex\Phantom\Modules\Permissions\Http\Controllers;

use dvplex\Phantom\Models\Permission;
use dvplex\Phantom\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class PermissionsController extends Controller {
	public function search(Request $request) {
		$permissions = Permission::with('roles')
			->searchInit($request, 'permissionSearch')
			->searchFields(['guard_name', 'name'])
			->orderByFields(['guard_name', 'name'])
			->search(5);

		foreach ($permissions as $permission) {
			$role= $permission->roles()->get()->map(function ($item) {
				return ['value' => $item['id'], 'label' => $item['name']];
			});
			$permission->setAttribute('role', $role);
		}
		return view('permissions::permission-content', compact('permissions'));
	}

	/**
	 * Display a listing of the resource.
	 * @return Response
	 */
	public function index() {
	}

	/**
	 * Show the form for creating a new resource.
	 * @return Response
	 */
	public function create() {
		return view('permissions::create');
	}

	/**
	 * Store a newly created resource in storage.
	 * @param  Request $request
	 * @return Response
	 */
	public function store(Request $request) {
		$validatedData = $request->validate([
			'name' => 'required|unique:permissions|max:255',
		]);
		$permission = new Permission();
		$permission->name = $request->name;
		$permission->guard_name = 'web';
		$permission->save();
		if ($request->role) {
			foreach ($request->role as $role) {
				$permission->assignRole($role['label']);
			}
		}

		return 'permissionSearch';
	}

	/**
	 * Show the specified resource.
	 * @return Response
	 */
	public function show() {
		return view('permissions::show');
	}

	/**
	 * Show the form for editing the specified resource.
	 * @return Response
	 */
	public function edit() {
		return view('permissions::edit');
	}

	/**
	 * Update the specified resource in storage.
	 * @param  Request $request
	 * @return Response
	 */
	public function update(Request $request) {
		$validatedData = $request->validate([
			'name' => 'required|unique:permissions,name,' . $request->id . '|max:255',
		]);
		$permission = Permission::find($request->id);
		$permission->name = $request->name;
		$permission->save();
		$permission->syncRoles();
		if ($request->role) {
			foreach ($request->role as $role) {
				$permission->assignRole($role['label']);
			}
		}

		return 'permissionSearch';
	}

	/**
	 * Remove the specified resource from storage.
	 * @return Response
	 */
	public function destroy() {
	}
}
