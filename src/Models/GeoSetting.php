<?php

namespace Hszope\LaravelAigeo\Models;

use Illuminate\Database\Eloquent\Model;

class GeoSetting extends Model
{
    protected $table    = 'geo_settings';
    protected $fillable = ['key', 'value'];
}
