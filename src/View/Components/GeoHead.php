<?php

namespace Hszope\LaravelAigeo\View\Components;

use Illuminate\View\Component;
use Hszope\LaravelAigeo\Modules\Schema\SchemaBuilder;
use Hszope\LaravelAigeo\Modules\Citation\CitationEngine;
use Illuminate\Support\Str;

class GeoHead extends Component
{
    public string $schemas;
    public string $description;

    public function __construct(
        public readonly mixed $model = null,
        public readonly array $extra = [],
    ) {
        $this->schemas     = '';
        $this->description = '';

        if ($model && method_exists($model, 'geoProfile')) {
            $profile = $model->geoProfile();

            $builder = app('geo.schema')->product($profile);

            if (config('geo.schema.include_faq') && !empty($profile['faqs']))
                $builder->withFAQ($profile['faqs']);

            if (config('geo.schema.include_reviews') && !empty($profile['reviews']))
                $builder->withReviews($profile['reviews']);

            if (config('geo.schema.include_breadcrumb') && !empty($profile['breadcrumb']))
                $builder->withBreadcrumb($profile['breadcrumb']);

            $this->schemas = $builder->render();

            if (!empty($profile['description'])) {
                $this->description = app('geo.citation')
                    ->enrich($profile['description'], $profile);
            }
        }
    }

    public function render()
    {
        return view('geo::components.geo-head');
    }
}
