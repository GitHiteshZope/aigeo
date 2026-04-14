@extends('geo::dashboard.layout')

@section('page-title', 'Schema Toggles & Preview')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <div class="space-y-8">
        <form action="{{ route('geo.dashboard.schema.update') }}" method="POST" class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
            @csrf
            <h3 class="font-semibold text-gray-800 mb-6 flex items-center gap-2">
                <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                Schema Injection Toggles
            </h3>
            
            <div class="space-y-4">
                @foreach(['product' => 'Product Schema', 'faq' => 'FAQ Schema', 'review' => 'Review Schema', 'breadcrumb' => 'Breadcrumb Schema', 'organization' => 'Organization Schema'] as $key => $label)
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg border border-gray-100 hover:bg-gray-100/50 transition-colors">
                    <div>
                        <p class="text-sm font-medium text-gray-800">{{ $label }}</p>
                        <p class="text-xs text-gray-400">Inject <code>ld+json</code> for this type.</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="{{ $key }}" class="sr-only peer" {{ ($settings["schema_$key"] ?? config("geo.schema.include_$key")) ? 'checked' : '' }} value="1">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-purple-600"></div>
                    </label>
                </div>
                @endforeach
            </div>

            <div class="mt-8">
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2.5 px-4 rounded-lg transition-colors shadow-sm shadow-blue-200">
                    Save Configuration
                </button>
            </div>
        </form>
    </div>

    <div class="space-y-8">
        <div class="bg-gray-900 rounded-xl shadow-xl overflow-hidden">
            <div class="px-6 py-4 bg-gray-800 border-b border-gray-700 flex items-center justify-between">
                <h3 class="text-gray-200 text-sm font-semibold">JSON-LD Output Preview</h3>
                <span class="px-2 py-0.5 bg-green-900/50 text-green-400 text-[10px] font-bold rounded uppercase">Valid Schema</span>
            </div>
            <div class="p-6">
                <pre class="text-xs text-blue-300 font-mono whitespace-pre-wrap leading-relaxed">
{
  "@@context": "https://schema.org",
  "@@type": "Product",
  "name": "{{ config('geo.site_name') }} Sample Product",
  "description": "AI-optimized description rich with stats/facts...",
  "offers": {
    "@@type": "Offer",
    "price": "199.99",
    "priceCurrency": "USD"
  },
  "aggregateRating": {
    "@@type": "AggregateRating",
    "ratingValue": "4.8",
    "reviewCount": "154"
  }
}
                </pre>
            </div>
            <div class="px-6 py-3 bg-gray-800/50 text-[10px] text-gray-400 flex justify-between italic">
                <span>View source of your page to see actual output</span>
                <span>Injects into &lt;head&gt;</span>
            </div>
        </div>
    </div>
</div>
@endsection
