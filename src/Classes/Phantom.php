<?php

namespace dvplex\Phantom\Classes;

use dvplex\Phantom\Http\Middleware\PhantomLocaleMiddleware;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use dvplex\Phantom\Http\Middleware\PhantomMiddleware;
use Illuminate\Support\Facades\Schema;
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

class Phantom {

	public static function bark() {
		echo 'Phantom is Barking!';
	}

	public static function phantomView($id, $view, $data) {
		$v = [];
		$view = \View::make($view, $data);
		$view = $view->render();
		$v['id'] = $id;
		$v['view'] = $view;

		return $v;
	}

	public static function generateSearch($id, $action) {
		$content = '
			<phantom-search
					id="' . $id . '"
					action="' . $action . '"
					current-page="' . session("search.{$id}.page") . '"
					search-id="' . session("search.{$id}.query") . '"
					order-by-fields="' . htmlspecialchars(json_encode(session("search.orderFields"))) . '"
					order-by-id="' . session("search.{$id}.order.name") . '"
					order-by-dir="' . session("search.{$id}.order.dir") . '">
					' . csrf_field() . '
			</phantom-search>
		';

		return $content;
	}

	public static function generateLink($path, $args = []) {
		$args['lang'] = app()->getLocale();

		return route('phantom.modules.' . $path, $args);
	}

	public static function eventsListen() {
		Event::listen('phantom.*', function ($eventName, $data) {
			$eventName = preg_replace('/phantom\./', '', $eventName);

			return Phantom::$eventName($data);
		});
	}

	public static function registerAliases() {
		$loader = AliasLoader::getInstance();
		$loader->alias('Phantom', Phantom::class);
		$loader->alias('PhantomEvent', PhantomEvent::class);

		return;
	}

	public static function registerConfig() {
		$r = phantom_get_routes();
		config(['phantom.routes' => $r]);
		config(['app.locales' => ['en', 'bg']]);
		// override User model :-)
		config(['auth.providers.users.model' => \dvplex\Phantom\Models\User::class]);
		config(['permission.models.role' => \dvplex\Phantom\Models\Role::class]);
		config(['phantom.modules.main' => 'admin']);
		Paginator::defaultView('layouts.paginate');

		return;
	}

	public static function registerRoutes($data = false) {
		$router = app()->make('router');
		$router->aliasMiddleware('phantom', PhantomMiddleware::class);
		$router->aliasMiddleware('phantom_locale', PhantomLocaleMiddleware::class);
		$router->aliasMiddleware('role', RoleMiddleware::class);
		$router->aliasMiddleware('permission', PermissionMiddleware::class);
		if (!class_exists('Modules\Routes\Entities\Route') || !Schema::hasTable('routes'))
			return;
		$routes = Routes::with('module', 'middlewares')->get();
		if ($routes) {
			foreach ($routes as $route) {
				$middleware = $route->middlewares->pluck('name')->toArray();
				$module_name = $route->module->module_name;
				$router->group(['middleware' => $middleware, 'namespace' => '\\Modules\\' . $module_name . '\\Http\\Controllers'], function ($router) use ($route) {
					$module_name = $route->module->module_name;
					$path = $route->route;
					$requestMethod = $route->httpMethod;
					$controllerMethod = $route->controllerMethod;
					$router->$requestMethod($path, $module_name . 'Controller@' . $controllerMethod)->name(mb_strtolower('phantom.modules.' . $module_name . '@' . $controllerMethod));
				});
			}
		}

		return;
	}

	public static function phantom_module_path($module) {
		return join("<br>", config('phantom.routes.modules.' . strtolower($module . '.path')));
	}

	public static function phantom_get_routes() {

		$routes = $rn = [];
		$collection = Route::getRoutes();
		foreach ($collection as $route) {
			if ($route->named('phantom.*')) {
				$name = explode('@', preg_replace('/phantom\./', '', $route->getName()));
				$name = $name[0];
				if ($route->named('phantom.modules.*')) {
					$name = preg_replace('/modules\./', '', $name);
					$routes['modules'][$name]['methods'][$route->getActionMethod()]['path'] = $route->uri();
					$routes['modules'][$name]['methods'][$route->getActionMethod()]['path'] = $route->uri();
					$routes['modules'][$name]['methods'][$route->getActionMethod()]['request'][] = $route->methods();
					$routes['modules'][$name]['methods'][$route->getActionMethod()]['action'][] = $route->getAction();
				}
				else {
					$routes[$name]['path'][] = $route->uri();
					$routes[$name]['methods'] = $route->methods();
					$routes[$name]['methods'] = $route->methods();
					$routes[$name]['action'] = $route->getAction();
					$routes[$name]['action']['controllerMethod'] = $route->getActionMethod();

				}
			}
		}

		return $routes;
	}

	public static function phantom_route($loc) {
		\Session::put('locale', $loc);
		$str = url()->previous();
		$str = preg_replace('/\/[a-z]{2}\//', "/{$loc}/", $str, 1);

		return redirect($str);
	}

	protected static function renderNode($node) {
		$ct = '';
		if ($node->children()->count() > 0) {
			$ct .= '<li class="site-menu-item has-sub"><a class="animsition-link" href="javascript:void(0)">';
			if ($node->depth == 0)
				$ct .= '<i class="site-menu-icon wb-dashboard" aria-hidden="true"></i>';
			$ct .= '<span class="site-menu-title">' . Lang::get('menu.' . $node->name) . '</span>
							<span class="site-menu-arrow"></span>
						</a>';
		}
		else {
			if ($node->route != null) {
				$ct .= '<li class="site-menu-item "><a class="animsition-link" href="' . route($node->route, ['lang' => app()->getLocale()]) . '">';
				if ($node->depth == 0)
					$ct .= '<i class="site-menu-icon wb-dashboard" aria-hidden="true"></i>';
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
	}

	public static function menu($type = false) {

		switch ($type) {
			case "side":
			default:
				$content = '';
				if (!$type)
					$menus = \Modules\Menus\Entities\Menu::with('nodes')->first();
				else
					$menus = \Modules\Menus\Entities\Menu::with('nodes')->where('name', $type)->first();
				if ($menus == null)
					return;
				$nodes = $menus->nodes()->get();
				$menu = Menu::new();
				$menu->addClass('site-menu');
				$menu->addItemClass('site-menu-item');
				$menu->setAttribute('data-plugin', 'menu');
				$menu->html('<li class="site-menu-category">' . Lang::get('menu.menu') . '</li>');
				foreach ($nodes as $node)
					if ($node->parent_id == null)
						$content .= self::renderNode($node);
				$menu->html($content)->addItemParentClass('site-menu-item has-sub');

				return $menu;
				break;
			case "settings":
				break;
		}
	}

	public static function list_modules() {
		foreach (app('modules')->all() as $module) {
			echo $module->getName() . ' ' . $module->enabled() . ' ' . $module->getPath() . '<br>';
		}
	}

	protected static function stubReplace($module, $name, $namePath = false) {
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
		$r = str_replace(['$MODULE_NAMESPACE$', '$STUDLY_NAME$', '$LOWER_NAME$'], [$nameSpace, $studlyName, $lowerName], $r);
		file_put_contents($path . "/{$namePath}/{$name}", $r);


	}

	protected static function generateFiles($module_name) {
		$module = Module::find(camel_case($module_name));
		self::stubReplace($module, 'webpack.mix.js');
		self::stubReplace($module, 'head.blade.php', 'Resources/views/layouts');
		self::stubReplace($module, 'scripts.blade.php', 'Resources/views/layouts');
		self::stubReplace($module, 'index.blade.php', 'Resources/views');
		self::stubReplace($module, 'routes.php', 'Http');
		$path = $module->getPath();
		if (!is_dir($path . '/Resources/assets/css'))
			mkdir($path . '/Resources/assets/css');
		if (!is_dir($path . '/Resources/assets/js'))
			mkdir($path . '/Resources/assets/js');
		if (!is_dir($path . '/Resources/assets/sass'))
			mkdir($path . '/Resources/assets/sass');
		file_put_contents($path . '/Resources/assets/css/style.css', '');
		file_put_contents($path . '/Resources/assets/sass/app.scss', '');
		file_put_contents($path . '/Resources/assets/js/index.js', '');
	}

	public static function module_add($request) {
		$module_name = studly_case($request->module_name);
		$modules = new Modules();
		$modules->module_name = $module_name;
		$modules->module_description = $request->get('module_description');
		$modules->save();
		Artisan::call('module:make', ['name' => [$module_name]]);
		self::generateFiles($module_name);
	}

	public static function module_edit($request) {
		$module_name = studly_case($request->module_name);
		$modules = \Modules\Modules\Entities\Module::find($request->id);
		$modules->module_name = $module_name;
		$modules->module_description = $request->get('module_description');

		return $modules->save();
	}
}