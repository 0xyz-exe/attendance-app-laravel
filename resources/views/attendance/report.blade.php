<x-app-layout>
<x-slot name="header"><h2 class="font-semibold text-xl text-gray-800">Attendance Report</h2></x-slot>
<div class="py-12"><div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
<div class="mb-6 flex justify-between items-center">
<form method="GET" class="flex gap-2"><input type="month" name="month" value="{{ $month }}" class="rounded-md border-gray-300">
<button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Filter</button></form>
<a href="{{ route('attendance.index') }}" class="text-indigo-600 hover:text-indigo-800">← Back</a>
</div>

<div class="grid grid-cols-4 gap-4 mb-6">
<div class="bg-white rounded-lg shadow p-6"><h3 class="text-sm text-gray-500 mb-2">Total Days</h3>
<p class="text-3xl font-bold text-indigo-600">{{ $stats['total_days'] }}</p></div>
<div class="bg-white rounded-lg shadow p-6"><h3 class="text-sm text-gray-500 mb-2">On Time</h3>
<p class="text-3xl font-bold text-green-600">{{ $stats['present'] }}</p></div>
<div class="bg-white rounded-lg shadow p-6"><h3 class="text-sm text-gray-500 mb-2">Late</h3>
<p class="text-3xl font-bold text-orange-600">{{ $stats['late'] }}</p></div>
<div class="bg-white rounded-lg shadow p-6"><h3 class="text-sm text-gray-500 mb-2">Total Hours</h3>
<p class="text-3xl font-bold text-blue-600">{{ $stats['total_hours'] }}</p></div>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden"><table class="w-full">
<thead class="bg-gray-50"><tr><th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase">Date</th>
<th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase">Day</th>
<th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase">Clock In</th>
<th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase">Clock Out</th>
<th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase">Duration</th>
<th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase">Status</th></tr></thead>
<tbody class="divide-y">@foreach($attendances as $att)
<tr><td class="px-6 py-4">{{ $att->date->format('M d, Y') }}</td>
<td class="px-6 py-4">{{ $att->date->format('l') }}</td>
<td class="px-6 py-4">{{ $att->clock_in }}</td>
<td class="px-6 py-4">{{ $att->clock_out ?? '-' }}</td>
<td class="px-6 py-4">{{ $att->duration_minutes ? floor($att->duration_minutes / 60).'h '.($att->duration_minutes % 60).'m' : '-' }}</td>
<td class="px-6 py-4"><span class="px-2 py-1 text-xs rounded font-semibold {{ $att->status === 'present' ? 'bg-green-100 text-green-800' : 'bg-orange-100 text-orange-800' }}">{{ ucfirst($att->status) }}</span></td>
</tr>@endforeach</tbody></table>
</div></div></div>
</x-app-layout>
