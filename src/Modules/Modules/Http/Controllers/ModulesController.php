<?php

namespace dvplex\Phantom\Modules\Modules\Http\Controllers;

use dvplex\Phantom\Facades\Phantom;
use dvplex\Phantom\Models\Permission;
use dvplex\Phantom\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Routing\Router;
use dvplex\Phantom\Modules\Modules\Entities\Module;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use dvplex\Phantom\Modules\Modules\Entities\Preference;

class ModulesController extends Controller {
	/**
	 * Display a listing of the resource.
	 * @return Response
	 */
	public function search(Request $request) {
		$modules = Module::
		searchInit($request, 'moduleSearch')
			->searchFields(['module_description', 'module_name'])
			->orderByFields(['module_description', 'module_name'])
			->search(5);

		return view('modules::module-content', compact('modules'));
	}

	public function index(Request $request) {
		return view('modules::index');
	}

	/**
	 * Show the form for creating a new resource.
	 * @return Response
	 */
	public function create($view) {
		return view('modules::' . $view);
	}

	/**
	 * Store a newly created resource in storage.
	 * @param  Request $request
	 * @return Response
	 */
	public function store(Request $request) {
		$validatedData = $request->validate([
			'module_name'        => 'required|unique:modules|max:255|without_spaces',
			'module_description' => 'required|min:2',
		]);
		Phantom::module_add($request);

		return 'moduleSearch';


	}

	/**
	 * Show the specified resource.
	 * @return Response
	 */
	public function show(Router $router, $lang, $module_id) {
		$middleware = [];
		$rg = $router->getMiddlewareGroups();
		$n = 0;
		foreach ($rg as $k => $v) {
			$middleware[$n]['label'] = $k;
			$middleware[$n]['value'] = $k;
			$n++;
		}
		$rg = $router->getMiddleware();
		foreach ($rg as $k => $v) {
			if ($k == 'role' || $k == 'permission')
				continue;
			$middleware[$n]['label'] = $k;
			$middleware[$n]['value'] = $k;
			$n++;
		}
		$module= Module::findOrFail($module_id);
		$middlewares = json_encode($middleware);
		$method = json_encode([['label'=>'get','value'=>'get'],['label'=>'post','value'=>'post'],['label'=>'patch','value'=>'patch'],['label'=>'delete','value'=>'delete'],['label'=>'put','value'=>'put'],]);


		$permissions = Permission::all()->map(function ($item) {
			return ['value' => $item['id'], 'label' => $item['name']];
		})->toArray();

		$permissions = json_encode($permissions);

		$roles = Role::all()->map(function ($item) {
			return ['value' => $item['id'], 'label' => $item['name']];
		})->toArray();
		$roles = json_encode($roles);


		return view('modules::show', compact('module', 'middlewares', 'method', 'roles', 'permissions'));
	}

	/**
	 * Show the form for editing the specified resource.
	 * @return Response
	 */
	public function edit() {
		return view('modules::edit');
	}

	/**
	 * Update the specified resource in storage.
	 * @param  Request $request
	 * @return Response
	 */
	public function update(Request $request) {

		$validatedData = $request->validate([
			'module_name'        => 'required|unique:modules,module_name,' . $request->id . '|max:255|without_spaces',
			'module_description' => 'required|min:2',
		]);
		Phantom::module_edit($request);

		return 'moduleSearch';
	}

	/**
	 * Remove the specified resource from storage.
	 * @return Response
	 */
	public function destroy() {
	}

	public function vue_trans() {
		$lang = \Session::get('locale');
		app()->setLocale($lang);

		return trans('alerts');
	}
    public function settings() {
        return view('modules::settings');
    }

    public function s_general() {
        $user = Auth::id();
        $prefs = Preference::where('user_id',$user)->get();
        $gsettings=[];
        foreach ($prefs as $pref) {
            if ($pref->value=='on')
                $gsettings[$pref->prop] = 'checked="checked"';
            elseif ($pref->value=='off')
                $gsettings[$pref->prop] = '';

        }
        return view('modules::s-general',compact('gsettings'));
    }

    public function save_prefs(Request $request) {
        $user = Auth::id();
        $keys = '';
        DB::beginTransaction();
        foreach ($request->all() as $key => $val) {
            $pref = Preference::where('user_id', $user)->where('prop',$key)->first();
            if (empty($pref)) {
                $pref = new Preference();
                $pref->prop = $key;
            }
            $pref->value = $val;
            $pref->user_id= $user;
            $pref->save();
            $keys != '' && $keys.=',';
            $keys.="'".$key."'";
        }
        if ($keys) {
            $prefs = Preference::whereRaw("prop not in ({$keys})")->get();
            foreach ($prefs as $pref) {
                $pref->value='off';
                $pref->save();
            }
        }
        else {
            $prefs = Preference::all();
            foreach ($prefs as $pref) {
                $pref->value='off';
                $pref->save();
            }
        }

        DB::commit();
        phantom_prefs();
        return;
    }
}
