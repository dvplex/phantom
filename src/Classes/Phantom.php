<?php

namespace dvplex\Phantom\Classes;

use Illuminate\Support\Collection;
use Spatie\Menu\Laravel\Html;
use Spatie\Menu\Laravel\Link;
use Spatie\Menu\Laravel\Menu;
use Illuminate\Support\Facades\Lang;

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

	public static function menu($id, $type = false, $model = false) {

		switch ($type) {
			case "side":
			default:
			Menu::macro($id, function () {
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
			});
			break;
			case "settings":
				break;
		}
	}

	public static function list_modules() {
		foreach (app('modules')->all() as $module) {
			echo $module->getName().' '.$module->enabled(). ' '.$module->getPath().'<br>';
		}
		//\Artisan::call('module:list');
		//return \Artisan::output();
	}
}