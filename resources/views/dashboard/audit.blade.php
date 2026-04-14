@extends('geo::dashboard.layout')

@section('page-title')
    Audit: {{ $label }} #{{ $record->getKey() }}
@endsection

@section('header-actions')
<a href="{{ route('geo.dashboard.models') }}" class="text-sm text-gray-500 hover:text-gray-700 flex items-center gap-1">
    ← Back to models
</a>
@endsection

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <div class="lg:col-span-1">
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-8 text-center bg-gradient-to-b from-white to-gray-50/50">
            <div class="relative inline-flex items-center justify-center mb-6">
                @php $color = $result->total >= 70 ? 'green' : ($result->total >= 40 ? 'yellow' : 'red'); @endphp
                <svg class="w-32 h-32 transform -rotate-90">
                    <circle cx="64" cy="64" r="60" stroke="currentColor" stroke-width="8" fill="transparent" class="text-gray-100"></circle>
                    <circle cx="64" cy="64" r="60" stroke="currentColor" stroke-width="8" fill="transparent" stroke-dasharray="377" stroke-dashoffset="{{ 377 - (377 * $result->total / 100) }}" class="text-{{ $color }}-500 transition-all duration-1000"></circle>
                </svg>
                <div class="absolute flex flex-col items-center">
                    <span class="text-4xl font-black text-gray-900 leading-none">{{ $result->total }}</span>
                    <span class="text-xs font-bold text-gray-400 uppercase tracking-widest mt-1">Grade {{ $result->grade() }}</span>
                </div>
            </div>
            <h2 class="text-lg font-bold text-gray-900 mb-1">{{ $record->name ?? $record->title ?? "Record #{$record->getKey()}" }}</h2>
            <p class="text-sm text-gray-500 mb-6">{{ $model }}</p>
            
            <div class="flex gap-2 justify-center">
                <span class="px-3 py-1 bg-green-50 text-green-700 text-xs font-bold rounded-full border border-green-100 italic">
                    {{ count($result->passed) }} Passed
                </span>
                <span class="px-3 py-1 bg-red-50 text-red-700 text-xs font-bold rounded-full border border-red-100 italic">
                    {{ count($result->missing) }} Missing
                </span>
            </div>
        </div>
    </div>

    <div class="lg:col-span-2">
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="font-semibold text-gray-800">GEO Signal Checklist</h3>
            </div>
            <div class="divide-y divide-gray-100">
                @foreach($result->details as $signal => $detail)
                <div class="p-6 flex gap-4">
                    <div class="mt-0.5 flex-shrink-0">
                        @if($detail['passes'])
                            <div class="w-6 h-6 rounded-full bg-green-100 flex items-center justify-center text-green-600">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                            </div>
                        @else
                            <div class="w-6 h-6 rounded-full bg-red-50 flex items-center justify-center text-red-400 border border-red-100">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                            </div>
                        @endif
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center justify-between mb-1">
                            <span class="text-sm font-semibold text-gray-800">{{ str_replace('_', ' ', $signal) }}</span>
                            <span class="text-xs font-mono {{ $detail['passes'] ? 'text-green-600' : 'text-gray-400' }}">
                                {{ $detail['passes'] ? "+{$detail['weight']}" : "0" }} pts
                            </span>
                        </div>
                        @if(!$detail['passes'] && $detail['tip'])
                            <p class="text-xs text-gray-500 bg-gray-50 p-2 rounded mt-1 border border-gray-200/50">
                                <span class="font-bold text-blue-600 uppercase text-[9px] mr-1">Improvement Tip:</span>
                                {{ $detail['tip'] }}
                            </p>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
