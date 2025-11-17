<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    // cities table by convention
    protected $fillable = ['name'];

    // A city has many doctors
    public function doctors()
    {
        return $this->hasMany(Doctor::class, 'city_id');
    }
}
