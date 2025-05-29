<?php
namespace App\Enums;

enum AppointmentStatus: int
{
    case Upcoming = 1;   // Akan Datang
    case Completed = 2;   // Selesai
    case Canceled = 3;   // Dibatalkan

    public function label(): string
    {
        return match ($this) {
            self::Upcoming => 'upcoming',
            self::Completed => 'completed',
            self::Canceled => 'canceled',
        };
    }

    public static function fromLabel(string $label): self
    {
        return match ($label) {
            'upcoming' => self::Upcoming,
            'completed' => self::Completed,
            'canceled' => self::Canceled,
            default => throw new \ValueError("Unknown label [$label]"),
        };
    }
}
