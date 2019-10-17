<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Artisan;
use Session;
use Auth;

class IndexController extends Controller
{
    public function index()
    {
        return view('index.index');
    }

    public function about()
    {
        return view('index.about');
    }

    public function contact()
    {
        return view('index.contact');
    }

    public function demo()
    {
        if(Auth::check()) {
            return redirect('/dashboard');
        } else {
            return view('index.demo');
        }
    }

    public function sendMessageFromSite(Request $request)
    {
        $message_success = 'We have <strong>successfully</strong> received your Message and will get Back to you as soon as possible.';
        return '{ "alert": "success", "message": "' . $message_success . '" }';
        // return redirect()->route('index');
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
        return 'Config and Route Cached. All Cache Cleared<br/>
        <a href="http://www.highrankdirectory.com/education/special_education/">education</a>
        ';
    }
}
