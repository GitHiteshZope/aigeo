<?php

namespace Hszope\LaravelAigeo\Facades;

use Illuminate\Support\Facades\Facade;

class Geo extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'geo.schema';
    }

    public static function schema()
    {
        return app('geo.schema');
    }

    public static function scorer()
    {
        return app('geo.scorer');
    }

    public static function citation()
    {
        return app('geo.citation');
    }
}
