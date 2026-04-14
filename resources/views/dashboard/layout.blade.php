<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>laravel-aigeo — @yield('page-title', 'Dashboard')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-gray-50 text-gray-900 antialiased">
<div class="flex h-screen overflow-hidden">

    {{-- Sidebar --}}
    <aside class="w-52 flex-shrink-0 bg-gray-100 border-r border-gray-200 flex flex-col">
        <div class="px-4 py-4 border-b border-gray-200">
            <p class="text-sm font-semibold text-gray-800">laravel-aigeo</p>
            <span class="text-xs bg-blue-50 text-blue-700 px-2 py-0.5 rounded-full mt-1 inline-block">v1.0.0</span>
        </div>

        <nav class="mt-2 flex-1">
            @php
                $navItems = [
                    ['route' => 'geo.dashboard.overview', 'label' => 'Overview',       'color' => 'bg-blue-500'],
                    ['route' => 'geo.dashboard.models',   'label' => 'Model Scores',  'color' => 'bg-green-500'],
                    ['route' => 'geo.dashboard.schema',   'label' => 'Schema Builder','color' => 'bg-purple-500'],
                    ['route' => 'geo.dashboard.llms',     'label' => 'llms.txt',      'color' => 'bg-orange-500'],
                    ['route' => 'geo.dashboard.feed',     'label' => 'AI Feed',       'color' => 'bg-yellow-500'],
                    ['route' => 'geo.dashboard.settings', 'label' => 'Settings',      'color' => 'bg-gray-400'],
                ];
            @endphp

            @foreach($navItems as $item)
                @php
                    $isActive = request()->routeIs($item['route'] . '*');
                @endphp
                <a href="{{ route($item['route']) }}"
                   class="flex items-center gap-3 px-4 py-3 text-sm transition-colors {{ $isActive ? 'bg-white text-gray-900 font-semibold border-l-4 border-blue-500' : 'text-gray-500 hover:bg-white hover:text-gray-900' }}">
                    <span class="w-2 h-2 rounded-full {{ $item['color'] }} flex-shrink-0"></span>
                    {{ $item['label'] }}
                </a>
            @endforeach
        </nav>

        <div class="px-4 py-3 border-t border-gray-200 text-xs text-gray-400">
            <p>{{ config('geo.site_name') }}</p>
            <p>hszope/laravel-aigeo</p>
        </div>
    </aside>

    {{-- Main content --}}
    <div class="flex-1 flex flex-col overflow-hidden">
        <header class="bg-white border-b border-gray-200 px-6 py-3.5 flex items-center justify-between flex-shrink-0">
            <h1 class="text-base font-medium">@yield('page-title', 'Overview')</h1>
            <div class="flex gap-2">
                @yield('header-actions')
            </div>
        </header>

        @if(session('success'))
        <div id="geo-alert" class="mx-6 mt-4 bg-green-50 border border-green-200 text-green-800 text-sm px-4 py-2.5 rounded-lg transition-opacity duration-500">
            {{ session('success') }}
        </div>
        <script>
            setTimeout(() => {
                const alert = document.getElementById('geo-alert');
                if (alert) {
                    alert.style.opacity = '0';
                    setTimeout(() => alert.remove(), 500);
                }
            }, 3000);
        </script>
        @endif

        <main class="flex-1 overflow-y-auto p-6">
            @yield('content')
        </main>
    </div>

</div>
</body>
</html>
