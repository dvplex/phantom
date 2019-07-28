<?php

namespace dvplex\Phantom\Classes;

use dvplex\Phantom\Http\Middleware\PhantomLocaleMiddleware;
use dvplex\Phantom\Http\Middleware\PhantomAuthBasicOnceMiddleware;
use function foo\func;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Routing\Router;
use Illuminate\Support\Collection;
use dvplex\Phantom\Http\Middleware\PhantomMiddleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Modules\Admin\Entities\Preference;
use Modules\MenuNodes\Entities\MenuNode;
use Nwidart\Modules\Facades\Module;
use Illuminate\Foundation\AliasLoader;
use Spatie\Menu\Laravel\Html;
use Spatie\Menu\Laravel\Link;
use Illuminate\Support\Facades\Event;
use Spatie\Menu\Laravel\Menu;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Artisan;
use Modules\Modules\Entities\Module as Modules;
use Modules\Routes\Entities\Route as Routes;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Middlewares\PermissionMiddleware;
use Spatie\Permission\Middlewares\RoleMiddleware;
use Spatie\Permission\Middlewares\RoleOrPermissionMiddleware;

class Phantom {

	public static function bark() {
		echo 'Phantom is Barking!';

		return;
	}

	public static function get_fa_icons($select = false) {
		if (session('phantom.fa_icons'))
			return session('phantom.fa_icons');
		$content = @file_get_contents('https://gist.githubusercontent.com/anthonykozak/5bc706dc5128c337bc73f587e187102d/raw/86ae5eea6a09c98fbb5da61ad867c0d0224b0951/FontAwesome%25205%2520Free%2520JSON%2520Cheatsheet');
		$json = @json_decode($content);
		$icons = [];

		$n = 0;
		foreach ($json as $icon => $value) {
			if (!$select)
				$icons[] = $icon;
			else {
				$icons[$n]['title'] = $value;
				$icons[$n]['icon'] = $icon;
				$n++;
			}
		}
		session(['phantom.fa_icons' => $icons]);

		return $icons;
	}

	public function phantom_view($view, $data) {
		$v = [];
		$view = \View::make($view, $data);
		return $view->render();
	}

	public function phantom_search($id, $action) {
		$content = '
			<phantom-search
					id="' . $id . '"
					action="' . $action . '"
					current-page="' . session("search.{$id}.page") . '"
					per-page="' . session("search.{$id}.perPage") . '"
					search-id="' . session("search.{$id}.query") . '"
					order-by-fields="' . htmlspecialchars(json_encode(session("search.{$id}.orderFields"))) . '"
					order-by-id="' . session("search.{$id}.order.name") . '"
					order-by-dir="' . session("search.{$id}.order.dir") . '">
					' . csrf_field() . '
			</phantom-search>
		';

		return $content;
	}

	public function phantom_link($path, $args = []) {
		$args['lang'] = app()->getLocale();

		return route('phantom.modules.' . $path, $args);
	}

	public function eventsListen() {
		Event::listen('phantom.*', function ($eventName, $data) {
			$eventName = preg_replace('/phantom\./', '', $eventName);
			$method = new \ReflectionMethod(Phantom::class, $eventName);

			return $method->invokeArgs(NULL, $data);

		});
	}

	public function phantom_event_fire($event, $args = false) {
		Event::dispatch('phantom.' . $event, $args);
	}


	public function registerAliases() {
		$loader = AliasLoader::getInstance();
		$loader->alias('Phantom', Phantom::class);
		$loader->alias('PhantomEvent', PhantomEvent::class);

		return;
	}

	public function registerConfig() {
		$r = phantom_get_routes();
		config(['phantom.routes' => $r]);
		config(['app.locales' => ['en', 'bg']]);
		// override User model :-)
		config(['auth.providers.users.model' => \dvplex\Phantom\Models\User::class]);
		config(['permission.models.role' => \dvplex\Phantom\Models\Role::class]);
		config(['permission.models.permission' => \dvplex\Phantom\Models\Permission::class]);
		config(['phantom.modules.main' => 'admin']);
		Paginator::defaultView('layouts.paginate');

		return;
	}

	public function registerRoutes($data = false) {
		$router = app()->make('router');
		$router->pushMiddlewareToGroup('web', PhantomLocaleMiddleware::class);

		$router->aliasMiddleware('phantom_auth_basic_once', PhantomAuthBasicOnceMiddleware::class);
		$router->aliasMiddleware('role', RoleMiddleware::class);
		$router->aliasMiddleware('permission', PermissionMiddleware::class);
		$router->aliasMiddleware('role_or_permission', RoleOrPermissionMiddleware::class);
		if (!class_exists('Modules\Routes\Entities\Route') || !Schema::hasTable('routes'))
			return;
		if (!config('phantom.regroutes')) {
			if (in_array('Spatie\Permission\Traits\HasRoles', class_uses(Routes::class)))
				$routes = Routes::with('http_methods', 'module', 'middlewares', 'roles', 'permissions')->get();
			else
				$routes = Routes::with('http_methods', 'module', 'middlewares')->get();
			config(['phantom.regroutes' => serialize($routes)]);
		}
		else
			$routes = unserialize(config('phantom.regroutes'));
		if (count($routes)) {
			foreach ($routes as $route) {
				$middleware = $route->middlewares->pluck('name')->toArray();
				if (isset($route->roles) && count($route->roles)) {
					$roles = $route->roles->implode('name', '|');
					array_push($middleware, 'role:' . $roles);
				}
				if (isset($route->permissions) && count($route->permissions)) {
					$permissions = $route->permissions->implode('name', '|');
					array_push($middleware, 'permission:' . $permissions);
				}
				$module_name = $route->module->module_name;
				$router->group(['middleware' => $middleware, 'namespace' => '\\Modules\\' . $module_name . '\\Http\\Controllers'], function ($router) use ($route, $module_name) {
					$path = $route->route;
					foreach ($route->http_methods as $http_method) {
						$requestMethod = $http_method->name;
						$controllerMethod = $route->controllerMethod;
						$router->$requestMethod($path, $module_name . 'Controller@' . $controllerMethod)->name(mb_strtolower('phantom.modules.' . $module_name . '@' . $controllerMethod));
					}
				});
			}
		}

		return;
	}

	public function phantom_module_path($module) {
		return join("<br>", config('phantom.routes.modules.' . strtolower($module . '.path')));
	}

	public function phantom_get_routes() {

		$routes = $rn = [];
		$collection = Route::getRoutes();
		foreach ($collection as $route) {
			if ($route->named('phantom.*')) {
				$name = explode('@', preg_replace('/phantom\./', '', $route->getName()));
				$name = $name[0];
				if ($route->named('phantom.modules.*')) {
					$name = preg_replace('/modules\./', '', $name);
					$routes['modules'][$name]['methods'][$route->getActionMethod()]['path'] = $route->uri();
					foreach ($route->methods as $rm) {
						$routes['modules'][$name]['methods'][$route->getActionMethod()]['requests'][$rm]['action'] = $route->getAction();
					}
				}
				else {
					$routes[$name]['path'][] = $route->uri();
					$routes[$name]['methods'] = $route->methods();
					$routes[$name]['action'] = $route->getAction();
					$routes[$name]['action']['controllerMethod'] = $route->getActionMethod();

				}
			}
		}

		return $routes;
	}

	public function phantom_route($loc) {
		\Session::put('locale', $loc);
		$str = url()->previous();
		$str = preg_replace('/\/[a-z]{2}\//', "/{$loc}/", $str, 1);

		return redirect($str);
	}

	public static function phantom_prefs($user = false) {
		if (!$user)
			$user = \Auth::id();
		else
			$user = $user->id;
		$pref = Preference::where('user_id', $user)->pluck('value', 'prop')->toArray();
		foreach ($pref as $k => $v)
			session()->put('phantom.preferences.' . $k, $v);

		return;
	}

	protected static function renderNode($node, $type = false) {
		$ct = '';
		switch ($type) {
			case 'reorder':
				if ($node->children()->count() > 0) {
					$ct .= '<li class="dd-item" data-id="' . $node->id . '" data-name="' . $node->name . '">';
					$ct .= '<button class="dd-collapse" data-action="collapse" type="button">Collapse</button>
					<button class="dd-expand" data-action="expand" type="button">Expand</button>
					<span class="dd-handle"><i class="site-menu-icon ' . $node->menu_icon . '" aria-hidden="true"></i>' . Lang::get('menu.' . $node->name) . '</span>';
				}
				else {
					if ($node->id != null) {
						$ct .= '<li class="dd-item" data-id="' . $node->id . '" data-name="' . $node->name . '">';
						$ct .= '<span class="dd-handle"><i class="site-menu-icon ' . $node->menu_icon . '" aria-hidden="true"></i>' . Lang::get('menu.' . $node->name) . '</span>';
					}
				}

				if ($node->children()->count() > 0) {
					$ct .= '<ul class="dd-list">';
					foreach ($node->children as $child)
						$ct .= self::renderNode($child, 'reorder');
					$ct .= "</ul>";
				}

				$ct .= "</li>";

				return $ct;
				break;
			case 'side':
			default:
				if ($node->children()->count() > 0) {
					$ct .= '<li class="site-menu-item has-sub"><a class="animsition-link" href="javascript:void(0)">';
					$ct .= '<i class="site-menu-icon ' . $node->menu_icon . '" aria-hidden="true"></i>';
					$ct .= '<span class="site-menu-title">' . Lang::get('menu.' . $node->name) . '</span>
							<span class="site-menu-arrow"></span>
						</a>';
				}
				else {
					if ($node->route != null) {
						$ct .= '<li class="site-menu-item "><a class="animsition-link" href="' . route($node->route, ['lang' => app()->getLocale()]) . '">';
						$ct .= '<i class="site-menu-icon ' . $node->menu_icon . '" aria-hidden="true"></i>';
						$ct .= '<span class="site-menu-title">' . Lang::get('menu.' . $node->name) . '</span>
                            </a>';
					}
				}

				if ($node->children()->count() > 0) {
					$ct .= '<ul class="site-menu-sub">';
					foreach ($node->children as $child)
						$ct .= self::renderNode($child);
					$ct .= "</ul>";
				}

				$ct .= "</li>";

				return $ct;
				break;
		}
	}

	public function menu($type = false, $name = false) {
		if (\Auth::check()) {
			$roles = \Auth::user()->roles->pluck('name')->toArray();
			$pms = \Auth::user()->permissions->pluck('name')->toArray();
			$nrs = \Auth::user()->roles()->with('permissions')->get();
			foreach ($nrs as $nr)
				$nrpms = $nr->permissions->pluck('name')->toArray();
			$pms = \Auth::user()->permissions->pluck('name')->toArray();
			if ($pms && $nrpms)
				$pms = array_merge($nrpms, $pms);
		}
		switch ($type) {
			case "reorder":
				$content = '';
				$menus = \Modules\Menus\Entities\Menu::with('roles', 'permissions');
				if ($name)
					$menus->where('name', $name);
				$menus = $menus->first();
				if ($menus == null)
					return;
				$nodes = $menus->nodes()->with('roles', 'permissions')->orderBy('menu_pos', 'asc')->get();
				$menu = Menu::new();
				$menu->addClass('dd-list');
				$menu->addItemClass('dd-item');
				foreach ($nodes as $node)
					if ($node->parent_id == null && $node->id)
						$content .= self::renderNode($node, 'reorder');
				$menu->html($content);

				return $menu;
				break;
			case "side":
			default:
				$content = '';
				$menus = \Modules\Menus\Entities\Menu::with('nodes', 'roles', 'permissions');
				if ($name)
					$menus->where('name', $name);
				if (!empty($roles) || !empty($pms)) {
					$menus->whereHas('roles', function ($q) use ($roles) {
						$q->whereIn('name', $roles);
					})
						->orWhereHas('permissions', function ($q) use ($pms) {
							$q->whereIn('name', $pms);
						});
				}
				$menus = $menus->first();
				if ($menus == null)
					return;
				$nodes = $menus->nodes()->with('roles', 'permissions')->orderBy('menu_pos', 'asc')->get();
				$menu = Menu::new();
				$menu->addClass('site-menu');
				$menu->addItemClass('site-menu-item');
				$menu->setAttribute('data-plugin', 'menu');
				$menu->html('<li class="site-menu-category">' . Lang::get('menu.menu') . '</li>');
				foreach ($nodes as $node) {
					$nroles = $node->getRoleNames()->toArray();
					$npms = $node->permissions()->pluck('name')->toArray();
					if ($node->parent_id == null) {
						if (!empty($nroles) && !empty(array_diff($nroles, $roles)))
							continue;
						if (empty($nroles) && !empty($npms) && !empty(array_diff($npms, $pms)))
							continue;
						$content .= self::renderNode($node);
					}
				}
				$menu->html($content)->addItemParentClass('site-menu-item has-sub');

				return $menu;
				break;
			case "top":
				$content = '';
				$menus = \Modules\Menus\Entities\Menu::with('nodes', 'roles', 'permissions');
				if ($name)
					$menus->where('name', $name);
				if (!empty($roles) || !empty($pms)) {
					$menus->whereHas('roles', function ($q) use ($roles) {
						$q->whereIn('name', $roles);
					})
						->orWhereHas('permissions', function ($q) use ($pms) {
							$q->whereIn('name', $pms);
						});
				}
				$menus = $menus->first();
				if ($menus == null)
					return;
				$nodes = $menus->nodes()->with('roles', 'permissions')->orderBy('menu_pos', 'asc')->get();
				$menu = Menu::new();
				$menu->addClass('site-menu mega-addon');
				$menu->addItemClass('site-menu-item');
				$menu->setAttribute('data-plugin', 'menu');
				foreach ($nodes as $key => $node) {
					$nroles = $node->getRoleNames()->toArray();
					$npms = $node->permissions()->pluck('name')->toArray();
					if ($node->parent_id == null) {
						if (!empty($nroles) && !empty(array_diff($nroles, $roles)))
							continue;
						if (empty($nroles) && !empty($npms) && !empty(array_diff($npms, $pms)))
							continue;

						if ($key > 1 && $key % 6 == 0) {
							$content .= '</ul></li>';
							$content .= '<li class="mega-menu m-0">';
							$content .= '<ul class="site-menu mega-addon" data-plugin="menu">';
						}
						$content .= self::renderNode($node);
					}
				}
				$menu->html($content)->addItemParentClass('site-menu-item has-sub');

				return $menu;
				break;
			case "settings":
				break;
		}
	}

	public function list_modules() {
		foreach (app('modules')->all() as $module) {
			echo $module->getName() . ' ' . $module->enabled() . ' ' . $module->getPath() . '<br>';
		}
	}

	protected static function stubReplace($module, $name, $namePath = false, $module_path = false) {
		$path = $module->getPath();
		$lowerName = $module->getLowerName();
		$studlyName = $module->getStudlyName();
		$nameSpace = 'Modules';
		if ($name == 'webpack.mix.js') {
			$webmix_newline = "\nrequire('./{$nameSpace}/{$studlyName}/webpack.mix.js');";
			$wm = file_get_contents(base_path() . '/webpack.mix.js');
			$lines = explode("\n", $wm);
			$nlines = '';
			foreach ($lines as $line) {
				if (preg_match('/require\(\'laravel-mix\'\)/', $line)) {
					$line .= $webmix_newline;
				}
				$nlines != '' && $nlines .= "\n";
				$nlines .= $line;
			}
			file_put_contents(base_path() . '/webpack.mix.js', $nlines);

			$r = file_get_contents(__DIR__ . '/../Stubs/webpack.mix.js.stub');
			$r = str_replace(['$MODULE_NAMESPACE$', '$STUDLY_NAME$', '$LOWER_NAME$'], [$nameSpace, $studlyName, $lowerName], $r);
			file_put_contents($path . '/webpack.mix.js', $r);

			return true;
		}
		$r = file_get_contents(__DIR__ . "/../Stubs/{$name}.stub");
		if ($name == 'routes.php' && $module_path)
			$r = str_replace(['$MODULE_NAMESPACE$', '$STUDLY_NAME$', '$LOWER_NAME$', '$MODULE_PATH$'], [$nameSpace, $studlyName, $lowerName, $module_path], $r);
		else
			$r = str_replace(['$MODULE_NAMESPACE$', '$STUDLY_NAME$', '$LOWER_NAME$'], [$nameSpace, $studlyName, $lowerName], $r);
		file_put_contents($path . "/{$namePath}/{$name}", $r);


	}

	protected static function generateFiles($module_name, $module_path = false) {
		$module = Module::find(camel_case($module_name));
		self::stubReplace($module, 'webpack.mix.js');
		self::stubReplace($module, 'head.blade.php', 'Resources/views/layouts');
		self::stubReplace($module, 'scripts.blade.php', 'Resources/views/layouts');
		self::stubReplace($module, 'index.blade.php', 'Resources/views');
		self::stubReplace($module, 'routes.php', 'Http', $module_path);
		$path = $module->getPath();
		if (!is_dir($path . '/Resources/css'))
			mkdir($path . '/Resources/css');
		if (!is_dir($path . '/Resources/js'))
			mkdir($path . '/Resources/js');
		if (!is_dir($path . '/Resources/sass'))
			mkdir($path . '/Resources/sass');
		file_put_contents($path . '/Resources/css/style.css', '');
		file_put_contents($path . '/Resources/sass/app.scss', '');
		file_put_contents($path . '/Resources/js/index.js', '');
	}

	public function module_add($request) {
		$module_path = false;
		if (isset($request->module_path))
			$module_path = $request->module_path;
		if ($module_path && !preg_match('/\/$/', $module_path))
			$module_path = $module_path . '/';
		if ($module_path && preg_match('/^\//', $module_path))
			$module_path = preg_replace('/^\//', '', $module_path);
		$module_name = studly_case($request->module_name);
		$modules = new Modules();
		$modules->module_name = $module_name;
		$modules->module_description = $request->get('module_description');
		$modules->save();

		Artisan::call('module:make', ['name' => [$module_name]]);
		self::generateFiles($module_name, $module_path);
	}

	public function module_edit($request) {
		$module_name = studly_case($request->module_name);
		$modules = \Modules\Modules\Entities\Module::find($request->id);
		$modules->module_name = $module_name;
		$modules->module_description = $request->get('module_description');

		return $modules->save();
	}

	public function phantom_slovom($int, $currency = false) {
		if ($currency)
			$two = 'два';
		else
			$two = 'двe';
		$units = array('нула', 'един', $two, 'три', 'четири', 'пет', 'шест', 'седем', 'осем', 'девет');
		$teens = array('десет', 'единадесет', 'дванадесет', 'тринадесет', 'четиринадесет', 'петнадесет', 'шестнадесет', 'седемнадесет', 'осемнадесет', 'деветнадесет');
		$hundredth = array(1 => 'сто', 'двеста', 'триста', 'четиристотин', 'петстотин', 'шестстотин', 'седемстотин', 'осемстотин', 'деветстотин');
		$tens = array(2 => 'двадесет', 'тридесет', 'четиридесет', 'петдесет', 'шестдесет', 'седемдесет', 'осемдесет', 'деветдесет');
		$suffix = array('хиляди', 'милиона', 'милиарда', 'trillion', 'quadrillion');
		$flag = '';

		if (!preg_match('#^[\d.]+$#', $int)) {
			echo('Невалидни символи! Моля въведете числова стойност.');

			return;
		}

		if (strpos($int, '.') !== false) {
			$decimal = substr($int, strpos($int, '.') + 1);
			$int = substr($int, 0, strpos($int, '.'));
		}

		$int = ltrim($int, '0');

		if ($int == '') {
			$int = '0';
		}


		if ($negative = ($int < 0)) {
			$int = substr($int, 1);
		}

		if (strlen($int) > 18) {
			echo('Числото съдържа повече от 18 цифри!');

			return;
		}

		switch (strlen($int)) {

			case '1':
				$text = $units[$int];
				break;


			case '2':
				if ($int{0} == '1') {
					$text = $teens[$int{1}];

				}
				else if ($int{1} == '0') {
					$text = $tens[$int{0}];
					if ($flag == 3) $text = 'и ' . $text;
					$flag = 0;
				}
				else {
					$text = $tens[$int{0}] . ' и ' . $units[$int{1}];
				}
				break;


			case '3':
				if ($int % 100 == 0) {
					$text = $hundredth[$int{0}];
				}
				else {
					$int_tmp = substr($int, 1);
					if (substr($int, 1, 1) == 0)
						$add = 'и';
					else
						$add = '';
					$flag = 3;
					$text = $hundredth[$int{0}] . " $add " . self::Slovom(substr($int, 1));

				}
				break;


			default:
				$pieces = array();
				$suffixIndex = 0;

				$num = substr($int, -3);
				if ($num > 0) {
					$pieces[] = self::Slovom($num);
				}
				$int = substr($int, 0, -3);

				while (strlen($int) > 3) {
					$num = substr($int, -3);

					if ($num > 0) {
						$pieces[] = self::slovom($num) . ' ' . $suffix[$suffixIndex];
					}
					$int = substr($int, 0, -3);
					$suffixIndex++;
				}

				if (substr($int, -3) == 1) {
					$preff = '';
					$t = $suffix[$suffixIndex];
					if ($suffixIndex == 0 && $int == 1) $ending = 'а';
					else $preff = 'един ';
					$pieces[] = $preff . substr($t, 0, -2) . $ending;
				}
				else {
					$pieces[] = self::Slovom(substr($int, -3)) . ' ' . $suffix[$suffixIndex];
				}

				$pieces = array_reverse($pieces);

				if (count($pieces) > 1 AND strpos($pieces[count($pieces) - 1], ' и ') === false) {
					$pieces[] = $pieces[count($pieces) - 1];
					$pieces[count($pieces) - 2] = 'и';
				}

				$text = implode(' ', $pieces);

				if ($negative) {
					$text = 'минус ' . $text;
				}
				break;
		}

		if (!empty($decimal)) {
			$decimal = preg_replace('#[^0-9]#', '', $decimal);

			if ($currency)
				$text .= ' лева и ' . ltrim($decimal, '0') . ' стотинки';
			else
				$text .= ' точка ' . self::Slovom($decimal);

		}


		return $text;

	}

}