<?php

namespace dvplex\Phantom\Classes;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Nwidart\Modules\Facades\Module;
use Spatie\Menu\Laravel\Html;
use Spatie\Menu\Laravel\Link;
use Spatie\Menu\Laravel\Menu;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Artisan;
use Modules\Modules\Entities\Modules;

class Phantom {
	public static function bark() {
		echo 'Phantom is Barking!';
	}

	public static function phantom_route($loc) {

		\Session::put('loc', $loc);
		$str = url()->previous();
		$str = preg_replace('/\/[a-z]{2}\//', "/{$loc}/", $str, 1);

		return redirect($str);
	}

	public static function menu($type = false) {

		switch ($type) {
			case "side":
			default:
				$menu = Menu::new();
				$menu->addClass('site-menu');
				$menu->addItemClass('site-menu-item');
				$menu->setAttribute('data-plugin', 'menu');
				$menu->html('<li class="site-menu-category">' . Lang::get('menu.menu') . '</li>');
				$menu->html('
							<a href="/' . app()->getLocale() . '/admin">
							<i class="site-menu-icon wb-dashboard" aria-hidden="true"></i>
							<span class="site-menu-title">' . Lang::get('menu.Dashboard') . '</span>
							<div class="site-menu-badge">
								<span class="badge badge-pill badge-success">3</span>
							</div>
						</a>
				')->addItemParentClass('site-menu-item');

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
		//\Artisan::call('module:list');
		//return \Artisan::output();
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
				if (preg_match('/require\(\'laravel-mix\'\)/', $line))
					$line = $line . $webmix_newline;

				$nlines .= $line . "\n";
			}
			file_put_contents(base_path() . '/webpack.mix.js', $nlines);

			$r = file_get_contents(__DIR__ . '/../Stubs/webpack.mix.js.stub');
			$r = str_replace(['$MODULE_NAMESPACE$', '$STUDLY_NAME$'], [$nameSpace, $studlyName], $r);
			file_put_contents($path . '/webpack.mix.js', $r);

			return true;
		}
		$r = file_get_contents(__DIR__ . "/../Stubs/{$name}.stub");
		$r = str_replace(['$MODULE_NAMESPACE$', '$STUDLY_NAME$'], [$nameSpace, $studlyName], $r);
		file_put_contents($path . "/{$namePath}/{$name}", $r);


	}

	protected static function generateFiles($module_name) {
		$module = Module::find(camel_case($module_name));
		self::stubReplace($module, 'webpack.mix.js');
		self::stubReplace($module, 'head.blade.php', 'Resources/views/layouts');
		self::stubReplace($module, 'scripts.blade.php', 'Resources/views/layouts');
		$path = $module->getPath();
		mkdir($path . '/Resources/assets/css');
		mkdir($path . '/Resources/assets/js');
		file_put_contents($path . '/Resources/assets/css/style.css', '');
		file_put_contents($path . '/Resources/assets/js/index.js', '');
	}

	public static function module_add($request) {
		$module_name = preg_replace('/\s+/', '_', mb_ucfirst($request->module_name));
		Artisan::call('module:make', ['name' => [$module_name]]);
		self::generateFiles($module_name);
		$modules = new Modules();
		$modules->module_name = mb_ucfirst(camel_case($module_name));
		$modules->module_description = $request->get('module_description');
		$modules->save();
	}
}