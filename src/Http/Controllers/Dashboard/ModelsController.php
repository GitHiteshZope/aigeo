<?php

namespace Hszope\LaravelAigeo\Http\Controllers\Dashboard;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Hszope\LaravelAigeo\Modules\Analytics\GeoScorer;

class ModelsController extends Controller
{
    public function index(Request $request, GeoScorer $scorer)
    {
        $models     = config('geo.dashboard.models', []);
        $gradeFilter= $request->query('grade');
        $rows       = [];

        foreach ($models as $entry) {
            $class = $entry['model'] ?? null;
            if (!$class || !class_exists($class)) continue;

            $class::chunk(200, function ($records) use ($scorer, $gradeFilter, &$rows, $class, $entry) {
                foreach ($records as $record) {
                    $result = $scorer->score($record);
                    $grade  = $result->grade();
                    if ($gradeFilter && $grade !== $gradeFilter) continue;
                    $rows[] = [
                        'model'   => $class,
                        'label'   => $entry['label'] ?? class_basename($class),
                        'id'      => $record->getKey(),
                        'name'    => $record->name ?? $record->title ?? "#{$record->getKey()}",
                        'score'   => $result->total,
                        'grade'   => $grade,
                        'missing' => $result->missing,
                    ];
                }
            });
        }

        usort($rows, fn($a, $b) => $b['score'] <=> $a['score']);

        return view('geo::dashboard.models', [
            'rows'        => $rows,
            'gradeFilter' => $gradeFilter,
        ]);
    }

    public function audit(string $model, int|string $id, GeoScorer $scorer)
    {
        $modelClass = str_replace('-', '\\', $model);
        if (!class_exists($modelClass)) {
            // Try to find it in the config
            $entry = collect(config('geo.dashboard.models', []))
                ->first(fn($e) => $e['model'] === $model || class_basename($e['model']) === $model);
            if ($entry) $modelClass = $entry['model'];
        }

        abort_if(!class_exists($modelClass), 404);

        $record = $modelClass::findOrFail($id);
        $result = $scorer->score($record);

        return view('geo::dashboard.audit', [
            'record' => $record,
            'result' => $result,
            'model'  => $modelClass,
            'label'  => class_basename($modelClass),
        ]);
    }
}
