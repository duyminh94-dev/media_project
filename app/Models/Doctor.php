<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    // doctors table by convention
    protected $fillable = [
        'user_id',
        'specialty_id',
        'city_id',
        'degree',
        'experience_years',
        'bio',
        'available_days', // JSON
    ];

    // make available_days usable as PHP array automatically
    protected $casts = [
        'available_days' => 'array',
        'experience_years' => 'integer',
    ];

    // Relations kept ONLY for the 3 models you requested
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function specialty()
    {
        return $this->belongsTo(Specialty::class, 'specialty_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function availabilities()
    {
        return $this->hasMany(DoctorAvailabilities::class, 'doctor_id');
    }

    // 1. Lấy tất cả lịch làm việc của bác sĩ (đã sắp xếp theo ngày)
    public function getAllAvailabilities()
    {
        return $this->availabilities()
            ->orderBy('date', 'asc')
            ->orderBy('start_time', 'asc')
            ->get();
    }

    // 2. Kiểm tra bác sĩ có làm việc ngày đó không
    public function isAvailableOn($date)
    {
        return $this->availabilities()
            ->where('date', $date)
            ->where('is_available', true)
            ->exists();
    }

    // 3. Lấy lịch sắp tới của tuần sau (7 ngày tiếp theo)
    public function getNextWeekAvailabilities()
    {
        $today = now()->startOfDay();
        $nextWeek = now()->addDays(7)->endOfDay();

        return $this->availabilities()
            ->where('is_available', true)
            ->whereBetween('date', [$today, $nextWeek])
            ->orderBy('date', 'asc')
            ->orderBy('start_time', 'asc')
            ->get();
    }

    // Bonus: Lấy lịch làm việc cho ngày cụ thể
    public function getAvailabilityForDate($date)
    {
        return $this->availabilities()
            ->where('date', $date)
            ->first();
    }

    // Bonus: Lấy các ngày còn slot trống trong tuần tới
    public function getAvailableDatesNextWeek()
    {
        return $this->getNextWeekAvailabilities()
            ->pluck('date')
            ->unique()
            ->values();
    }
}
