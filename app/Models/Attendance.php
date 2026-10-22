<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'date', 'clock_in', 'clock_out', 'duration_minutes', 'status', 'notes'];
    protected $casts = ['date' => 'date', 'clock_in' => 'datetime:H:i', 'clock_out' => 'datetime:H:i'];
    
    public function user() { return $this->belongsTo(User::class); }
    
    public function calculateDuration()
    {
        if ($this->clock_out) {
            $in = \Carbon\Carbon::parse($this->clock_in);
            $out = \Carbon\Carbon::parse($this->clock_out);
            $this->duration_minutes = $out->diffInMinutes($in);
            $this->save();
        }
    }
}
