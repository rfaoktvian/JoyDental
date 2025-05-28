<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DoctorSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'doctor_id',
        'day',
        'time_from',
        'time_to',
        'max_capacity',
        'polyclinic_id',
    ];

    public function polyclinic()
    {
        return $this->belongsTo(Polyclinic::class);
    }
}
