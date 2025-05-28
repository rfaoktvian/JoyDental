<div class="modal fade" id="scheduleModal-{{ $id }}" tabindex="-1" aria-labelledby="scheduleLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content shadow-sm border-0">
            <div class="modal-header bg-light border-bottom">
                <h5 class="modal-title fw-semibold">Jadwal Dr. {{ $name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="p-4">
                @include('partials.calendar', ['calendarId' => $id])

                @if ($schedules->count())
                    <div class="list-group mt-3">
                        @foreach ($schedules as $schedule)
                            @php
                                $start = \Carbon\Carbon::parse($schedule->time_from)->format('H:i');
                                $end = \Carbon\Carbon::parse($schedule->time_to)->format('H:i');
                            @endphp

                            <div
                                class="{{ $today == $schedule->day ? 'border-1 border-danger' : '' }} list-group-item d-flex justify-content-between align-items-center mb-2 rounded shadow-sm">
                                <div class="fw-semibold text-danger mb-1">
                                    <i class="fas fa-calendar-alt me-2"></i> {{ $schedule->day }}
                                    <div class="small text-muted">
                                        <i class="fas fa-clock me-2"></i> {{ $start }} - {{ $end }}
                                    </div>
                                </div>
                                <div class="small text-muted">{{ $schedule->polyclinic->name ?? '-' }}</div>
                                <div class="small text-muted">
                                    <i class="fas fa-hospital me-2"></i> {{ $schedule->polyclinic->location ?? '-' }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-muted text-center mt-4">Tidak ada jadwal tersedia.</p>
                @endif
            </div>
        </div>
    </div>
</div>
