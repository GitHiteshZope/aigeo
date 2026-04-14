<?php

namespace Hszope\LaravelAigeo;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Hszope\LaravelAigeo\Console\GenerateLlmsTxt;
use Hszope\LaravelAigeo\Console\AuditGeoScore;
use Hszope\LaravelAigeo\Console\GenerateProductFeed;
use Hszope\LaravelAigeo\View\Components\GeoHead;
use Hszope\LaravelAigeo\View\Directives\GeoDirectives;

class GeoServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-aigeo')
            ->hasConfigFile('geo')
            ->hasViews('geo')
            ->hasMigration('create_geo_settings_table')
            ->hasRoutes('geo')
            ->hasCommands([
                GenerateLlmsTxt::class,
                AuditGeoScore::class,
                GenerateProductFeed::class,
            ]);
    }

    public function packageBooted(): void
    {
        // Register Blade component
        $this->app['blade.compiler']->component('geo-head', GeoHead::class);

        // Register Blade directives
        if (class_exists(GeoDirectives::class)) {
            GeoDirectives::register($this->app['blade.compiler']);
        }

        // Register middleware alias
        $this->app['router']->aliasMiddleware('geo.headers', \Hszope\LaravelAigeo\Http\Middleware\InjectGeoHeaders::class);

        // Load dashboard routes if enabled
        if (config('geo.dashboard.enabled', true)) {
            $this->loadRoutesFrom(__DIR__ . '/../routes/dashboard.php');
        }
    }

    public function packageRegistered(): void
    {
        // Bind core services
        $this->app->singleton('geo.schema',   fn() => new Modules\Schema\SchemaBuilder());
        $this->app->singleton('geo.scorer',   fn() => new Modules\Analytics\GeoScorer());
        $this->app->singleton('geo.citation', fn() => new Modules\Citation\CitationEngine());
        $this->app->singleton('geo.llms',     fn() => new Modules\LlmsTxt\LlmsTxtGenerator());
        $this->app->singleton('geo.feed',     fn() => new Modules\Feed\ProductFeedGenerator());
    }
}
