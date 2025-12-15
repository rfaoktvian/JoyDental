@extends('layouts.app')

@section('content')

<script>
    document.getElementById('pay-button').addEventListener('click', function() {
        console.log('PAY BUTTON CLICKED'); // 🔥 WAJIB MUNCUL

        const payButton = this;
        payButton.disabled = true;
        payButton.innerHTML = 'Memproses...';

        fetch('{{ route("payment.process", $order->id) }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            credentials: 'same-origin'
        })
        .then(res => {
            console.log('FETCH RESPONSE STATUS:', res.status);
            return res.json();
        })
        .then(data => {
            console.log('FETCH DATA:', data);
        })
        .catch(err => {
            console.error('FETCH ERROR:', err);
        });
    });
</script>

<style>
    .bg-danger {
        --bs-bg-opacity: 1;
        background-color: #6b2c91 !important;
    }
</style>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Header -->
            <div class="text-center mb-4">
                <h2 class="fw-bold mb-2">Konfirmasi Pembayaran</h2>
                <p class="text-muted">Silakan lakukan pembayaran untuk mengkonfirmasi janji temu Anda</p>
            </div>

            <!-- Card Detail Booking -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-danger text-white">
                    <i class="fas fa-calendar-check me-2"></i> Detail Janji Temu
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-4 fw-semibold">Kode Booking:</div>
                        <div class="col-md-8">
                            <span class="badge bg-primary fs-6">{{ $order->appointment->booking_code }}</span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 fw-semibold">Nomor Antrian:</div>
                        <div class="col-md-8">{{ $order->appointment->queue_number }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 fw-semibold">Pasien:</div>
                        <div class="col-md-8">{{ $order->appointment->user->name }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 fw-semibold">Dokter:</div>
                        <div class="col-md-8">{{ $order->appointment->doctor->name }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 fw-semibold">Layanan:</div>
                        <div class="col-md-8">
                            {{ $order->appointment->schedule->polyclinic->name ?? $order->appointment->clinic->name->location ?? '-' }}
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 fw-semibold">Tanggal & Waktu:</div>
                        <div class="col-md-8">
                            {{ $order->appointment->appointment_date->format('d M Y') }} - 
                            {{ $order->appointment->appointment_time->format('H:i') }} WIB
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card Rincian Pembayaran -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-danger text-white">
                    <i class="fas fa-money-bill-wave me-2"></i> Rincian Pembayaran
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Biaya Booking Konsultasi</span>
                        <span>Rp {{ number_format($order->amount, 0, ',', '.') }}</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between fw-bold fs-5">
                        <span>Total Pembayaran</span>
                        <span class="text-danger">Rp {{ number_format($order->amount, 0, ',', '.') }}</span>
                    </div>
                    <div class="alert alert-info mt-3 mb-0">
                        <i class="fas fa-info-circle me-2"></i>
                        <small>
                            Biaya ini merupakan biaya booking/konsultasi awal. 
                            Biaya perawatan final akan ditentukan setelah pemeriksaan oleh dokter.
                        </small>
                    </div>
                    
                    <!-- Instruksi Pembayaran -->
                    <div class="alert alert-warning mt-3 mb-0">
                        <h6 class="fw-bold mb-2"><i class="fas fa-lightbulb me-2"></i>Cara Pembayaran:</h6>
                        <ol class="mb-0 ps-3" style="font-size: 0.9rem;">
                            <li>Klik tombol "Bayar Sekarang" di bawah</li>
                            <li>Pilih metode pembayaran (Kartu Kredit, Transfer Bank, E-Wallet, dll)</li>
                            <li>Ikuti instruksi pembayaran yang muncul</li>
                            <li>Setelah pembayaran berhasil, booking Anda akan otomatis dikonfirmasi</li>
                            <li>Cek status pembayaran di halaman Tiket Antrian</li>
                        </ol>
                    </div>
                </div>
            </div>

            <!-- Tombol Bayar -->
            <div class="d-grid gap-2">
                <button id="pay-button" class="btn btn-danger btn-lg">
                    <i class="fas fa-credit-card me-2"></i> Bayar Sekarang
                </button>
                <a href="{{ route('tiket-antrian') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i> Kembali ke Tiket Antrian
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Midtrans Snap Script -->
@if(config('midtrans.is_production'))
    <script src="https://app.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
@else
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
@endif

<script>
    document.getElementById('pay-button').addEventListener('click', function() {
        const payButton = this;
        
        // Disable button saat proses
        payButton.disabled = true;
        payButton.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Memproses...';

        // Request snap token ke server
        fetch('{{ route("payment.process", $order->id) }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            credentials: 'same-origin'
        })

        .then(response => response.json())
        .then(data => {
            if (data.snap_token) {
                // Buka Midtrans Snap
                window.snap.pay(data.snap_token, {
                    onSuccess: function(result) {
                        console.log('Payment success:', result);
                        
                        // Tampilkan notifikasi sukses
                        alert('✅ Pembayaran berhasil! Anda akan diarahkan ke Tiket Antrian.');
                        
                        // Redirect ke tiket antrian
                        window.location.href = '{{ route("tiket-antrian") }}?payment=success';
                    },
                    onPending: function(result) {
                        console.log('Payment pending:', result);
                        
                        // Tampilkan notifikasi pending
                        alert('⏳ Pembayaran sedang diproses. Silakan selesaikan pembayaran Anda.\n\n' +
                              'Jika Anda memilih Bank Transfer/E-Wallet, silakan lakukan pembayaran sesuai instruksi.\n\n' +
                              'Status pembayaran akan diperbarui otomatis setelah pembayaran diterima.');
                        
                        // Redirect ke tiket antrian
                        window.location.href = '{{ route("tiket-antrian") }}?payment=pending';
                    },
                    onError: function(result) {
                        console.log('Payment error:', result);
                        
                        // Tampilkan notifikasi error
                        alert('❌ Pembayaran gagal!\n\n' +
                              'Alasan: ' + (result.status_message || 'Terjadi kesalahan') + '\n\n' +
                              'Silakan coba lagi atau gunakan metode pembayaran lain.');
                        
                        // Reset button
                        payButton.disabled = false;
                        payButton.innerHTML = '<i class="fas fa-credit-card me-2"></i> Bayar Sekarang';
                    },
                    onClose: function() {
                        console.log('Payment popup closed without completing payment');
                        
                        // Reset button
                        payButton.disabled = false;
                        payButton.innerHTML = '<i class="fas fa-credit-card me-2"></i> Bayar Sekarang';
                    }
                });
            } else {
                alert('❌ Gagal memproses pembayaran.\n\nSilakan refresh halaman dan coba lagi.');
                location.reload();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('❌ Terjadi kesalahan sistem.\n\nSilakan coba lagi dalam beberapa saat.');
            
            // Reset button
            payButton.disabled = false;
            payButton.innerHTML = '<i class="fas fa-credit-card me-2"></i> Bayar Sekarang';
        });
    });
</script>
@endsection