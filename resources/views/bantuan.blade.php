@extends('layouts.app')

@section('content')
    <style>
        .help-card {
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 16px;
            transition: all 0.2s ease-in-out;
        }

        .help-card:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            transform: translateY(-2px);
        }

        .accordion-button:not(.collapsed) {
            color: #6B2C91;
            background-color: #ebe3f5ff;
            font-weight: bold;
        }
    </style>

    <div class="banner d-flex justify-content-center align-items-center text-center text-white mb-4 rounded py-4 px-3"
        style="background: linear-gradient(135deg, #6B2C91, #7f4ea7);">
        <div style="z-index: 2;">
            <h2 class="fw-bold mb-2">Pusat Bantuan</h2>
            <p class="mb-0">Temukan jawaban untuk pertanyaan umum Anda dengan cepat.</p>
        </div>
    </div>

    <section class="container">
        <div class="row">
            <div class="col-lg-10 mx-auto">
                <h4 class="mb-3">Pertanyaan Umum</h4>
                @php
                    $faqCommon = [
                        [
                            'question' => 'Bagaimana cara mendaftar antrian?',
                            'answer' =>
                                'Silakan pilih menu Janji Temu lalu isi data poliklinik, dokter, dan metode pembayaran. Klik Daftar untuk menyelesaikan.',
                        ],
                        [
                            'question' => 'Apakah saya bisa mengganti data pasien?',
                            'answer' =>
                                'Tentu. Klik Ganti Identitas di halaman janji temu untuk mengubah data pasien yang digunakan.',
                        ],
                        [
                            'question' => 'Apa itu metode pembayaran “Rujukan Internal”?',
                            'answer' =>
                                'Metode ini digunakan jika Anda telah dirujuk dari dokter lain di rumah sakit yang sama.',
                        ],
                        [
                            'question' => 'Saya mengalami kendala teknis, ke mana saya harus melapor?',
                            'answer' =>
                                'Silakan hubungi admin kami melalui WhatsApp di +62895359008793 atau kirim email ke admin@siagasedia.id.',
                        ],
                    ];
                @endphp
                <div class="accordion" id="faqAccordionCommon">
                    @foreach ($faqCommon as $indexCommon => $faq)
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingCommon{{ $indexCommon }}">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseCommon{{ $indexCommon }}" aria-expanded="false"
                                    aria-controls="collapseCommon{{ $indexCommon }}">
                                    {{ $faq['question'] }}
                                </button>
                            </h2>
                            <div id="collapseCommon{{ $indexCommon }}" class="accordion-collapse collapse"
                                aria-labelledby="headingCommon{{ $indexCommon }}">
                                <div class="accordion-body text-muted">
                                    {{ $faq['answer'] }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>


            <div class="col-lg-10 mx-auto mt-4">
                <h4 class="mb-3">Pertanyaan Umum</h4>
                @php
                    $faqAccounts = [
                        [
                            'question' => 'Bagaimana cara membuat janji temu?',
                            'answer' =>
                                'Anda bisa membuat janji temu dengan mengunjungi halaman "Janji Temu" dan memilih dokter serta waktu yang tersedia.',
                        ],
                        [
                            'question' => 'Saya lupa password saya, bagaimana cara meresetnya?',
                            'answer' =>
                                'Klik tombol "Lupa Password" di halaman login, lalu ikuti langkah-langkah yang dikirimkan ke email Anda.',
                        ],
                        [
                            'question' => 'Apakah saya bisa membatalkan janji temu?',
                            'answer' =>
                                'Ya, Anda bisa membatalkan janji temu hingga 24 jam sebelum waktu yang dijadwalkan melalui dashboard akun Anda.',
                        ],
                        [
                            'question' => 'Bagaimana melihat riwayat kunjungan saya?',
                            'answer' => 'Riwayat kunjungan Anda tersedia di halaman profil setelah login ke akun Anda.',
                        ],
                        [
                            'question' => 'Kenapa saya tidak bisa login ke akun saya?',
                            'answer' =>
                                'Pastikan email dan password sudah benar. Jika masih gagal, coba reset password atau hubungi dukungan.',
                        ],
                    ];
                @endphp
                <div class="accordion" id="faqAccordionAccounts">
                    @foreach ($faqAccounts as $index => $faq)
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingAccounts{{ $index }}">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseAccounts{{ $index }}" aria-expanded="false"
                                    aria-controls="collapseAccounts{{ $index }}">
                                    {{ $faq['question'] }}
                                </button>
                            </h2>
                            <div id="collapseAccounts{{ $index }}" class="accordion-collapse collapse"
                                aria-labelledby="headingAccounts{{ $index }}">
                                <div class="accordion-body text-muted">
                                    {{ $faq['answer'] }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endsection
