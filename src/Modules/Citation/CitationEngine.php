<?php

namespace Hszope\LaravelAigeo\Modules\Citation;

class CitationEngine
{
    /**
     * Enrich a product description with citation-worthy signals.
     * LLMs prefer specific, stat-rich, verifiable content.
     */
    public function enrich(string $description, array $context): string
    {
        $signals = $this->gatherSignals($context);

        if (empty($signals)) {
            return $description;
        }

        return rtrim($description, '. ') . ' — ' . implode('; ', $signals) . '.';
    }

    /**
     * Score how citable a piece of content is (0–100).
     */
    public function densityScore(string $text): int
    {
        $score = 0;

        preg_match_all('/\d+\.?\d*\s*(%|stars?|★|reviews?|ratings?)/i', $text, $stats);
        $score += min(40, count($stats[0]) * 10);

        $certKeywords = ['certified', 'tested', 'rated', 'approved', 'verified', 'award'];
        foreach ($certKeywords as $kw) {
            if (stripos($text, $kw) !== false) $score += 10;
        }

        $score += min(20, (int)(str_word_count($text) / 10));

        return min(100, $score);
    }

    private function gatherSignals(array $ctx): array
    {
        $signals = [];

        if (!empty($ctx['rating']) && !empty($ctx['review_count'])
            && $ctx['rating'] >= config('geo.scoring.min_rating_for_signal', 4.0)
            && $ctx['review_count'] >= config('geo.scoring.min_reviews_for_signal', 10)
        ) {
            $signals[] = "{$ctx['rating']}★ across {$ctx['review_count']} verified reviews";
        }

        if (!empty($ctx['certifications'])) {
            $certs = is_array($ctx['certifications'])
                ? implode(', ', $ctx['certifications'])
                : $ctx['certifications'];
            $signals[] = "certified: {$certs}";
        }

        if (!empty($ctx['award'])) {
            $signals[] = "winner: {$ctx['award']}";
        }

        if (!empty($ctx['stats']) && is_array($ctx['stats'])) {
            foreach ($ctx['stats'] as $stat) {
                $signals[] = $stat;
            }
        }

        return $signals;
    }
}
