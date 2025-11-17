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
}
