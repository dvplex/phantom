<?php

namespace dvplex\Phantom\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class PhantomController extends Controller {

	public function index($lang,$timezone = NULL) {
		$current_time = ($timezone)
			? Carbon::now(str_replace('-', '/', $timezone))
			: Carbon::now();

		return view('phantom::time', compact('current_time'));
	}

	public function setLocale($loc) {
		return phantom_route($loc);

	}

}

