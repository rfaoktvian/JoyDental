@php
    use Carbon\Carbon;
    $carbon = new Carbon();
    $carbon->setLocale('id');
@endphp

<div class="calendar">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0" id="calendarMonthLabel-{{ $calendarId }}"></h5>
        <div>
            <button class="btn btn-sm rounded-circle" id="prevMonth-{{ $calendarId }}"
                style="background: #E9ECEF; width: 32px; height: 32px;">
                <i class="fas fa-chevron-left"></i>
            </button>
            <button class="btn btn-sm rounded-circle" id="nextMonth-{{ $calendarId }}"
                style="background: #E9ECEF; width: 32px; height: 32px;">
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-borderless text-center align-middle mb-0">
            <thead class="text-muted">
                <tr>
                    <th>Min</th>
                    <th>Sen</th>
                    <th>Sel</th>
                    <th>Rab</th>
                    <th>Kam</th>
                    <th>Jum</th>
                    <th>Sab</th>
                </tr>
            </thead>
            <tbody id="calendarBody-{{ $calendarId }}" class="transition-opacity">
                <!-- JavaScript will fill this -->
            </tbody>
        </table>
    </div>
</div>

<style>
    .calendar h5 {
        font-weight: bold;
        font-size: 1.1rem;
    }

    .calendar td {
        padding: 6px !important;
    }

    .calendar tbody {
        transition: opacity 0.3s ease-in-out;
    }

    .holiday-dot {
        display: block;
        margin-top: 2px;
        width: 6px;
        height: 6px;
        background-color: red;
        border-radius: 50%;
    }

    .calendar,
    .calendar .table,
    .calendar .table-responsive,
    .calendar .table tbody,
    .calendar .table thead,
    .calendar .table td {
        background-color: #ffffff00 !important;
    }
</style>

<script>
    function initCalendar() {
        const monthNames = [
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];

        function getMovingEidDates(year) {
            const start = new Date(2025, 3, 1); // Approximate April 1st 2025 Eid
            const diff = 2025 - year;
            const estimated = new Date(start.getTime());
            estimated.setDate(start.getDate() - (-11 * diff));

            return [
                [estimated.getDate(), estimated.getMonth() + 1, 'Hari Raya Idul Fitri'],
                [estimated.getDate() + 1, estimated.getMonth() + 1, 'Cuti Bersama Idul Fitri'],
                [estimated.getDate() + 2, estimated.getMonth() + 1, 'Cuti Bersama Idul Fitri'],
                [estimated.getDate() + 3, estimated.getMonth() + 1, 'Cuti Bersama Idul Fitri']
            ];
        }

        const today = new Date();
        let currentMonth = today.getMonth();
        let currentYear = today.getFullYear();

        const id = '{{ $calendarId }}';
        const monthLabel = document.getElementById(`calendarMonthLabel-${id}`);
        const calendarBody = document.getElementById(`calendarBody-${id}`);
        const prevBtn = document.getElementById(`prevMonth-${id}`);
        const nextBtn = document.getElementById(`nextMonth-${id}`);

        const staticHolidays = {
            '1-1': 'Tahun Baru 2025 Masehi', // New Year 2025
            '27-1': 'Isra Miraj Nabi Muhammad SAW', // Isra Mi'raj of Prophet Muhammad
            '28-1': 'Cuti Bersama Tahun Baru Imlek 2576 Kongzili', // Chinese New Year Joint Holiday
            '29-1': 'Tahun Baru Imlek 2576 Kongzili', // Chinese New Year 2576
            '28-3': 'Cuti Bersama Hari Raya Nyepi Tahun Baru Saka 1947', // Nyepi Joint Holiday
            '29-3': 'Hari Raya Nyepi Tahun Baru Saka 1947', // Nyepi (Balinese New Year)
            '31-3': 'Hari Raya Idul Fitri 1446H', // Eid al-Fitr 1446H
            '18-4': 'Wafat Yesus Kristus', // Good Friday
            '20-4': 'Kebangkitan Yesus Kristus', // Easter Sunday
            '1-5': 'Hari Buruh Internasional', // International Labor Day
            '12-5': 'Hari Raya Waisak 2569 BE', // Vesak Day 2569 BE
            '13-5': 'Cuti Bersama Hari Raya Waisak 2569 BE', // Vesak Joint Holiday
            '29-5': 'Kenaikan Yesus Kristus', // Ascension of Jesus Christ
            '30-5': 'Cuti Bersama Kenaikan Yesus Kristus', // Ascension Joint Holiday
            '1-6': 'Hari Lahir Pancasila', // Pancasila Day
            '6-6': 'Hari Raya Idul Adha 1446H', // Eid al-Adha 1446H
            '9-6': 'Cuti Bersama Hari Raya Idul Adha 1446H', // Eid al-Adha Joint Holiday
            '27-6': 'Tahun Baru Islam 1447H', // Islamic New Year 1447H
            '17-8': 'Hari Kemerdekaan', // Independence Day
            '5-9': 'Maulid Nabi Muhammad SAW 1447H', // Prophet Muhammad's Birthday 1447H
            '25-12': 'Hari Natal', // Christmas Day
        };

        function renderCalendar(month, year) {
            calendarBody.style.opacity = 0;
            setTimeout(() => {
                calendarBody.innerHTML = '';
                const firstDay = new Date(year, month, 1);
                const startDay = (firstDay.getDay() + 6) % 7;
                const daysInMonth = new Date(year, month + 1, 0).getDate();

                monthLabel.textContent = `${monthNames[month]} ${year}`;

                let dynamicHolidays = {};
                getMovingEidDates(year).forEach(([d, m, label]) => {
                    dynamicHolidays[`${d}-${m}`] = label;
                });

                let allHolidays = {
                    ...staticHolidays,
                    ...dynamicHolidays
                };

                let date = 1 - startDay;
                for (let week = 0; week < 6; week++) {
                    const row = document.createElement('tr');
                    for (let i = 0; i < 7; i++) {
                        const cell = document.createElement('td');
                        if (date > 0 && date <= daysInMonth) {
                            const wrapper = document.createElement('div');
                            wrapper.classList.add('d-flex', 'flex-column', 'align-items-center');

                            const dayDiv = document.createElement('div');
                            dayDiv.classList.add('rounded-circle', 'mx-auto', 'd-flex',
                                'justify-content-center', 'align-items-center');
                            dayDiv.style.width = '32px';
                            dayDiv.style.height = '32px';

                            const dateKey = `${date}-${month + 1}`;
                            const isHoliday = allHolidays.hasOwnProperty(dateKey);

                            if (
                                date === today.getDate() &&
                                month === today.getMonth() &&
                                year === today.getFullYear()
                            ) {
                                dayDiv.classList.add('bg-danger', 'text-white');
                            }

                            if (i === 0 || i === 6) {
                                dayDiv.classList.add('text-danger');
                            }

                            if (isHoliday) {
                                dayDiv.title = allHolidays[dateKey];
                            }

                            dayDiv.textContent = date;
                            wrapper.appendChild(dayDiv);

                            if (isHoliday) {
                                const dot = document.createElement('span');
                                dot.classList.add('holiday-dot');
                                wrapper.appendChild(dot);
                            }

                            cell.appendChild(wrapper);
                        }
                        row.appendChild(cell);
                        date++;
                    }
                    calendarBody.appendChild(row);
                }
                calendarBody.style.opacity = 1;
            });
        }

        prevBtn.addEventListener('click', () => {
            currentMonth--;
            if (currentMonth < 0) {
                currentMonth = 11;
                currentYear--;
            }
            renderCalendar(currentMonth, currentYear);
        });

        nextBtn.addEventListener('click', () => {
            currentMonth++;
            if (currentMonth > 11) {
                currentMonth = 0;
                currentYear++;
            }
            renderCalendar(currentMonth, currentYear);
        });

        renderCalendar(currentMonth, currentYear);
    }
    initCalendar();
</script>
