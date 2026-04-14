<?php

namespace Hszope\LaravelAigeo\Http\Controllers\Dashboard;

use Illuminate\Routing\Controller;
use Hszope\LaravelAigeo\Modules\Analytics\GeoScorer;

class DashboardController extends Controller
{
    public function index(GeoScorer $scorer)
    {
        $models    = config('geo.dashboard.models', []);
        $allScores = [];
        $issues    = [];

        foreach ($models as $entry) {
            $class = $entry['model'];
            if (!class_exists($class)) continue;

            $class::chunk(200, function ($records) use ($scorer, &$allScores, &$issues) {
                foreach ($records as $record) {
                    $result = $scorer->score($record);
                    $allScores[] = $result->total;
                    foreach ($result->missing as $signal) {
                        $issues[$signal] = ($issues[$signal] ?? 0) + 1;
                    }
                }
            });
        }

        arsort($issues);

        return view('geo::dashboard.overview', [
            'avg_score'    => count($allScores) ? round(array_sum($allScores) / count($allScores)) : 0,
            'total_models' => count($allScores),
            'issues'       => array_slice($issues, 0, 6, true),
            'endpoints'    => $this->checkEndpoints(),
            'distribution' => $this->gradeDistribution($allScores),
            'missing_faqs' => $issues['has_faq_schema'] ?? 0,
            'json_ld_count'=> count($allScores),
        ]);
    }

    private function gradeDistribution(array $scores): array
    {
        $dist = ['A' => 0, 'B' => 0, 'C' => 0, 'D' => 0, 'F' => 0];
        foreach ($scores as $s) {
            $dist[match(true) {
                $s >= 85 => 'A', $s >= 70 => 'B',
                $s >= 55 => 'C', $s >= 40 => 'D', default => 'F',
            }]++;
        }
        return $dist;
    }

    private function checkEndpoints(): array
    {
        $routes = [
            '/llms.txt'             => 'llms-txt',
            '/llms-full.txt'        => 'llms-full-txt',
            '/ai-product-feed.json' => 'product-feed',
            '/ai-sitemap.xml'       => 'ai-sitemap',
        ];
        $result = [];
        foreach ($routes as $path => $name) {
            try {
                $result[$path] = app('router')->getRoutes()->getByName("geo.$name") ? 'ok' : 'missing';
            } catch (\Throwable) {
                $result[$path] = 'missing';
            }
        }
        return $result;
    }
}
