@extends('layouts.app')

@section('content')

<style>
    .bg-danger{
        --bs-bg-opacity: 1;
        background-color: #6b2c91 !important;    
    }
</style>

    <div class="container">
        <form id="appointmentForm" action="{{ route('janji-temu.store') }}" method="POST" class="needs-validation" novalidate>
            @csrf

            <div class="mb-4">
                <h2 class="fw-bold mb-1">Janji Temu Online!</h2>
                <p class="fw-light text-muted mb-0">
                    Janji temu adalah proses penjadwalan pertemuan antara pasien dan dokter
                    di fasilitas kesehatan untuk mendapatkan layanan medis sesuai kebutuhan.
                </p>
            </div>

            <hr class="my-3" style="opacity: 0.1;">

            <div class="card h-100 shadow-sm bg-white border border-1 border-mute mb-4">
                <div class="card-header bg-danger text-white fw-semibold">
                    <i class="fas fa-hospital me-2"></i> Pilih Layanan
                </div>
                <div class="card-body">
                    <label for="polyclinic" class="form-label">Daftar Layanan <span class="text-danger">*</span></label>
                    <select class="form-select" id="polyclinic" name="polyclinic" required>
                        <option value="" disabled selected>Pilih Layanan</option>
                        @foreach ($polyclinics as $poly)
                            <option value="{{ $poly->id }}">
                                {{ $poly->name }} ({{ $poly->location }})
                            </option>
                        @endforeach
                    </select>
                    <div class="form-text">Pilih layanan yang akan Anda perlukan</div>
                </div>
            </div>

            <div class="card h-100 shadow-sm bg-white border border-1 border-mute mb-4">
                <div class="card-header bg-danger text-white fw-semibold">
                    <i class="fas fa-user-md me-2"></i> Pilih Dokter & Jadwal
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label for="doctor" class="form-label fw-semibold">
                                Dokter yang Tersedia <span class="text-danger">*</span>
                            </label>
                            <select class="form-select" id="doctor" name="doctor" required disabled>
                                <option value="" disabled selected>Pilih Dokter</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="visit_date" class="form-label fw-semibold">
                                Tanggal Kunjungan <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="visit_date" name="visit_date"
                                placeholder="Pilih tanggal..." required disabled>
                        </div>
                    </div>

                    <div id="slot-wrap" class="row g-2 my-3"></div>
                </div>
            </div>

            <div class="card h-100 shadow-sm bg-white border border-1 border-mute mb-4">
                <div class="card-header bg-danger text-white fw-semibold">
                    <i class="fas fa-user me-2"></i> Identitas Pasien
                </div>
                <div class="card-body">
                    <div class="form-check form-switch mb-4">
                        <input class="form-check-input" type="checkbox" id="otherPatientSwitch">
                        <label class="form-check-label" for="otherPatientSwitch">Pasien Lain</label>
                    </div>
                    <div id="selfPatient">
                        <div class="mb-3">
                            <label class="form-label">Nama Pasien</label>
                            <input type="text" class="form-control" value="{{ $user->name }}" disabled>
                        </div>
                    </div>
                    <div id="otherPatient" class="d-none">
                        <div class="mb-3">
                            <label for="other_name" class="form-label">Nama Pasien</label>
                            <input type="text" name="other_name" id="other_name" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="other_email" class="form-label">Email</label>
                            <input type="email" name="other_email" id="other_email" class="form-control">
                        </div>
                    </div>

                    <label class="form-label fw-semibold mt-4">Keluhan <span class="text-danger">*</span></label>
                    <textarea class="form-control" name="complaint" rows="4" required></textarea>
                </div>
            </div>

            <div class="card h-100 shadow-sm bg-white border border-1 border-mute mb-4">
                <div class="card-header bg-danger text-white fw-semibold">
                    <i class="fas fa-credit-card me-2"></i> Cara Bayar
                </div>
                <div class="card-body">
                    <label for="payment_method" class="form-label">Metode Pembayaran
                        <span class="text-danger">*</span>
                    </label>
                    <select class="form-select" id="payment_method" name="payment_method" required>
                        <option value="" disabled selected>Pilih Metode Pembayaran</option>
                        <option value="cash">Tunai</option>
                        <option value="credit_card">Kartu Kredit</option>
                        <option value="e_wallet">E‐Wallet</option>
                        {{-- dll… --}}
                    </select>
                </div>
            </div>

            <div class="d-flex justify-content-end mb-5">
                <button id="submitBtn" type="submit" class="btn btn-danger" disabled>
                    <i class="fas fa-check-circle me-2"></i> Konfirmasi Janji Temu
                </button>
            </div>
        </form>
    </div>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" />
    <style>
        .slot-disabled {
            background: #f8d7da !important;
            color: #842029 !important;
            cursor: not-allowed;
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const polyclinicSelect = document.getElementById('polyclinic');
            const doctorSelect = document.getElementById('doctor');
            const visitDateInput = document.getElementById('visit_date');
            const slotWrap = document.getElementById('slot-wrap');
            const submitBtn = document.getElementById('submitBtn');

            let flatpickrInstance = null;

            const dayMap = {
                'Minggu': 0,
                'Senin': 1,
                'Selasa': 2,
                'Rabu': 3,
                'Kamis': 4,
                'Jumat': 5,
                'Sabtu': 6
            };

            polyclinicSelect.addEventListener('change', function() {
                const polyId = this.value;
                if (!polyId) return;

                doctorSelect.innerHTML = '<option value="" disabled selected>Loading…</option>';
                doctorSelect.disabled = true;
                visitDateInput.value = '';
                resetFlatpickr();
                slotWrap.innerHTML = '';
                submitBtn.disabled = true;

                fetch(`/polyclinic/${polyId}/doctors`)
                    .then(res => res.json())
                    .then(doctors => {
                        if (!doctors.length) {
                            doctorSelect.innerHTML =
                                `<option value="" disabled>— Tidak ada dokter —</option>`;
                            doctorSelect.disabled = true;
                            return;
                        }

                        let html = `<option value="" disabled selected>Pilih Dokter</option>`;
                        doctors.forEach(doc => {
                            html += `
                                <option 
                                    value="${doc.id}"
                                    data-specialization="${doc.specialization}"
                                    data-photo="${doc.photo}"
                                    data-schedules='${JSON.stringify(doc.schedules)}'
                                >
                                    ${doc.name} — ${doc.specialization}
                                </option>`;
                        });
                        doctorSelect.innerHTML = html;
                        doctorSelect.disabled = false;
                    })
                    .catch(err => {
                        console.error('Error fetching doctors:', err);
                        doctorSelect.innerHTML =
                            `<option value="" disabled>Error memuat dokter</option>`;
                        doctorSelect.disabled = true;
                    });
            });

            doctorSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                if (!selectedOption || !selectedOption.value) {
                    resetFlatpickr();
                    slotWrap.innerHTML = '';
                    submitBtn.disabled = true;
                    return;
                }

                let rawSchedules;
                try {
                    rawSchedules = JSON.parse(selectedOption.dataset.schedules);
                } catch (e) {
                    rawSchedules = [];
                }

                if (!Array.isArray(rawSchedules) || rawSchedules.length === 0) {
                    noValidSchedule();
                    return;
                }


                submitBtn.disabled = true;

                const scheduleMap = {};
                rawSchedules.forEach(r => {
                    const idx = dayMap[r.day];
                    if (typeof idx === 'number' && idx >= 0 && idx <= 6) {
                        scheduleMap[idx] = {
                            from: r.time_from,
                            to: r.time_to,
                            max_capacity: r.max_capacity || null
                        };
                    }
                });

                initFlatpickr(scheduleMap);
            });

            function resetFlatpickr() {
                if (flatpickrInstance) {
                    flatpickrInstance.destroy();
                    flatpickrInstance = null;
                }
                visitDateInput.value = '';
                visitDateInput.disabled = true;
            }

            function initFlatpickr(scheduleMap) {
                const allowedDayIndexes = Object.keys(scheduleMap).map(n => parseInt(n, 10));
                const disableDays = [0, 1, 2, 3, 4, 5, 6]
                    .filter(d => !allowedDayIndexes.includes(d));

                resetFlatpickr();

                flatpickrInstance = flatpickr(visitDateInput, {
                    dateFormat: 'Y-m-d',
                    minDate: 'today',
                    disable: [
                        function(date) {
                            return disableDays.includes(date.getDay());
                        }
                    ],
                    onReady: function() {
                        visitDateInput.disabled = false;
                    },
                    onChange: function(selectedDates) {
                        slotWrap.innerHTML = '';

                        if (!selectedDates.length) {
                            submitBtn.disabled = true;
                            return;
                        }
                        const picked = selectedDates[0];
                        const weekday = picked.getDay();

                        const rule = scheduleMap[weekday];
                        if (!rule) {
                            return;
                        }

                        buildSlots(rule.from, rule.to);
                    }
                });
            }

            function buildSlots(from, to) {
                function toMinutes(str) {
                    const [hh, mm] = str.split(':').map(Number);
                    return hh * 60 + mm;
                }

                function pad(n) {
                    return n < 10 ? '0' + n : '' + n;
                }

                const startMin = toMinutes(from);
                const endMin = toMinutes(to);
                let current = startMin;
                let idx = 0;

                while (current + 29 <= endMin) {
                    const h = Math.floor(current / 60);
                    const m = current % 60;
                    const slotLabel = `${pad(h)}:${pad(m)}`;

                    const col = document.createElement('div');
                    col.className = 'col-4 my-1';

                    col.innerHTML = `
                        <input 
                            type="radio" 
                            class="btn-check" 
                            name="time" 
                            id="slot-${idx}" 
                            value="${slotLabel}"
                        >
                        <label 
                            for="slot-${idx}" 
                            class="btn w-100 btn-outline-secondary text-center"
                        >
                            <div class="fw-semibold">${slotLabel}</div>
                        </label>`;

                    slotWrap.appendChild(col);

                    col.querySelector('input[type="radio"]').addEventListener('change', function() {
                        submitBtn.disabled = false;
                    });

                    current += 30;
                    idx++;
                }
            }

            function noValidSchedule() {
                visitDateInput.disabled = true;
                resetFlatpickr();
                slotWrap.innerHTML = `
                    <div class="alert alert-warning text-center mt-2 mb-2">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Dokter ini tidak memiliki jadwal praktik.
                    </div>`;
                submitBtn.disabled = true;
            }


            document.getElementById('otherPatientSwitch').addEventListener('change', function() {
                const selfDiv = document.getElementById('selfPatient');
                const otherDiv = document.getElementById('otherPatient');
                if (this.checked) {
                    selfDiv.classList.add('d-none');
                    otherDiv.classList.remove('d-none');
                } else {
                    selfDiv.classList.remove('d-none');
                    otherDiv.classList.add('d-none');
                }
            });
        });
    </script>
@endsection
