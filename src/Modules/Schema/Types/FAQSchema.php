<?php

namespace Hszope\LaravelAigeo\Modules\Schema\Types;

class FAQSchema
{
    public function __construct(private readonly array $faqs) {}

    public function toArray(): array
    {
        return [
            '@context'   => 'https://schema.org',
            '@type'      => 'FAQPage',
            'mainEntity' => collect($this->faqs)->map(fn($faq) => [
                '@type'          => 'Question',
                'name'           => $faq['question'],
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text'  => $faq['answer'],
                ],
            ])->toArray(),
        ];
    }
}
