<?php

namespace Hszope\LaravelAigeo\Http\Controllers;

use Illuminate\Routing\Controller;
use Hszope\LaravelAigeo\Modules\Feed\ProductFeedGenerator;

class ProductFeedController extends Controller
{
    public function index(ProductFeedGenerator $generator)
    {
        return response()->json($generator->generate());
    }
}
