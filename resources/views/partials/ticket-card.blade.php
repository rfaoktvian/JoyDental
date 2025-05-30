@php
    /** @var \App\Models\Appointment $appt */
@endphp

<div class="col-12 col-md-6 col-lg-4 appt-card" data-clinic="{{ $appt->clinic->name }}"
    data-name="{{ Str::lower($appt->patient->name) }}">
    <div class="card h-100 shadow-sm bg-white border border-1 border-mute">
        <div class="card-body small">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <div class="d-flex align-items-center">
                    <h6 class="fw-semibold px-2 py-1 rounded mb-0"
                        style="background-color: #f1f1f1; display: inline-block;">
                        {{ $appt->booking_code }}
                    </h6>
                </div>
                <div>
                    <span class="badge bg-{{ $appt->badgeColor }}-subtle text-{{ $appt->badgeColor }} px-2 py-1"
                        style="font-size: 0.95em; display: inline-block;">
                        {{ ucfirst($appt->status->label()) }}
                    </span>
                </div>
            </div>

            @if (Auth::check() && (Auth::user()->role == 'admin' || Auth::user()->role == 'doctor'))
                <ul class="list-unstyled mt-2 mb-2">
                    <li class="d-flex align-items-center" style="gap: 0.5rem;">
                        <i class="fas fa-user"></i>
                        <span>{{ $appt->patient->name }}</span>
                    </li>
                    <li class="d-flex align-items-center" style="gap: 0.5rem;">
                        <i class="fas fa-envelope"></i>
                        <span>{{ $appt->patient->email }}</span>
                    </li>
                    @if ($appt->patient->phone)
                        <li class="d-flex align-items-center" style="gap: 0.5rem;">
                            <i class="fas fa-phone"></i>
                            <span>{{ $appt->patient->phone }}</span>
                        </li>
                    @endif
                    @if ($appt->patient->address)
                        <li class="d-flex align-items-center" style="gap: 0.5rem;">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>{{ $appt->patient->address }}</span>
                        </li>
                    @endif
                </ul>
            @endif
            <ul class="list-unstyled mb-3">
                <li class="d-flex align-items-center" style="gap: 0.5rem;">
                    <i class="fas fa-user-md"></i>
                    <span>{{ $appt->doctor->name }}</span>
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
            @include('partials.actions')
        </div>
    </div>
</div>
