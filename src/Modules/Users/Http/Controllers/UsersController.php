<?php

namespace dvplex\Phantom\Modules\Users\Http\Controllers;

use dvplex\Phantom\Models\Permission;
use dvplex\Phantom\Models\Role;
use dvplex\Phantom\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class UsersController extends Controller {
	/**
	 * Display a listing of the resource.
	 * @return Response
	 */

	public function search(Request $request) {
		$users = User::with('roles', 'permissions')
			->searchInit($request, 'usersSearch')
			->searchFields(['username', 'name','email'])
			->orderByFields(['username', 'name','email'])
			->search(5);

		foreach ($users as $user) {
			$role = $user->roles()->get()->map(function ($item) {
				return ['value' => $item['id'], 'label' => $item['name']];
			});

			$permission = $user->permissions()->get()->map(function ($item) {
				return ['value' => $item['id'], 'label' => $item['name']];
			});
			$user->setAttribute('role', $role);
			$user->setAttribute('permission', $permission);
		}

		return view('users::users-content', compact('users'));
	}

	public function index() {
		$permissions = Permission::all()->map(function ($item) {
			return ['value' => $item['id'], 'label' => $item['name']];
		})->toArray();

		$permissions = json_encode($permissions);

		$roles = Role::all()->map(function ($item) {
			return ['value' => $item['id'], 'label' => $item['name']];
		})->toArray();
		$roles = json_encode($roles);

		return view('users::index', compact('permissions', 'roles'));
	}

	/**
	 * Show the form for creating a new resource.
	 * @return Response
	 */
	public function create() {
		return view('users::create');
	}

	/**
	 * Store a newly created resource in storage.
	 * @param  Request $request
	 * @return Response
	 */
	public function store(Request $request) {
		$validatedData = $request->validate([
			'username' => 'unique:users|max:255|without_spaces',
			'name'     => 'min:4',
			'password' => 'required|min:6|confirmed',
			'email'    => 'required|email',
		]);
		$users = new User();
		$users->name = $request->get('name');
		$users->username = $request->get('username');
		$users->email = $request->get('email');
		if ($request->get('password'))
			$users->password = bcrypt($request->get('password'));

		if ($request->userAvatarData) {
			preg_match('#data:image/(.*?);base64#', $request->userAvatarData, $m);
			$path = public_path() . '/images/avatar/';
			$name = $request->username . '.' . $m[1];
			preg_match('#base64,(.*?)$#', $request->userAvatarData, $m);
			$image = base64_decode($m[1]);
			file_put_contents($path . $name, $image);
			$users->user_avatar = $name;
		}

		$users->save();

		if ($request->permission) {
			foreach ($request->permission as $pm)
				$users->givePermissionTo($pm['label']);
		}
		if ($request->role) {
			foreach ($request->role as $pm)
				$users->assignRole($pm['label']);
		}

		return 'usersSearch';
	}

	/**
	 * Show the specified resource.
	 * @return Response
	 */
	public function show() {
		return view('users::show');
	}

	/**
	 * Show the form for editing the specified resource.
	 * @return Response
	 */
	public function edit() {
		return view('users::edit');
	}

	/**
	 * Update the specified resource in storage.
	 * @param  Request $request
	 * @return Response
	 */
	public function update(Request $request) {
	    $idField = config('phantom.user_primary_key');
		$validatedData = $request->validate([
			'username' => 'unique:users,username,' . $request->$idField . '|max:191|without_spaces',
			'name'     => 'min:4',
			'password' => 'min:6|confirmed',
			'email'    => 'required|email',
		]);
		$users = User::find($request->$idField);
		$users->username = $request->get('username');
		$users->name = $request->get('name');
		$users->email = $request->get('email');
		if ($request->get('password'))
			$users->password = bcrypt($request->get('password'));

		if ($request->userAvatarData) {
			preg_match('#data:image/(.*?);base64#', $request->userAvatarData, $m);
			$path = public_path() . '/images/avatar/';
			$name = $request->username . '.' . $m[1];
			preg_match('#base64,(.*?)$#', $request->userAvatarData, $m);
			$image = base64_decode($m[1]);
			file_put_contents($path . $name, $image);
			$users->user_avatar = $name;
		}

		$users->save();
		$users->syncPermissions();
		if ($request->permission) {
			foreach ($request->permission as $pm)
				$users->givePermissionTo($pm['label']);
		}
		$users->syncRoles();
		if ($request->role) {
			foreach ($request->role as $pm)
				$users->assignRole($pm['label']);
		}

		return 'usersSearch';
	}

	/**
	 * Remove the specified resource from storage.
	 * @return Response
	 */
    public function destroy(Request $request) {
        User::find($request->id)->delete();

        return 'usersSearch';
    }
}
