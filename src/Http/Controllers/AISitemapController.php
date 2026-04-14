<?php

namespace Hszope\LaravelAigeo\Http\Controllers;

use Illuminate\Routing\Controller;
use Hszope\LaravelAigeo\Modules\Feed\AISitemapGenerator;

class AISitemapController extends Controller
{
    public function index(AISitemapGenerator $generator)
    {
        return response($generator->generate())
            ->header('Content-Type', 'application/xml; charset=UTF-8');
    }
}
