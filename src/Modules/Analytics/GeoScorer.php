<?php

namespace Hszope\LaravelAigeo\Modules\Analytics;

class GeoScoreResult
{
    public function __construct(
        public readonly int   $total,
        public readonly array $passed,
        public readonly array $missing,
        public readonly array $details,
    ) {}

    public function toArray(): array
    {
        return [
            'score'   => $this->total,
            'grade'   => $this->grade(),
            'passed'  => $this->passed,
            'missing' => $this->missing,
            'details' => $this->details,
        ];
    }

    public function grade(): string
    {
        return match(true) {
            $this->total >= 85 => 'A',
            $this->total >= 70 => 'B',
            $this->total >= 55 => 'C',
            $this->total >= 40 => 'D',
            default            => 'F',
        };
    }
}

class GeoScorer
{
    const SIGNALS = [
        'has_json_ld'           => ['weight' => 20, 'tip' => 'Add JSON-LD via geoSchema()'],
        'has_faq_schema'        => ['weight' => 15, 'tip' => 'Add FAQs to geoProfile() — huge AI citation driver'],
        'has_review_schema'     => ['weight' => 10, 'tip' => 'Include rating and review_count in geoProfile()'],
        'description_length'    => ['weight' => 10, 'tip' => 'Description should be 150+ words'],
        'has_specific_numbers'  => ['weight' => 10, 'tip' => 'Include price, dimensions, weight, ratings'],
        'has_llms_txt'          => ['weight' => 10, 'tip' => 'Run php artisan geo:llms-txt'],
        'entity_consistency'    => ['weight' => 10, 'tip' => 'Brand name must be consistent across all fields'],
        'has_breadcrumb'        => ['weight' =>  5, 'tip' => 'Add breadcrumb array to geoProfile()'],
        'has_canonical'         => ['weight' =>  5, 'tip' => 'Add url field to geoProfile()'],
        'content_density'       => ['weight' =>  5, 'tip' => 'Aim for 1 specific fact per sentence in description'],
    ];

    public function score($model): GeoScoreResult
    {
        $profile = $model->geoProfile();
        $total   = 0;
        $passed  = [];
        $missing = [];
        $details = [];

        foreach (self::SIGNALS as $signal => $meta) {
            $passes = $this->check($signal, $profile);
            $details[$signal] = [
                'passes' => $passes,
                'weight' => $meta['weight'],
                'tip'    => $passes ? null : $meta['tip'],
            ];
            if ($passes) {
                $total += $meta['weight'];
                $passed[] = $signal;
            } else {
                $missing[] = $signal;
            }
        }

        return new GeoScoreResult($total, $passed, $missing, $details);
    }

    private function check(string $signal, array $profile): bool
    {
        return match($signal) {
            'has_json_ld'          => !empty($profile['name']) && !empty($profile['price']),
            'has_faq_schema'       => !empty($profile['faqs']) && count($profile['faqs']) > 0,
            'has_review_schema'    => !empty($profile['rating']) && !empty($profile['review_count'])
                                        && $profile['review_count'] >= config('geo.scoring.min_reviews_for_signal', 10),
            'description_length'   => !empty($profile['description'])
                                        && str_word_count($profile['description']) >= config('geo.scoring.min_description_words', 150),
            'has_specific_numbers' => !empty($profile['price']) || !empty($profile['attributes']),
            'has_llms_txt'         => file_exists(public_path('llms.txt')),
            'entity_consistency'   => $this->checkEntityConsistency($profile),
            'has_breadcrumb'       => !empty($profile['breadcrumb']),
            'has_canonical'        => !empty($profile['url']),
            'content_density'      => $this->checkContentDensity($profile['description'] ?? ''),
            default                => false,
        };
    }

    private function checkEntityConsistency(array $profile): bool
    {
        if (empty($profile['brand']) || empty($profile['name'])) return false;
        $brandInName        = str_contains(strtolower($profile['name']), strtolower($profile['brand']));
        $brandInDescription = !empty($profile['description'])
            && str_contains(strtolower($profile['description']), strtolower($profile['brand']));
        return $brandInName || $brandInDescription;
    }

    private function checkContentDensity(string $text): bool
    {
        if (empty($text)) return false;
        preg_match_all('/\d+\.?\d*/', $text, $numbers);
        $sentences = max(1, preg_match_all('/[.!?]+/', $text));
        return count($numbers[0]) / $sentences >= 0.5;
    }
}
