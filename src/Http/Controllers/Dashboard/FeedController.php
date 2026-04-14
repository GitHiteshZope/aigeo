<?php

namespace Hszope\LaravelAigeo\Http\Controllers\Dashboard;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Artisan;

class FeedController extends Controller
{
    public function index()
    {
        return view('geo::dashboard.feed');
    }

    public function regenerate()
    {
        Artisan::call('geo:feed');
        return back()->with('success', 'AI Feed cache cleared.');
    }
}
