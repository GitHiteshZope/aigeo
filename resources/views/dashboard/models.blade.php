@extends('geo::dashboard.layout')

@section('page-title', 'Model Scores')

@section('header-actions')
<form action="{{ route('geo.dashboard.models') }}" method="GET" class="flex gap-2">
    <select name="grade" onchange="this.form.submit()" class="text-sm border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 bg-white">
        <option value="">All Grades</option>
        @foreach(['A', 'B', 'C', 'D', 'F'] as $g)
            <option value="{{ $g }}" {{ $gradeFilter === $g ? 'selected' : '' }}>Grade {{ $g }}</option>
        @endforeach
    </select>
</form>
@endsection

@section('content')
<div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
    @if(empty($rows))
        <div class="p-12 text-center">
            <p class="text-gray-500 mb-4">No models configured yet.</p>
            <p class="text-sm text-gray-400">Add your Eloquent models to <code>config/geo.php</code> under <code>dashboard.models</code>.</p>
        </div>
    @else
        <table class="w-full text-left">
            <thead class="bg-gray-50 text-xs text-gray-500 uppercase">
                <tr>
                    <th class="px-6 py-3 font-medium">Model & ID</th>
                    <th class="px-6 py-3 font-medium">Record Name</th>
                    <th class="px-6 py-3 font-medium">Score</th>
                    <th class="px-6 py-3 font-medium">Grade</th>
                    <th class="px-6 py-3 font-medium text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($rows as $row)
                <tr>
                    <td class="px-6 py-4">
                        <div class="flex flex-col">
                            <span class="text-sm font-medium text-gray-900">{{ $row['label'] }}</span>
                            <span class="text-xs text-gray-400">#{{ $row['id'] }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $row['name'] }}</td>
                    <td class="px-6 py-4">
                        <div class="w-32 bg-gray-100 rounded-full h-2">
                            <div class="h-2 rounded-full {{ $row['score'] >= 70 ? 'bg-green-500' : ($row['score'] >= 40 ? 'bg-yellow-500' : 'bg-red-500') }}" style="width: {{ $row['score'] }}%"></div>
                        </div>
                        <span class="text-[10px] text-gray-400">{{ $row['score'] }}% coverage</span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-0.5 text-xs font-bold rounded {{ $row['grade'] === 'A' ? 'bg-green-100 text-green-800' : ($row['grade'] === 'B' ? 'bg-blue-100 text-blue-800' : ($row['grade'] === 'C' ? 'bg-yellow-100 text-yellow-800' : ($row['grade'] === 'D' ? 'bg-orange-100 text-orange-800' : 'bg-red-100 text-red-800'))) }}">
                            {{ $row['grade'] }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <a href="{{ route('geo.dashboard.audit', ['model' => str_replace('\\', '-', $row['model']), 'id' => $row['id']]) }}" class="text-sm font-medium text-blue-600 hover:text-blue-800">
                            Audit Details
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
