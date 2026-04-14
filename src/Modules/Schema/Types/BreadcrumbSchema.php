<?php

namespace Hszope\LaravelAigeo\Modules\Schema\Types;

class BreadcrumbSchema
{
    public function __construct(private readonly array $breadcrumbs) {}

    public function toArray(): array
    {
        return [
            '@context'        => 'https://schema.org',
            '@type'           => 'BreadcrumbList',
            'itemListElement' => collect($this->breadcrumbs)->map(fn($breadcrumb, $index) => [
                '@type'    => 'ListItem',
                'position' => $index + 1,
                'name'     => $breadcrumb['name'],
                'item'     => url($breadcrumb['url']),
            ])->toArray(),
        ];
    }
}
