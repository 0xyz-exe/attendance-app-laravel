<x-app-layout>
<x-slot name="header"><h2 class="font-semibold text-xl text-gray-800">Attendance</h2></x-slot>
<div class="py-12"><div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
@if(session('success'))<div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">{{ session('success') }}</div>@endif
@if(session('error'))<div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">{{ session('error') }}</div>@endif

<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
<div class="bg-white rounded-lg shadow p-6"><h3 class="text-lg font-semibold mb-4">Today's Attendance</h3>
<p class="text-sm text-gray-600 mb-4">{{ now()->format('l, F d, Y') }}</p>
@if($todayAttendance)
<div class="space-y-3"><div class="flex justify-between"><span class="text-gray-600">Clock In:</span>
<span class="font-semibold">{{ $todayAttendance->clock_in }}</span></div>
@if($todayAttendance->clock_out)
<div class="flex justify-between"><span class="text-gray-600">Clock Out:</span>
<span class="font-semibold">{{ $todayAttendance->clock_out }}</span></div>
<div class="flex justify-between"><span class="text-gray-600">Duration:</span>
<span class="font-semibold">{{ floor($todayAttendance->duration_minutes / 60) }}h {{ $todayAttendance->duration_minutes % 60 }}m</span></div>
@else
<form method="POST" action="{{ route('attendance.clockOut') }}">@csrf
<button type="submit" class="w-full px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Clock Out</button></form>
@endif
<div class="flex justify-between"><span class="text-gray-600">Status:</span>
<span class="px-2 py-1 text-xs rounded font-semibold {{ $todayAttendance->status === 'present' ? 'bg-green-100 text-green-800' : 'bg-orange-100 text-orange-800' }}">{{ ucfirst($todayAttendance->status) }}</span></div>
</div>
@else
<form method="POST" action="{{ route('attendance.clockIn') }}">@csrf
<button type="submit" class="w-full px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 font-semibold">Clock In</button></form>
@endif
</div>

<div class="bg-white rounded-lg shadow p-6"><h3 class="text-lg font-semibold mb-4">Quick Stats</h3>
<div class="space-y-3"><div class="flex justify-between"><span class="text-gray-600">This Month:</span>
<span class="font-semibold">{{ $attendances->where('date', '>=', now()->startOfMonth())->count() }} days</span></div>
<div class="flex justify-between"><span class="text-gray-600">On Time:</span>
<span class="font-semibold">{{ $attendances->where('status', 'present')->where('date', '>=', now()->startOfMonth())->count() }}</span></div>
<div class="flex justify-between"><span class="text-gray-600">Late:</span>
<span class="font-semibold">{{ $attendances->where('status', 'late')->where('date', '>=', now()->startOfMonth())->count() }}</span></div>
<a href="{{ route('attendance.report') }}" class="block mt-4 text-center px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">View Full Report</a>
</div></div>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden"><div class="px-6 py-4 border-b"><h3 class="font-semibold">Recent Attendance</h3></div>
<table class="w-full"><thead class="bg-gray-50"><tr><th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase">Date</th>
<th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase">Clock In</th>
<th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase">Clock Out</th>
<th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase">Duration</th>
<th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase">Status</th></tr></thead>
<tbody class="divide-y">@foreach($attendances as $att)
<tr><td class="px-6 py-4">{{ $att->date->format('M d, Y') }}</td>
<td class="px-6 py-4">{{ $att->clock_in }}</td>
<td class="px-6 py-4">{{ $att->clock_out ?? '-' }}</td>
<td class="px-6 py-4">{{ $att->duration_minutes ? floor($att->duration_minutes / 60).'h '.($att->duration_minutes % 60).'m' : '-' }}</td>
<td class="px-6 py-4"><span class="px-2 py-1 text-xs rounded font-semibold {{ $att->status === 'present' ? 'bg-green-100 text-green-800' : 'bg-orange-100 text-orange-800' }}">{{ ucfirst($att->status) }}</span></td>
</tr>@endforeach</tbody></table>
<div class="px-6 py-4">{{ $attendances->links() }}</div>
</div></div></div>
</x-app-layout>
