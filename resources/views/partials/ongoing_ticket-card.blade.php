@php
    /** @var \App\Models\Appointment $appt */
    // Refresh order untuk memastikan data terbaru
    if ($appt->order) {
        $appt->load('order.payment');
    }
@endphp

<style>
    .bg-danger1{
        background: red;
    }
</style>

<div class="col-12 col-md-6 col-lg-4 appt-card" data-clinic="{{ $appt->clinic->name }}"
    data-name="{{ Str::lower($appt->patient->name) }}">
    <div class="custom_card h-100 shadow-sm bg-white border border-1 border-mute">
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
                        {{ $appt->appointment_date->translatedFormat('l, d M Y') }} -
                        {{ $appt->appointment_time->format('H:i') }}
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
            
            @if($appt->order)
                <div class="mt-2">
                    <strong>Status Pembayaran:</strong><br>
                    
                    @php
                        // Debug: tampilkan status real dari database
                        $orderStatus = $appt->order->status;
                        $paymentStatus = $appt->order->payment?->payment_status ?? 'no_payment';
                    @endphp

                    @if($appt->order->isPaid())
                        <span class="badge bg-success mt-1">
                            <i class="fas fa-check-circle me-1"></i> Lunas
                        </span>
                        <div class="text-success small mt-1">
                            Dibayar: {{ $appt->order->payment?->paid_at?->format('d M Y, H:i') ?? '-' }}
                        </div>

                    @elseif($appt->order->isPending())
                        <span class="badge bg-warning text-light mt-1">
                            <i class="fas fa-clock me-1"></i> Menunggu Pembayaran
                        </span>
                        <div class="mt-2">
                            <a href="{{ route('payment.show', $appt->order) }}" class="btn btn-sm btn-primary w-100">
                                <i class="fas fa-credit-card me-1"></i> Bayar Sekarang
                            </a>
                        </div>
                    @else
                        <span class="badge bg-danger1 mt-1">
                            <i class="fas fa-times-circle me-1"></i> Gagal
                        </span>
                    @endif
                </div>
            @endif

            @if ($appt->order && $appt->order->isPaid())
                {{-- Tombol hanya muncul jika PAID --}}
                @include('partials.actions')

            @elseif ($appt->order && $appt->order->isPending())
                {{-- Pending: boleh bayar --}}
                @include('partials.actions')

            @elseif ($appt->order && $appt->order->status === 'failed')
                {{-- GAGAL: TIDAK ADA TOMBOL --}}
                <div class="mt-2 text-danger small fw-semibold">
                    Tiket otomatis dibatalkan karena pembayaran gagal.
                </div>
            @endif
        </div>
    </div>
</div>