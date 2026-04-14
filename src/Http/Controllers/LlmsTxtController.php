<?php

namespace Hszope\LaravelAigeo\Http\Controllers;

use Illuminate\Routing\Controller;
use Hszope\LaravelAigeo\Modules\LlmsTxt\LlmsTxtGenerator;

class LlmsTxtController extends Controller
{
    public function index(LlmsTxtGenerator $generator)
    {
        return response($generator->generate(false))
            ->header('Content-Type', 'text/plain; charset=UTF-8');
    }

    public function full(LlmsTxtGenerator $generator)
    {
        return response($generator->generate(true))
            ->header('Content-Type', 'text/plain; charset=UTF-8');
    }
}
