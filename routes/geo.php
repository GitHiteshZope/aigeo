<?php

use Illuminate\Support\Facades\Route;
use Hszope\LaravelAigeo\Http\Controllers\LlmsTxtController;
use Hszope\LaravelAigeo\Http\Controllers\AISitemapController;
use Hszope\LaravelAigeo\Http\Controllers\ProductFeedController;

Route::get('/llms.txt',               [LlmsTxtController::class, 'index'])->name('geo.llms-txt');
Route::get('/llms-full.txt',          [LlmsTxtController::class, 'full'])->name('geo.llms-full-txt');
Route::get('/ai-sitemap.xml',         [AISitemapController::class, 'index'])->name('geo.ai-sitemap');
Route::get('/ai-product-feed.json',   [ProductFeedController::class, 'index'])->name('geo.product-feed');
