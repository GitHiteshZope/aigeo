<?php

namespace Hszope\LaravelAigeo\Modules\Schema;

use Hszope\LaravelAigeo\Modules\Schema\Types\ProductSchema;
use Hszope\LaravelAigeo\Modules\Schema\Types\FAQSchema;
use Hszope\LaravelAigeo\Modules\Schema\Types\ReviewSchema;
use Hszope\LaravelAigeo\Modules\Schema\Types\BreadcrumbSchema;
use Hszope\LaravelAigeo\Modules\Schema\Types\OrganizationSchema;

class SchemaBuilder
{
    private array $schemas = [];

    public function product(array $data): static
    {
        $this->schemas[] = (new ProductSchema($data))->toArray();
        return $this;
    }

    public function withFAQ(array $faqs): static
    {
        if (!empty($faqs)) {
            $this->schemas[] = (new FAQSchema($faqs))->toArray();
        }
        return $this;
    }

    public function withReviews($reviews): static
    {
        if ($reviews && count($reviews)) {
            $this->schemas[] = (new ReviewSchema($reviews))->toArray();
        }
        return $this;
    }

    public function withBreadcrumb(array $breadcrumbs): static
    {
        if (!empty($breadcrumbs)) {
            $this->schemas[] = (new BreadcrumbSchema($breadcrumbs))->toArray();
        }
        return $this;
    }

    public function organization(array $data = []): static
    {
        $this->schemas[] = (new OrganizationSchema($data))->toArray();
        return $this;
    }

    public function render(): string
    {
        return collect($this->schemas)
            ->map(fn($schema) => sprintf(
                '<script type="application/ld+json">%s</script>',
                json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)
            ))
            ->implode("\n");
    }

    public function toArray(): array
    {
        return $this->schemas;
    }
}
