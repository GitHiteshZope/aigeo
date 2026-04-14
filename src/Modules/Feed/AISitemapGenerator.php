<?php

namespace Hszope\LaravelAigeo\Modules\Feed;

use Illuminate\Support\Facades\View;

class AISitemapGenerator
{
    public function generate(): string
    {
        $data = [
            'site_url' => config('geo.site_url'),
            'products' => $this->getProducts(),
        ];

        return View::make('geo::ai-sitemap', $data)->render();
    }

    private function getProducts(): array
    {
        // This would normally fetch models with HasGeoProfile
        // For now, return empty or implement a basic fetcher if needed
        return [];
    }
}
