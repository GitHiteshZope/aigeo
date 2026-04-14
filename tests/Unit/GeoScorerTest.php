<?php

use Hszope\LaravelAigeo\Modules\Analytics\GeoScorer;
use Hszope\LaravelAigeo\Tests\TestCase;

uses(TestCase::class);

it('scores a perfect product at 100', function () {
    $model = new class {
        public function geoProfile(): array {
            return [
                'name'         => 'Bridgestone Turanza T005',
                'description'  => str_repeat('This excellent tyre achieves 4.7 stars with 312 reviews. ', 10),
                'price'        => 129.99,
                'brand'        => 'Bridgestone',
                'rating'       => 4.7,
                'review_count' => 312,
                'faqs'         => [['question' => 'Q1?', 'answer' => 'A1.']],
                'breadcrumb'   => [['name' => 'Home', 'url' => '/']],
                'url'          => 'https://example.com/product/1',
                'attributes'   => ['width' => '225', 'aspect' => '45'],
            ];
        }
    };
    
    // Mock public_path/llms.txt check
    if (!file_exists(public_path('llms.txt'))) {
        @mkdir(public_path(), 0777, true);
        file_put_contents(public_path('llms.txt'), '# test');
    }

    $result = (new GeoScorer)->score($model);

    expect($result->total)->toBeGreaterThanOrEqual(85)
        ->and($result->grade())->toBe('A');
});

it('penalises missing faq schema', function () {
    $model = new class {
        public function geoProfile(): array {
            return ['name' => 'Test', 'price' => 9.99, 'brand' => 'Brand Test'];
        }
    };

    $result = (new GeoScorer)->score($model);

    expect($result->missing)->toContain('has_faq_schema');
});
