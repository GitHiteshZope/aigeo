@extends('geo::dashboard.layout')

@section('page-title', 'GEO Overview')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
        <p class="text-sm text-gray-500 mb-1">Avg GEO Score</p>
        <div class="flex items-end gap-2">
            <span class="text-3xl font-bold {{ $avg_score >= 70 ? 'text-green-600' : ($avg_score >= 40 ? 'text-yellow-600' : 'text-red-600') }}">
                {{ $avg_score }}
            </span>
            <span class="text-gray-400 mb-1">/ 100</span>
        </div>
    </div>

    <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
        <p class="text-sm text-gray-500 mb-1">llms.txt Status</p>
        <div class="flex items-center gap-2">
            @if($endpoints['/llms.txt'] === 'ok')
                <span class="w-3 h-3 rounded-full bg-green-500"></span>
                <span class="text-xl font-semibold text-gray-800">Live</span>
            @else
                <span class="w-3 h-3 rounded-full bg-red-500"></span>
                <span class="text-xl font-semibold text-gray-800">Missing</span>
            @endif
        </div>
    </div>

    <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
        <p class="text-sm text-gray-500 mb-1">JSON-LD Coverage</p>
        <div class="flex items-end gap-2">
            <span class="text-3xl font-bold text-gray-800">{{ $json_ld_count }}</span>
            <span class="text-gray-400 mb-1">models</span>
        </div>
    </div>

    <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
        <p class="text-sm text-gray-500 mb-1">Missing FAQs</p>
        <div class="flex items-end gap-2">
            <span class="text-3xl font-bold {{ $missing_faqs > 0 ? 'text-orange-600' : 'text-gray-800' }}">
                {{ $missing_faqs }}
            </span>
            <span class="text-gray-400 mb-1">products</span>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <div class="lg:col-span-2 space-y-8">
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                <h3 class="font-semibold text-gray-800">Top Issues to Fix</h3>
                <a href="{{ route('geo.dashboard.models') }}" class="text-sm text-blue-600 hover:underline">View all models</a>
            </div>
            <table class="w-full text-left">
                <thead class="bg-gray-50 text-xs text-gray-500 uppercase">
                    <tr>
                        <th class="px-6 py-3 font-medium">Signal</th>
                        <th class="px-6 py-3 font-medium">Affected</th>
                        <th class="px-6 py-3 font-medium text-right">Impact</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($issues as $signal => $count)
                    <tr>
                        <td class="px-6 py-4 text-sm text-gray-800">{{ str_replace('_', ' ', $signal) }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $count }} items</td>
                        <td class="px-6 py-4 text-sm font-medium text-red-600 text-right">-{{ \Hszope\LaravelAigeo\Modules\Analytics\GeoScorer::SIGNALS[$signal]['weight'] ?? 0 }} pts</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-6 py-12 text-center text-gray-400 italic">No major issues found. Nice job!</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="space-y-8">
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
            <h3 class="font-semibold text-gray-800 mb-4">AI Endpoints</h3>
            <div class="space-y-4">
                @foreach($endpoints as $path => $status)
                <div class="flex items-center justify-between">
                    <div class="flex flex-col">
                        <span class="text-sm font-medium text-gray-700">{{ $path }}</span>
                        <span class="text-xs text-gray-400">GET request</span>
                    </div>
                    <span class="px-2 py-1 text-[10px] font-bold uppercase rounded-full {{ $status === 'ok' ? 'bg-green-50 text-green-700' : 'bg-red-50 text-red-700' }}">
                        {{ $status }}
                    </span>
                </div>
                @endforeach
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
            <h3 class="font-semibold text-gray-800 mb-4">Grade Distribution</h3>
            <div class="space-y-3">
                @foreach($distribution as $grade => $count)
                @php $percent = $total_models > 0 ? ($count / $total_models) * 100 : 0; @endphp
                <div>
                    <div class="flex justify-between text-xs mb-1">
                        <span class="font-medium text-gray-600">Grade {{ $grade }}</span>
                        <span class="text-gray-400">{{ $count }}</span>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-1.5">
                        <div class="h-1.5 rounded-full {{ $grade === 'A' ? 'bg-green-500' : ($grade === 'B' ? 'bg-blue-500' : ($grade === 'C' ? 'bg-yellow-500' : ($grade === 'D' ? 'bg-orange-500' : 'bg-red-500'))) }}" style="width: {{ $percent }}%"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
