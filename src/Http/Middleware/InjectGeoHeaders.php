<?php

namespace Hszope\LaravelAigeo\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class InjectGeoHeaders
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if (config('geo.llms_txt.enabled')) {
            $response->headers->set('X-LLMS-Txt', url(config('geo.llms_txt.route')));
        }

        return $response;
    }
}
