<?php

namespace Hszope\LaravelAigeo\Modules\Schema\Types;

class ProductSchema
{
    public function __construct(private readonly array $data) {}

    public function toArray(): array
    {
        $schema = [
            '@context' => 'https://schema.org',
            '@type'    => 'Product',
            'name'     => $this->data['name'],
        ];

        if (!empty($this->data['description']))
            $schema['description'] = $this->data['description'];

        if (!empty($this->data['sku']))
            $schema['sku'] = $this->data['sku'];

        if (!empty($this->data['brand']))
            $schema['brand'] = ['@type' => 'Brand', 'name' => $this->data['brand']];

        if (!empty($this->data['image']))
            $schema['image'] = $this->data['image'];

        if (!empty($this->data['price'])) {
            $schema['offers'] = [
                '@type'         => 'Offer',
                'price'         => $this->data['price'],
                'priceCurrency' => $this->data['currency'] ?? 'USD',
                'availability'  => 'https://schema.org/' . ($this->data['in_stock'] ? 'InStock' : 'OutOfStock'),
                'url'           => $this->data['url'] ?? '',
            ];
        }

        if (!empty($this->data['rating']) && !empty($this->data['review_count'])) {
            $schema['aggregateRating'] = [
                '@type'       => 'AggregateRating',
                'ratingValue' => $this->data['rating'],
                'reviewCount' => $this->data['review_count'],
                'bestRating'  => '5',
                'worstRating' => '1',
            ];
        }

        if (!empty($this->data['attributes'])) {
            $schema['additionalProperty'] = collect($this->data['attributes'])
                ->map(fn($value, $name) => [
                    '@type'       => 'PropertyValue',
                    'name'        => $name,
                    'value'       => $value,
                ])->values()->toArray();
        }

        return $schema;
    }
}
