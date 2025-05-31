<div class="d-grid gap-2 mt-3">
    @if ($appt->status === \App\Enums\AppointmentStatus::Upcoming)
        <div class="d-flex flex-wrap gap-2 justify-content-center">

            @can('update', $appt)
                <form action="{{ route('doctor.antrian.complete', $appt) }}" method="POST">
                    @csrf
                    <button class="btn btn-sm btn-outline-success flex-grow-1">
                        Selesai
                    </button>
                </form>
            @endcan

            <form action="{{ route('doctor.antrian.cancel', $appt) }}" method="POST">
                @csrf
                <button class="btn btn-sm btn-outline-danger flex-grow-1">
                    Batalkan
                </button>
            </form>

            <a class="btn btn-sm btn-outline-primary flex-grow-1" hx-get="{{ route('antrian.reschedule', $appt) }}"
                hx-target="#modalBody" hx-trigger="click"
                hx-on="htmx:afterOnLoad: (() => {const modalTitle = document.getElementById('modalTitle'); if(modalTitle){modalTitle.outerHTML = '<h5 class=&quot;modal-title fw-bold&quot; id=&quot;modalTitle&quot;>Jadwal Ulang Tiket</h5>';}})()"
                hx-indicator="#modalBody .spinner-border" data-bs-toggle="modal" data-bs-target="#commonModal">
                Jadwal&nbsp;Ulang
            </a>

            <a class="btn btn-sm btn-outline-secondary flex-grow-1" data-bs-toggle="modal"
                data-bs-target="#rescheduleModal">
                Cetak
            </a>
        </div>
    @elseif($appt->status === \App\Enums\AppointmentStatus::Completed)
        <div class="text-success text-center small">Telah selesai</div>
        <div class="d-flex justify-content-center">
            <a class="btn btn-sm btn-outline-secondary flex-grow-1" data-bs-toggle="modal"
                data-bs-target="#rescheduleModal">
                Cetak
            </a>
        </div>
    @else
        <div class="text-danger text-center small">Dibatalkan</div>
    @endif
</div>
