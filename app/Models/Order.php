<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

class Order extends Model
{
    protected $fillable = [
        'appointment_id',
        'user_id',
        'order_code',
        'amount',
        'status',
        'snap_token',
        'midtrans_order_id', 
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    protected static function booted()
    {
        static::creating(function ($order) {
            if (empty($order->order_code)) {
                $order->order_code = 'ORD-' . strtoupper(Str::random(10));
            }
        });
    }

    public function appointment(): BelongsTo
    {
        return $this->belongsTo(Appointment::class);
    }

    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }

    public function isPaid(): bool
    {
        return $this->status === 'paid';
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isFailed(): bool
    {
        return in_array($this->status, ['failed', 'expired']);
    }
}