<?php

namespace Hszope\LaravelAigeo\Modules\LlmsTxt;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;

class LlmsTxtGenerator
{
    public function generate(bool $full = false): string
    {
        $cacheKey = $full ? 'geo:llms-full-txt' : 'geo:llms-txt';
        $ttl      = config('geo.llms_txt.cache_ttl', 3600);

        return Cache::remember($cacheKey, $ttl, function () use ($full) {
            return $this->build($full);
        });
    }

    public function bust(): void
    {
        Cache::forget('geo:llms-txt');
        Cache::forget('geo:llms-full-txt');
    }

    private function build(bool $full): string
    {
        $data = [
            'site_name'    => config('geo.site_name'),
            'description'  => config('geo.site_description'),
            'site_url'     => config('geo.site_url'),
            'feed_url'     => url(config('geo.feed.route', '/ai-product-feed.json')),
            'sitemap_url'  => url(config('geo.feed.sitemap_route', '/ai-sitemap.xml')),
            'generated_at' => now()->toIso8601String(),
        ];

        $view = $full ? 'geo::llms-full-txt' : 'geo::llms-txt';

        return View::make($view, $data)->render();
    }
}
