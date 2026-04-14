<?php

namespace Hszope\LaravelAigeo\Console;

use Illuminate\Console\Command;
use Hszope\LaravelAigeo\Modules\Analytics\GeoScorer;

class AuditGeoScore extends Command
{
    protected $signature   = 'geo:audit {model : Full model class e.g. App\\Models\\Product} {--id= : Specific model ID}';
    protected $description = 'Audit the GEO score for a model or all records';

    public function handle(GeoScorer $scorer): int
    {
        $modelClass = $this->argument('model');

        if (!class_exists($modelClass)) {
            $this->error("Model class {$modelClass} not found.");
            return self::FAILURE;
        }

        $id    = $this->option('id');
        $query = $id ? $modelClass::where('id', $id) : $modelClass::query();

        $query->each(function ($model) use ($scorer) {
            $result = $scorer->score($model);

            $this->newLine();
            $this->line("  <fg=cyan>#{$model->id}</> — <fg=white>{$model->name}</> — Score: <fg=yellow>{$result->total}/100</> (Grade: <fg=yellow>{$result->grade()}</>)");

            foreach ($result->details as $signal => $detail) {
                $icon  = $detail['passes'] ? '<fg=green>✅</>' : '<fg=red>❌</>';
                $label = str_pad($signal, 26);
                $pts   = $detail['passes'] ? "+{$detail['weight']}" : "  0";
                $line  = "     {$icon}  {$label}  {$pts}";
                if (!$detail['passes'] && $detail['tip']) {
                    $line .= "  <fg=gray>→ {$detail['tip']}</>";
                }
                $this->line($line);
            }
        });

        return self::SUCCESS;
    }
}
