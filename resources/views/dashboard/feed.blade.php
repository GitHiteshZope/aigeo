@extends('geo::dashboard.layout')

@section('page-title', 'AI product Feed')

@section('content')
<div class="space-y-8">
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h3 class="font-semibold text-gray-800">AI Feed Metadata</h3>
                <p class="text-xs text-gray-400">Active endpoints for AI search engines</p>
            </div>
            <form action="{{ route('geo.dashboard.feed.regenerate') }}" method="POST">
                @csrf
                <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white text-xs font-bold py-2.5 px-6 rounded-lg shadow-sm shadow-orange-200">
                    Purge Cache
                </button>
            </form>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="p-4 bg-gray-50 rounded-lg border border-gray-100 flex flex-col items-center text-center">
                <span class="text-xs text-gray-400 uppercase mb-1 font-bold tracking-tight">Feed Format</span>
                <span class="text-lg font-bold text-gray-800">JSON-LD / LLM-ready</span>
            </div>
            <div class="p-4 bg-gray-50 rounded-lg border border-gray-100 flex flex-col items-center text-center">
                <span class="text-xs text-gray-400 uppercase mb-1 font-bold tracking-tight">Active Models</span>
                <span class="text-lg font-bold text-gray-800">{{ count(config('geo.dashboard.models', [])) }}</span>
            </div>
            <div class="p-4 bg-gray-50 rounded-lg border border-gray-100 flex flex-col items-center text-center">
                <span class="text-xs text-gray-400 uppercase mb-1 font-bold tracking-tight">Sync Interval</span>
                <span class="text-lg font-bold text-gray-800">{{ config('geo.feed.cache_ttl', 900) / 60 }} mins</span>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 border-b border-gray-100 flex items-center justify-between">
            <h3 class="text-gray-800 text-sm font-semibold">Feed URL: <code>{{ config('geo.feed.route') }}</code></h3>
            <a href="{{ config('geo.feed.route') }}" target="_blank" class="text-xs text-blue-600 font-bold hover:underline">Open Live Feed →</a>
        </div>
        <div class="p-6 bg-gray-900 text-xs font-mono text-yellow-200 overflow-x-auto">
            <pre>{
  "meta": {
    "site_name": "{{ config('geo.site_name') }}",
    "generated_at": "{{ now()->toIso8601String() }}"
  },
  "data": [
    {
      "@@type": "Product",
      "name": "Sample Product",
      "geo_score": 92,
      "url": "{{ config('geo.site_url') }}/products/1"
    }
  ]
}</pre>
        </div>
    </div>
</div>
@endsection
