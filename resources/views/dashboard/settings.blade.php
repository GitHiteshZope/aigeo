@extends('geo::dashboard.layout')

@section('page-title', 'Global Settings')

@section('content')
<div class="max-w-4xl">
    <form action="{{ route('geo.dashboard.settings.update') }}" method="POST" class="space-y-8">
        @csrf
        
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="font-semibold text-gray-800">Auth & Access</h3>
            </div>
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Dashboard Route</label>
                    <input type="text" value="{{ config('geo.dashboard.path') }}" readonly class="w-full bg-gray-50 border-gray-300 rounded-lg text-sm text-gray-400 cursor-not-allowed">
                    <p class="mt-1 text-[10px] text-gray-400 italic">Change <code>GEO_DASHBOARD_PATH</code> in .env to update</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Auth Middleware</label>
                    <select name="dashboard_middleware" class="w-full border-gray-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="auth" {{ ($settings['dashboard_middleware'] ?? config('geo.dashboard.middleware')) === 'auth' ? 'selected' : '' }}>Laravel Auth (default)</option>
                        <option value="auth:admin" {{ ($settings['dashboard_middleware'] ?? config('geo.dashboard.middleware')) === 'auth:admin' ? 'selected' : '' }}>auth:admin</option>
                        <option value="none" {{ ($settings['dashboard_middleware'] ?? config('geo.dashboard.middleware')) === 'none' ? 'selected' : '' }}>Public (none - use for local dev ONLY)</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="font-semibold text-gray-800">Site Identity</h3>
            </div>
            <div class="p-6 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Site Name</label>
                    <input type="text" name="site_name" value="{{ $settings['site_name'] ?? config('geo.site_name') }}" class="w-full border-gray-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">GEO Description (Organization Schema)</label>
                    <textarea name="site_description" rows="3" class="w-full border-gray-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500">{{ $settings['site_description'] ?? config('geo.site_description') }}</textarea>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="font-semibold text-gray-800">Scoring Thresholds</h3>
            </div>
            <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Min. Desc Words</label>
                    <input type="number" name="min_description_words" value="{{ $settings['min_description_words'] ?? config('geo.scoring.min_description_words') }}" class="w-full border-gray-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Min. Review Count</label>
                    <input type="number" name="min_reviews_for_signal" value="{{ $settings['min_reviews_for_signal'] ?? config('geo.scoring.min_reviews_for_signal') }}" class="w-full border-gray-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Min. Rating (1-5)</label>
                    <input type="number" step="0.1" name="min_rating_for_signal" value="{{ $settings['min_rating_for_signal'] ?? config('geo.scoring.min_rating_for_signal') }}" class="w-full border-gray-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-black text-white px-8 py-3 rounded-xl font-bold hover:bg-gray-800 transition-colors shadow-lg shadow-gray-200">
                Save Changes
            </button>
        </div>
    </form>
</div>
@endsection
