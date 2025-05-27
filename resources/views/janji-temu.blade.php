@extends('layouts.app')

@section('content')

    <style>
        .nav-pills {
            gap: 0.5rem;
        }

        .nav-pills .nav-link {
            color: #6c757d;
            background-color: transparent;
            border: 1px solid transparent;
        }

        .nav-pills .nav-link:hover {
            color: #d32f2f;
        }

        .nav-pills .nav-link.active {
            color: #fff;
            background-color: #d32f2f;
            border: 1px solid #d32f2f;
        }

        .page-item .page-link {
            color: #d32f2f;
            border-radius: 0;
            min-width: 40px;
            text-align: center;
        }

        .page-item.active .page-link {
            background-color: #d32f2f;
            color: white;
            border-color: #d32f2f;
        }
    </style>

    @php
        $data_antrian = [
            ['queue' => 'F01', 'booking_code' => 'ABC123456', 'poliklinik' => 'Klinik Anak', 'doktor' => 'Dr. Amanda Wijaya', 'jadwal' => 'Senin', 'status' => 1, 'created_at' => '2024-01-01 12:00:00'],
            ['queue' => 'F02', 'booking_code' => 'ABC223456', 'poliklinik' => 'Klinik Gigi', 'doktor' => 'Dr. Budi Santoso', 'jadwal' => 'Selasa', 'status' => 2, 'created_at' => '2024-01-02 14:00:00'],
            ['queue' => 'F03', 'booking_code' => 'ABC323456', 'poliklinik' => 'Klinik Bedah', 'doktor' => 'Dr. Siti Rahayu', 'jadwal' => 'Rabu', 'status' => 3, 'created_at' => '2024-01-03 16:00:00'],
            ['queue' => 'F04', 'booking_code' => 'ABC423456', 'poliklinik' => 'Klinik Anak', 'doktor' => 'Dr. Amanda Wijaya', 'jadwal' => 'Kamis', 'status' => 1, 'created_at' => '2024-01-04 10:00:00'],
            ['queue' => 'F05', 'booking_code' => 'ABC523456', 'poliklinik' => 'Klinik Anak', 'doktor' => 'Dr. Amanda Wijaya', 'jadwal' => 'Jumat', 'status' => 2, 'created_at' => '2024-01-05 09:00:00'],
            ['queue' => 'F01', 'booking_code' => 'ABC123456', 'poliklinik' => 'Klinik Anak', 'doktor' => 'Dr. Amanda Wijaya', 'jadwal' => 'Senin', 'status' => 1, 'created_at' => '2024-01-01 12:00:00'],
        ];
    @endphp

    <div class="banner">
        <div class="border-bottom mb-3 pb-2 sticky-top" style="background-color: #F5F5F5;">
            <div class="d-flex flex-wrap align-items-center gap-2 mb-2">
                <input type="text" class="form-control w-auto" placeholder="Cari tiket...">
                <select class="form-select w-auto">
                    <option>Semua Poliklinik</option>
                    <option>Klinik Anak</option>
                    <option>Klinik Dokter Gigi</option>
                    <option>Klinik Bedah Mulut</option>
                    <option>Klinik Penyakit Dalam</option>
                    <option>Klinik Mata</option>
                    <option>Klinik Jantung</option>
                </select>
            </div>

            <div class="d-flex align-items-center gap-3">
                <span class="fw-semibold">Status</span>

                <ul class="nav nav-pills gap-20 fw-bold" id="statusTabs">
                    <li class="nav-item">
                        <a class="nav-link active" href="#" data-filter="all">Semua</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-filter="1">Akan Datang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-filter="2">Selesai</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-filter="3">Dibatalkan</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="row" id="ticketContainer">
            @foreach ($data_antrian as $data)
                <div class="col-md-6 col-lg-4 ticket-wrapper" data-status="{{ $data['status'] }}">
                    <div class="card bg-white overflow-hidden rounded shadow-sm mb-3 ">
                        <p class="clinic-name">{{ $data['queue'] }}</p>
                        <p class="clinic-name">{{ $data['booking_code'] }}</p>
                        <p class="clinic-name">{{ $data['poliklinik'] }}</p>
                        <p class="clinic-name">{{ $data['doktor'] }}</p>
                        <p class="clinic-name">{{ $data['jadwal'] }}</p>
                        <p class="clinic-name">Status: {{ $data['status'] }}</p>
                        <p class="clinic-name">{{ $data['created_at'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>

        <nav>
            <ul class="pagination justify-content-center mt-4" id="paginationContainer"></ul>
        </nav>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const cards = Array.from(document.querySelectorAll('.ticket-wrapper'));
            const paginationContainer = document.getElementById('paginationContainer');
            const tabs = document.querySelectorAll('#statusTabs .nav-link');
            const cardsPerPage = 6;
            let currentPage = 1;
            let currentFilter = 'all';

            function filterAndPaginate() {
                const filtered = cards.filter(card => {
                    const status = card.getAttribute('data-status');
                    return currentFilter === 'all' || status === currentFilter;
                });

                const totalPages = Math.ceil(filtered.length / cardsPerPage);

                // hide all cards
                cards.forEach(card => card.style.display = 'none');

                // show cards for current page
                const start = (currentPage - 1) * cardsPerPage;
                const end = start + cardsPerPage;
                filtered.slice(start, end).forEach(card => {
                    card.style.display = '';
                });

                // render pagination
                renderPagination(totalPages);
            }

            function renderPagination(totalPages) {
                paginationContainer.innerHTML = '';

                const prev = document.createElement('li');
                prev.className = `page-item ${currentPage === 1 ? 'disabled' : ''}`;
                prev.innerHTML = `<a class="page-link" href="#">&laquo;</a>`;
                prev.onclick = () => {
                    if (currentPage > 1) {
                        currentPage--;
                        filterAndPaginate();
                    }
                };
                paginationContainer.appendChild(prev);

                for (let i = 1; i <= totalPages; i++) {
                    const li = document.createElement('li');
                    li.className = `page-item ${i === currentPage ? 'active' : ''}`;
                    li.innerHTML = `<a class="page-link" href="#">${i}</a>`;
                    li.onclick = () => {
                        currentPage = i;
                        filterAndPaginate();
                    };
                    paginationContainer.appendChild(li);
                }

                const next = document.createElement('li');
                next.className = `page-item ${currentPage === totalPages ? 'disabled' : ''}`;
                next.innerHTML = `<a class="page-link" href="#">&raquo;</a>`;
                next.onclick = () => {
                    if (currentPage < totalPages) {
                        currentPage++;
                        filterAndPaginate();
                    }
                };
                paginationContainer.appendChild(next);
            }

            // tab click filter handler
            tabs.forEach(tab => {
                tab.addEventListener('click', e => {
                    e.preventDefault();
                    tabs.forEach(t => t.classList.remove('active'));
                    tab.classList.add('active');
                    currentFilter = tab.getAttribute('data-filter');
                    currentPage = 1;
                    filterAndPaginate();
                });
            });

            // initial load
            filterAndPaginate();
        });
    </script>
@endsection