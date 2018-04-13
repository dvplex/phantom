<?php

namespace dvplex\Phantom\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class PhantomController extends Controller {

	public function index($timezone = NULL) {
		$current_time = ($timezone)
			? Carbon::now(str_replace('-', '/', $timezone))
			: Carbon::now();

		return view('phantom::time', compact('current_time'));
	}

}

