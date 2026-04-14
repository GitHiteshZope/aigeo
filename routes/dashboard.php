<?php

use Illuminate\Support\Facades\Route;
use Hszope\LaravelAigeo\Http\Controllers\Dashboard;

$prefix = config('geo.dashboard.path', '/geo');
$middleware = array_filter([
    'web',
    config('geo.dashboard.middleware', 'auth'),
]);

// If middleware is 'none', remove it from the array
if (config('geo.dashboard.middleware') === 'none') {
    $middleware = ['web'];
}

Route::prefix($prefix)
    ->middleware($middleware)
    ->name('geo.dashboard.')
    ->group(function () {
        Route::get('/',           [Dashboard\DashboardController::class, 'index'])->name('overview');
        Route::get('/models',     [Dashboard\ModelsController::class,    'index'])->name('models');
        Route::get('/models/{model}/{id}', [Dashboard\ModelsController::class, 'audit'])->name('audit');
        Route::get('/schema',     [Dashboard\SchemaController::class,    'index'])->name('schema');
        Route::post('/schema',    [Dashboard\SchemaController::class,    'update'])->name('schema.update');
        Route::get('/llms',       [Dashboard\LlmsController::class,      'index'])->name('llms');
        Route::post('/llms/regenerate', [Dashboard\LlmsController::class,'regenerate'])->name('llms.regenerate');
        Route::get('/feed',       [Dashboard\FeedController::class,      'index'])->name('feed');
        Route::post('/feed/regenerate', [Dashboard\FeedController::class,'regenerate'])->name('feed.regenerate');
        Route::get('/settings',   [Dashboard\SettingsController::class,  'index'])->name('settings');
        Route::post('/settings',  [Dashboard\SettingsController::class,  'update'])->name('settings.update');
    });
