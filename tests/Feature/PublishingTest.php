<?php

use Hszope\LaravelAigeo\GeoServiceProvider;
use Hszope\LaravelAigeo\Tests\TestCase;
use Illuminate\Support\ServiceProvider as LaravelServiceProvider;

uses(TestCase::class);

beforeEach(function () {
    @unlink(config_path('geo.php'));

    foreach (glob(database_path('migrations/*_create_geo_settings_table.php')) ?: [] as $migration) {
        @unlink($migration);
    }
});

it('registers the documented config publish tag', function () {
    $paths = LaravelServiceProvider::pathsToPublish(GeoServiceProvider::class, 'laravel-aigeo-config');
    $source = firstSourceMatching($paths, '/config/geo.php');

    expect($paths)->not->toBeEmpty()
        ->and($paths[$source] ?? null)->toBe(config_path('geo.php'));
});

it('registers the documented migrations publish tag', function () {
    $paths = LaravelServiceProvider::pathsToPublish(GeoServiceProvider::class, 'laravel-aigeo-migrations');
    $source = firstSourceMatching($paths, '/database/migrations/create_geo_settings_table.php.stub');

    expect($paths)->not->toBeEmpty()
        ->and($paths)->toHaveKey($source)
        ->and(str_ends_with($paths[$source], '_create_geo_settings_table.php'))->toBeTrue();
});

it('publishes the config file with the documented tag', function () {
    $this->artisan('vendor:publish', [
        '--tag' => 'laravel-aigeo-config',
        '--force' => true,
    ])->assertExitCode(0);

    expect(config_path('geo.php'))->toBeFile();
});

it('publishes the migration file with the documented tag', function () {
    $this->artisan('vendor:publish', [
        '--tag' => 'laravel-aigeo-migrations',
        '--force' => true,
    ])->assertExitCode(0);

    expect(glob(database_path('migrations/*_create_geo_settings_table.php')) ?: [])->not->toBeEmpty();
});

function firstSourceMatching(array $paths, string $suffix): string
{
    foreach (array_keys($paths) as $source) {
        if (str_ends_with($source, $suffix)) {
            return $source;
        }
    }

    return '';
}
