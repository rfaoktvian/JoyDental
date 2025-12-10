@php
    /** @var \App\Models\Appointment $appt */
@endphp

<div class="col-12 col-md-6 col-lg-4 appt-card" data-clinic="{{ $appt->clinic->name }}"
    data-name="{{ Str::lower($appt->patient->name) }}">
    <div class="custom_card h-100 shadow-sm bg-white border border-1 border-mute">
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
                        {{ $appt->appointment_date->translatedFormat('l, d M Y') }} -
                        {{ $appt->appointment_time->format('H:i') }}
                    </span>
                </li>
                <li class="d-flex align-items-center" style="gap: 0.5rem;">
                    <i class="fa fa-hospital text-muted"></i>
                    <span>{{ $appt->clinic?->name }} - {{ $appt->clinic?->location }}</span>
                </li>
            </ul>
            @if($appt->order)
                <div class="mt-2">
                    <strong>Status Pembayaran:</strong><br>

                    @if($appt->order->isPaid())
                        <span class="badge bg-success mt-1">
                            <i class="fas fa-check-circle me-1"></i> Lunas
                        </span>

                    @elseif($appt->order->isPending())
                        <span class="badge bg-warning mt-1">
                            <i class="fas fa-clock me-1"></i> Menunggu Pembayaran
                        </span>

                        <div class="mt-2">
                            <a href="{{ route('payment.show', $appt->order) }}" class="btn btn-sm btn-primary w-100">
                                <i class="fas fa-credit-card me-1"></i> Bayar Sekarang
                            </a>
                        </div>

                    @else
                        <span class="badge bg-danger mt-1">
                            <i class="fas fa-times-circle me-1"></i> Gagal
                        </span>
                    @endif
                </div>
            @endif


            @include('partials.actions')
        </div>
    </div>
</div>
