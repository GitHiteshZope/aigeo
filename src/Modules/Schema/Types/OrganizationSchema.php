<?php

namespace Hszope\LaravelAigeo\Modules\Schema\Types;

class OrganizationSchema
{
    public function __construct(private readonly array $data = []) {}

    public function toArray(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type'    => 'Organization',
            'name'     => $this->data['name'] ?? config('geo.site_name'),
            'url'      => $this->data['url'] ?? config('geo.site_url'),
            'logo'     => $this->data['logo'] ?? '',
            'description' => $this->data['description'] ?? config('geo.site_description'),
        ];
    }
}
