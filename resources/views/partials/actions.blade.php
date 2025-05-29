<div class="d-flex flex-column align-items-end justify-content-center gap-2">
    @if ($appt->status === \App\Enums\AppointmentStatus::Upcoming)
        <div class="d-flex gap-2">
            @unless (Auth::check() && Auth::user()->role !== 'admin' && Auth::user()->role !== 'doctor')
                <form action="{{ route('doctor.antrian.complete', $appt) }}" method="POST">
                    @csrf
                    <button class="btn btn-sm btn-outline-success">Selesai</button>
                </form>
            @endunless
            <form action="{{ route('doctor.antrian.cancel', $appt) }}" method="POST">
                @csrf
                <button class="btn btn-sm btn-outline-danger">Batalkan</button>
            </form>
            <a href="" class="btn btn-sm btn-outline-primary">Jadwal Ulang</a>
            <a href="" target="_blank" class="btn btn-sm btn-outline-secondary">Cetak</a>
        </div>
    @elseif($appt->status === \App\Enums\AppointmentStatus::Completed)
        <div class="d-flex gap-2">
            <span class="text-success small align-self-center">Telah selesai</span>
            <a href="" target="_blank" class="btn btn-sm btn-outline-secondary">Cetak</a>
        </div>
    @elseif($appt->status === \App\Enums\AppointmentStatus::Canceled)
        <span class="text-danger small align-self-center">Dibatalkan</span>
    @endif
</div>
