<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable = [
        'nik',
        'name',
        'specialization',
        'description',
        'photo',
    ];
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
    public function doctor()
    {
        return $this->hasOne(Doctor::class, 'nik', 'nik');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'nik', 'nik');
    }

    public function schedules()
    {
        return $this->hasMany(DoctorSchedule::class);
    }

    public function reviews()
    {
        return $this->hasMany(DoctorReview::class);
    }

    public function averageRating()
    {
        return $this->reviews()->avg('rating');
    }
}
