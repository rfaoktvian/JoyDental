@php
    use Illuminate\Support\Carbon;
    $today = ucfirst(Carbon::now()->locale('id')->translatedFormat('l'));
    $schedule = $doctor->schedules ?? collect();
@endphp

@include('partials.calendar', ['calendarId' => 'jadwalDokter'])

@if ($schedule->count())
    <div class="list-group mt-3">
        @foreach ($schedule as $data)
            @php
                $start = \Carbon\Carbon::parse($data->time_from)->format('H:i');
                $end = \Carbon\Carbon::parse($data->time_to)->format('H:i');
            @endphp

            <div
                class="{{ $today == $data->day ? 'border-2 border-danger bg-light' : '' }} list-group-item d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-2 rounded shadow-sm p-3">
                <div class="fw-semibold text-danger mb-2 mb-md-0">
                    <i class="fas fa-calendar-alt me-2"></i> {{ $data->day }}
                    @if ($today == $data->day)
                        <span class="badge bg-danger ms-2">Hari Ini</span>
                    @endif
                    <div class="small text-muted mt-1">
                        <i class="fas fa-clock me-2"></i> {{ $start }} - {{ $end }}
                    </div>
                </div>
                <div class="d-flex flex-column align-items-md-end text-md-end">
                    <div class="small text-dark mb-1">
                        <i class="fas fa-clinic-medical me-2"></i>{{ $data->polyclinic->name ?? '-' }}
                    </div>
                    <div class="small text-muted">
                        <i class="fas fa-map-marker-alt me-2"></i>{{ $data->polyclinic->location ?? '-' }}
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@else
    <div class="text-center mt-4 py-4">
        <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
        <p class="text-muted">Tidak ada jadwal tersedia untuk dokter ini.</p>
    </div>
@endif
