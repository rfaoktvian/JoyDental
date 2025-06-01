@php
    $slots = ['09:00', '10:00', '11:00', '13:00', '14:00', '15:00'];
@endphp

<div class="container">
    <div class="row align-items-center mb-0">
        <dt class="col-4 text-muted mb-0">Kode Booking</dt>
        <dd class="col-8 fw-bold mb-0">{{ $appt->booking_code }}</dd>

        <dt class="col-4 text-muted mb-1">Poliklinik</dt>
        <dd class="col-8 mb-1">{{ $appt->clinic->name }}</dd>

        <dt class="col-4 text-muted mb-1">Dokter</dt>
        <dd class="col-8 mb-1">{{ $appt->doctor->name }}</dd>

        <dt class="col-4 text-muted mb-1">Jadwal</dt>
        <dd class="col-8 mb-1">
            {{ $appt->appointment_date->translatedFormat('l, d M Y') }} - {{ $appt->appointment_time->format('H:i') }}
        </dd>
    </div>
    <form method="POST" action="{{ route('antrian.reschedule.simpan', $appt) }}">
        @csrf
        @method('PATCH')

        <input type="hidden" name="doctor_id" value="{{ $appt->doctor_id }}">

        <div id="ubahJadwalForm">
            <label class="form-label">Tanggal</label>
            <input id="pick-date" type="text" class="form-control" name="date" required>

            <label class="form-label mt-3 d-block">Sesi Waktu Tersedia</label>
            <div id="slot-wrap" class="row g-2 mb-3"></div>

            <div class="mb-3">
                <label class="form-label">Alasan Penjadwalan Ulang <small class="text-muted">(opsional)</small></label>
                <select name="reason" class="form-select">
                    <option value="" selected>Pilih alasan</option>
                    <option value="busy">Kesibukan mendadak</option>
                    <option value="sick">Sakit</option>
                    <option value="other">Lain-lain</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="form-label">Catatan <small class="text-muted">(opsional)</small></label>
                <textarea name="note" rows="3" class="form-control" placeholder="Tambahkan catatan…"></textarea>
            </div>
        </div>

        <div class="text-end">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
            <button id="rescheduleSubmit" class="btn btn-danger text-white" disabled>
                Konfirmasi
            </button>
        </div>
    </form>
</div>

<script>
    initReschedule();

    window._activeFlatpickr = null;

    function noValidSc() {
        return window.rescheduleReady ?? false;
    }

    function noValidSchedule() {
        document.getElementById('rescheduleSubmit').style.display = 'none';
        document.getElementById('ubahJadwalForm').innerHTML =
            '<div class="alert alert-warning text-center mt-2 mb-2">Tidak bisa ubah jadwal</div>';
    }

    function initReschedule() {
        const doctorId = {{ $appt->doctor_id }};

        if (window._activeFlatpickr) {
            window._activeFlatpickr.destroy();
            window._activeFlatpickr = null;
        }

        const dayMap = {
            'Minggu': 0,
            'Senin': 1,
            'Selasa': 2,
            'Rabu': 3,
            'Kamis': 4,
            'Jumat': 5,
            'Sabtu': 6
        };

        fetch(`/api/doctor/${doctorId}/schedule`)
            .then(r => r.json())
            .then(raw => {

                const schedule = raw.map(s => ({
                    dayIdx: dayMap[s.day] ?? -1,
                    from: s.from.slice(0, 5),
                    to: s.to.slice(0, 5)
                })).filter(s => s.dayIdx >= 0);

                if (!schedule.length) {
                    noValidSchedule();
                    return;
                }

                const disableDays = [0, 1, 2, 3, 4, 5, 6]
                    .filter(d => !schedule.some(s => s.dayIdx === d));

                window._activeFlatpickr = flatpickr('#pick-date', {
                    dateFormat: 'Y-m-d',
                    minDate: 'today',
                    disable: [d => disableDays.includes(d.getDay())],
                    onChange: d => buildSlots(d, schedule)
                });
            })
            .catch(() => {
                noValidSchedule();
            });
    }

    function buildSlots(selectedDates, schedule) {
        const wrap = document.getElementById('slot-wrap');
        wrap.innerHTML = '';
        if (!selectedDates.length) return;

        const rule = schedule.find(s => s.dayIdx === selectedDates[0].getDay());
        if (!rule) return;

        function generateSlots(from, to) {
            const slots = [];
            let [h, m] = from.split(':').map(Number);
            const [endH, endM] = to.split(':').map(Number);
            while (h < endH || (h === endH && m <= endM)) {
                slots.push(
                    `${h.toString().padStart(2, '0')}:${m.toString().padStart(2, '0')}`
                );
                m += 30;
                if (m >= 60) {
                    h += 1;
                    m -= 60;
                }
            }
            return slots;
        }
        const allSlots = generateSlots(rule.from, rule.to);
        const toMin = t => +t.slice(0, 2) * 60 + +t.slice(3, 5);

        allSlots.forEach((t, i) => {
            const col = document.createElement('div');
            col.className = 'col-4 my-1';

            col.innerHTML = `
           <input  type="radio" class="btn-check" name="time"
                   id="slot-${i}" value="${t}">
           <label  for="slot-${i}" class="btn w-100 btn-outline-secondary text-center">
               <div class="fw-semibold">${t}</div>
           </label>`;

            if (toMin(t) < toMin(rule.from) || toMin(t) > toMin(rule.to)) {
                col.querySelector('input').disabled = true;
                col.querySelector('label').classList.add('slot-disabled');
            }
            wrap.append(col);

            document.querySelectorAll('input[name="time"]').forEach(radio => {
                radio.addEventListener('change', () => {
                    document.getElementById('rescheduleSubmit').disabled = false;
                });
            });
        });
    }

    window.closeRescheduleModal = () => {
        const modalEl = document.getElementById('rescheduleModal');
        if (!modalEl) return;

        (bootstrap.Modal.getInstance(modalEl) ??
            new bootstrap.Modal(modalEl)).hide();

        if (window._activeFlatpickr) {
            window._activeFlatpickr.destroy();
            window._activeFlatpickr = null;
        }
        window.rescheduleReady = false;
    };

    document.getElementById('rescheduleModal')
        .addEventListener('hidden.bs.modal', () => {
            if (window._activeFlatpickr) {
                window._activeFlatpickr.destroy();
                window._activeFlatpickr = null;
            }
            window.rescheduleReady = false;
        });
</script>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<style>
    .slot-disabled {
        background: #f8d7da !important;
        color: #842029 !important;
        cursor: not-allowed;
    }
</style>
