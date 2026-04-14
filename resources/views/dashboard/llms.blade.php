@extends('geo::dashboard.layout')

@section('page-title', 'llms.txt Management')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm lg:col-span-1">
        <p class="text-sm text-gray-500 mb-1">Status</p>
        <div class="flex items-center gap-2">
            @if(file_exists(public_path('llms.txt')))
                <span class="w-3 h-3 rounded-full bg-green-500"></span>
                <span class="text-xl font-semibold text-gray-800">Live</span>
            @else
                <span class="w-3 h-3 rounded-full bg-red-500"></span>
                <span class="text-xl font-semibold text-gray-800">Missing</span>
            @endif
        </div>
        <p class="text-[10px] text-gray-400 mt-2">Checked in <code>public/llms.txt</code></p>
    </div>

    <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm lg:col-span-3">
        <div class="flex justify-between items-center mb-4">
            <div>
                <h3 class="font-semibold text-gray-800">Preview</h3>
                <p class="text-xs text-gray-400">What AI-crawlers see when visiting <code>/llms.txt</code></p>
            </div>
            <form action="{{ route('geo.dashboard.llms.regenerate') }}" method="POST">
                @csrf
                <button type="submit" class="bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 text-xs font-bold py-2 px-4 rounded shadow-sm">
                    Regenerate File
                </button>
            </form>
        </div>
        <div class="bg-gray-50 p-4 border border-gray-200 rounded-lg">
            <pre class="text-xs text-gray-600 font-mono whitespace-pre-wrap leading-loose">{{ $content }}</pre>
        </div>
    </div>
</div>

<div class="bg-blue-900 rounded-xl p-8 text-white relative overflow-hidden shadow-xl shadow-blue-200/50">
    <div class="relative z-10 w-full lg:w-2/3">
        <h3 class="text-xl font-bold mb-2">Automate with Scheduler</h3>
        <p class="text-blue-200 text-sm mb-6 leading-relaxed">AI crawlers expect fresh data. We recommend regenerating your llms.txt at least once per day via the Laravel Task Scheduler.</p>
        
        <div class="bg-black/20 p-4 rounded-lg border border-white/10 font-mono text-sm">
            <p class="text-blue-300">// In app/Console/Kernel.php</p>
            <p>$schedule->command('geo:llms-txt')->daily();</p>
        </div>
    </div>
    <div class="absolute right-0 bottom-0 opacity-10 pointer-events-none translate-x-12 translate-y-12">
        <svg class="w-64 h-64" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z"></path></svg>
    </div>
</div>
@endsection
