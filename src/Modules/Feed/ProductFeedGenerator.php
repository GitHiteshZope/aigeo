<?php

namespace Hszope\LaravelAigeo\Modules\Feed;

class ProductFeedGenerator
{
    public function generate(): array
    {
        return [
            'meta' => [
                'site_name' => config('geo.site_name'),
                'generated_at' => now()->toIso8601String(),
            ],
            'data' => $this->getProducts(),
        ];
    }

    private function getProducts(): array
    {
        return [];
    }
}
