<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\DoctorSchedule;

class Doctor extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'specialization',
        'description',
    ];

    public function schedules()
    {
        return $this->hasMany(DoctorSchedule::class);
    }

    public function reviews()
    {
        return $this->hasMany(DoctorReview::class);
    }
}
