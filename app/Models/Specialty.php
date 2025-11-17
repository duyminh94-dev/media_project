<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Specialty extends Model
{
    use HasFactory;

    // specialties table by convention
    protected $fillable = ['name', 'description'];

    // A specialty has many doctors
    public function doctors()
    {
        return $this->hasMany(Doctor::class, 'specialty_id');
    }
}
