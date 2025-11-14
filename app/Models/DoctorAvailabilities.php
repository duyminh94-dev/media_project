<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorAvailabilities extends Model
{
    use HasFactory;
    protected $fillable = [
        'doctor_id',
        'date',
        'start_time',
        'end_time',
        'slot_duration',
        'max_appointments',
        'is_available',
    ];

    public function doctor() {
        return $this->belongsTo(Doctor::class);
    }
}

