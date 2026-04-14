<?php

namespace Hszope\LaravelAigeo\Tests;

use Hszope\LaravelAigeo\GeoServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app)
    {
        return [
            GeoServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');
        
        $migration = include __DIR__ . '/../database/migrations/create_geo_settings_table.php.stub';
        $migration->up();
    }
}
