<?php

namespace Hszope\LaravelAigeo\Models;

use Illuminate\Database\Eloquent\Model;

class GeoProfile extends Model
{
    protected $table    = 'geo_profiles';
    protected $fillable = ['model_id', 'model_type', 'score', 'audit'];
    protected $casts    = ['audit' => 'json'];

    public function model()
    {
        return $this->morphTo();
    }
}
