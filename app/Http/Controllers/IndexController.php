<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Artisan;
use Session;

class IndexController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    // clear configs, routes and serve
    public function clear()
    {
        // Artisan::call('route:cache');
        Artisan::call('optimize');
        Artisan::call('cache:clear');
        Artisan::call('view:clear');
        Artisan::call('key:generate');
        Artisan::call('config:cache');
        Session::flush();
        echo 'Config and Route Cached. All Cache Cleared';
    }
}
