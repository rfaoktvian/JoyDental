@php
    /** @var \App\Models\Appointment $appt */
@endphp

<div class="col-12 col-md-6 col-lg-4 appt-card" data-clinic="{{ $appt->clinic->name }}"
    data-name="{{ Str::lower($appt->patient->name) }}">
    <div class="card h-100 shadow-sm bg-white border border-1 border-mute">
        <div class="p-2" style="background:#d32f2f;border-radius:.35rem .35rem 0 0;">
            <div class="text-white">
                <div class="d-flex align-items-center" style="gap: 0.5rem;">
                    <div class="badge bg-light text-danger" style="font-size:1.1rem;">
                        {{ $appt->queue_number }}
                    </div>
                    <div class="fw-semibold">Kode Antrian</div>
                </div>
            </div>
        </div>
        <div class="card-body small">
            <ul class="list-unstyled mb-3">
                <div>
                    <h6 class="fw-semibold px-2 py-1 rounded" style="background-color: #f1f1f1; display: inline-block;">
                        {{ $appt->booking_code }}
                    </h6>
                </div>
                <li class="d-flex align-items-center" style="gap: 0.5rem;">
                    <i class="fas fa-user-md"></i>
                    <span>{{ $appt->doctor?->name }}</span>
                </li>
                <li class="d-flex align-items-center" style="gap: 0.5rem;">
                    <i class="fa fa-clock text-muted"></i>
                    <span>
                        {{ $appt->appointment_time->format('H:i') }},
                        {{ $appt->appointment_date->format('d M Y') }}
                    </span>
                </li>
                <li class="d-flex align-items-center" style="gap: 0.5rem;">
                    <i class="fa fa-hospital text-muted"></i>
                    <span>{{ $appt->clinic?->name }} - {{ $appt->clinic?->location }}</span>
                </li>
            </ul>
            <div class="mb-2 text-muted small">
                Dibuat: {{ $appt->created_at->format('d M Y, H:i') }}
            </div>
            @include('partials.actions')
        </div>
    </div>
</div>
