<?php
namespace App\Models;

use App\Enums\AppointmentStatus;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Appointment extends Model
{
    protected $fillable = [
        'queue_number',
        'booking_code',
        'user_id',
        'doctor_id',
        'doctor_schedule_id',
        'status',
        'appointment_date',
        'appointment_time',
        'payment_method',
        'consultation_fee'
    ];

    protected $casts = [
        'appointment_date' => 'date',
        'appointment_time' => 'datetime:H:i',
        'status' => AppointmentStatus::class,
    ];

    public function patient(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }
    public function schedule(): BelongsTo
    {
        return $this->belongsTo(DoctorSchedule::class, 'doctor_schedule_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function clinic(): \Illuminate\Database\Eloquent\Relations\HasOneThrough
    {
        return $this->hasOneThrough(
            Polyclinic::class,
            DoctorSchedule::class,
            'id',
            'id',
            'doctor_schedule_id',
            'polyclinic_id'
        );
    }

    protected function badgeColor(): Attribute
    {
        return Attribute::get(fn() => match ($this->status) {
            AppointmentStatus::Upcoming => 'primary',
            AppointmentStatus::Completed => 'success',
            AppointmentStatus::Canceled => 'danger',
        });
    }

    protected static function booted()
    {
        static::creating(function ($appt) {
            $appt->booking_code = $appt->booking_code ?: strtoupper(Str::random(8));
            $appt->queue_number = $appt->queue_number ?: self::nextQueue($appt->doctor_id, $appt->appointment_date);
        });
    }

    public static function nextQueue(int $doctorId, \DateTimeInterface $date): string
    {
        $last = self::where('doctor_id', $doctorId)
            ->whereDate('appointment_date', $date)
            ->max('queue_number');

        return sprintf('%03d', ($last ? intval($last) : 0) + 1);
    }

}
