<div class="d-flex gap-2">
    @if ($appt->status === \App\Enums\AppointmentStatus::Upcoming)
        <form action="{{ route('doctor.antrian.complete', $appt) }}" method="POST">@csrf
            <button class="btn btn-sm btn-outline-success">Selesai</button>
        </form>
        <form action="{{ route('doctor.antrian.cancel', $appt) }}" method="POST">@csrf
            <button class="btn btn-sm btn-outline-danger">Batalkan</button>
        </form>
    @elseif($appt->status === \App\Enums\AppointmentStatus::Completed)
        <span class="text-success small">Telah selesai</span>
    @elseif($appt->status === \App\Enums\AppointmentStatus::Canceled)
        <span class="text-danger small">Dibatalkan</span>
    @endif
</div>
