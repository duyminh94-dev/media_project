<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'specialty_id',
        'city_id',
        'degree',
        'bio',
        'experience_years',
        'available_days',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function specialty() {
        return $this->belongsTo(Specialty::class);
    }

    public function city() {
        return $this->belongsTo(City::class);
    }

    public function appointments() {
        return $this->hasMany(Appointment::class);
    }
    public function availabilities() {
        return $this->hasMany(DoctorAvailabilities::class);
    }
}
