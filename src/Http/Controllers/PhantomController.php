<?php
namespace dvplex\Phantom\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;

class PhantomController extends Controller
{

    public function index($timezone)
    {
        echo Carbon::now($timezone)->toDateTimeString();
    }

}

