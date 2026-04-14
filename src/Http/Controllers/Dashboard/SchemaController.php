<?php

namespace Hszope\LaravelAigeo\Http\Controllers\Dashboard;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Hszope\LaravelAigeo\Models\GeoSetting;

class SchemaController extends Controller
{
    public function index()
    {
        return view('geo::dashboard.schema', [
            'settings' => GeoSetting::pluck('value', 'key')->toArray(),
        ]);
    }

    public function update(Request $request)
    {
        $keys = ['product', 'faq', 'review', 'breadcrumb', 'organization'];
        
        foreach ($keys as $key) {
            $value = $request->has($key) ? '1' : '0';
            GeoSetting::updateOrCreate(['key' => "schema_$key"], ['value' => $value]);
        }

        return back()->with('success', 'Schema settings updated successfully.');
    }
}
