<?php

namespace Hszope\LaravelAigeo\Http\Controllers\Dashboard;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Hszope\LaravelAigeo\Models\GeoSetting;

class SettingsController extends Controller
{
    public function index()
    {
        return view('geo::dashboard.settings', [
            'settings' => GeoSetting::pluck('value', 'key')->toArray(),
        ]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'site_name'               => 'required|string|max:255',
            'site_description'        => 'nullable|string|max:500',
            'dashboard_middleware'    => 'required|string',
            'min_description_words'  => 'required|integer|min:50|max:1000',
            'min_reviews_for_signal' => 'required|integer|min:1',
            'min_rating_for_signal'  => 'required|numeric|min:1|max:5',
        ]);

        foreach ($validated as $key => $value) {
            GeoSetting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        // Bust the llms.txt cache since site identity may have changed
        app('geo.llms')->bust();

        return back()->with('success', 'Settings saved successfully.');
    }
}
