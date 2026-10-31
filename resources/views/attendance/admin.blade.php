<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800">Admin Attendance Monitor</h2>
            <a href="{{ route('attendance.index') }}" class="text-sm text-indigo-600 hover:text-indigo-800">← Back to My Attendance</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white p-6 rounded-lg shadow flex flex-wrap justify-between items-center gap-4">
                <div>
                    <h3 class="font-bold text-gray-900">Daily Presence Log</h3>
                    <p class="text-sm text-gray-500">Inspecting company employee attendance logs for {{ \Carbon\Carbon::parse($date)->format('F d, Y') }}</p>
                </div>
                <form method="GET" class="flex gap-2">
                    <input type="date" name="date" value="{{ $date }}" class="rounded-md border-gray-300 text-sm">
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white text-sm rounded hover:bg-indigo-700">Filter Date</button>
                </form>
            </div>

            <div class="bg-white rounded-lg shadow overflow-hidden">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b">
                        <tr>
                            <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase">Employee</th>
                            <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase">Clock In</th>
                            <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase">Clock Out</th>
                            <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase">Work Hours</th>
                            <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse($attendances as $att)
                        <tr>
                            <td class="px-6 py-4">
                                <div class="font-medium text-gray-900">{{ $att->user->name }}</div>
                                <div class="text-xs text-gray-500">{{ $att->user->email }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm">{{ $att->clock_in ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm">{{ $att->clock_out ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm">{{ $att->duration_minutes ? floor($att->duration_minutes / 60).'h '.($att->duration_minutes % 60).'m' : '-' }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 text-xs rounded font-semibold {{ $att->status === 'present' ? 'bg-green-100 text-green-800' : 'bg-orange-100 text-orange-800' }}">
                                    {{ ucfirst($att->status) }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-500">No attendance entries recorded for this date.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
