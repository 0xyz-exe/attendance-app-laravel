<?php
namespace App\Http\Controllers;
use App\Models\Attendance;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index()
    {
        $attendances = Attendance::with('user')->where('user_id', auth()->id())->latest('date')->paginate(20);
        $todayAttendance = Attendance::where('user_id', auth()->id())->whereDate('date', today())->first();
        
        return view('attendance.index', compact('attendances', 'todayAttendance'));
    }
    
    public function clockIn(Request $request)
    {
        $existing = Attendance::where('user_id', auth()->id())->whereDate('date', today())->first();
        if ($existing) return back()->with('error', 'Already clocked in today.');
        
        Attendance::create([
            'user_id' => auth()->id(),
            'date' => today(),
            'clock_in' => now()->format('H:i'),
            'status' => now()->format('H:i') > '09:00' ? 'late' : 'present',
        ]);
        
        return back()->with('success', 'Clocked in successfully.');
    }
    
    public function clockOut(Request $request)
    {
        $attendance = Attendance::where('user_id', auth()->id())->whereDate('date', today())->first();
        if (!$attendance) return back()->with('error', 'No clock-in record found.');
        if ($attendance->clock_out) return back()->with('error', 'Already clocked out.');
        
        $attendance->clock_out = now()->format('H:i');
        $attendance->calculateDuration();
        
        return back()->with('success', 'Clocked out successfully.');
    }
    
    public function report()
    {
        $month = request('month', now()->format('Y-m'));
        $attendances = Attendance::where('user_id', auth()->id())
            ->whereYear('date', substr($month, 0, 4))
            ->whereMonth('date', substr($month, 5, 2))
            ->orderBy('date')
            ->get();
        
        $stats = [
            'total_days' => $attendances->count(),
            'present' => $attendances->where('status', 'present')->count(),
            'late' => $attendances->where('status', 'late')->count(),
            'total_hours' => round($attendances->sum('duration_minutes') / 60, 1),
        ];
        
        return view('attendance.report', compact('attendances', 'stats', 'month'));
    }
    
    public function admin()
    {
        $date = request('date', today()->format('Y-m-d'));
        $attendances = Attendance::with('user')->whereDate('date', $date)->get();
        
        return view('attendance.admin', compact('attendances', 'date'));
    }
}
