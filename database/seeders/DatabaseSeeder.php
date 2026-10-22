<?php
namespace Database\Seeders;
use App\Models\{User, Attendance};
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::factory()->create(['name' => 'John Doe', 'email' => 'demo@example.com']);
        
        // Past 10 days attendance
        for ($i = 9; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $clockIn = $date->copy()->setTime(rand(7, 9), rand(0, 59));
            $clockOut = $clockIn->copy()->addHours(rand(8, 9))->addMinutes(rand(0, 59));
            
            Attendance::create([
                'user_id' => $user->id,
                'date' => $date->toDateString(),
                'clock_in' => $clockIn->format('H:i'),
                'clock_out' => $clockOut->format('H:i'),
                'duration_minutes' => $clockOut->diffInMinutes($clockIn),
                'status' => $clockIn->format('H:i') > '09:00' ? 'late' : 'present',
            ]);
        }
    }
}
