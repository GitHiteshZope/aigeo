<?php

namespace Hszope\LaravelAigeo\Traits;

use Hszope\LaravelAigeo\Models\GeoProfile;
use Hszope\LaravelAigeo\Modules\Analytics\GeoScorer;
use Hszope\LaravelAigeo\Modules\Schema\SchemaBuilder;

trait HasGeoProfile
{
    /*
    |--------------------------------------------------------------------------
    | Boot
    |--------------------------------------------------------------------------
    */
    public static function bootHasGeoProfile(): void
    {
        static::created(function ($model) {
            $model->geoProfileRecord()->create([]);
        });

        static::deleted(function ($model) {
            $model->geoProfileRecord()->delete();
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Relationship
    |--------------------------------------------------------------------------
    */
    public function geoProfileRecord()
    {
        return $this->morphOne(GeoProfile::class, 'model');
    }

    /*
    |--------------------------------------------------------------------------
    | Abstract — implement in your model
    |--------------------------------------------------------------------------
    */
    abstract public function geoProfile(): array;

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */
    public function geoSchema(): string
    {
        return app('geo.schema')
            ->product($this->geoProfile())
            ->render();
    }

    public function geoScore(): int
    {
        return app('geo.scorer')->score($this)->total;
    }

    public function geoAudit(): array
    {
        return app('geo.scorer')->score($this)->toArray();
    }

    public function scopeByGeoScore($query, string $direction = 'desc')
    {
        return $query->withAvg('geoProfileRecord', 'score')
                     ->orderBy('geo_profile_record_avg_score', $direction);
    }
}
