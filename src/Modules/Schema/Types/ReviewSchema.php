<?php

namespace Hszope\LaravelAigeo\Modules\Schema\Types;

class ReviewSchema
{
    public function __construct(private readonly array $reviews) {}

    public function toArray(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type'    => 'Review',
            'review'   => collect($this->reviews)->map(fn($review) => [
                '@type'         => 'Review',
                'reviewRating'  => [
                    '@type'       => 'Rating',
                    'ratingValue' => $review['rating'],
                ],
                'author'        => [
                    '@type' => 'Person',
                    'name'  => $review['author'],
                ],
                'reviewBody'    => $review['body'] ?? '',
                'datePublished' => $review['date'] ?? '',
            ])->toArray(),
        ];
    }
}
