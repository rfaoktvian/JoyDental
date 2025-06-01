<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Janji Temu - {{ ucfirst($period) }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #c62828;
            padding-bottom: 20px;
        }

        .header h1 {
            color: #c62828;
            margin: 0;
            font-size: 24px;
        }

        .header p {
            margin: 5px 0;
            color: #666;
        }

        .info-section {
            margin-bottom: 30px;
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .info-row:last-child {
            margin-bottom: 0;
        }

        .info-label {
            font-weight: bold;
            color: #555;
        }

        .table-container {
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            font-size: 12px;
        }

        th {
            background-color: #c62828;
            color: white;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .status-ready {
            background-color: #007bff;
            color: white;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 10px;
        }

        .status-completed {
            background-color: #28a745;
            color: white;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 10px;
        }

        .status-canceled {
            background-color: #dc3545;
            color: white;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 10px;
        }

        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 12px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 20px;
        }

        .summary-stats {
            display: flex;
            justify-content: space-around;
            margin: 20px 0;
            text-align: center;
        }

        .stat-item {
            flex: 1;
            padding: 10px;
        }

        .stat-number {
            font-size: 24px;
            font-weight: bold;
            color: #c62828;
        }

        .stat-label {
            font-size: 12px;
            color: #666;
        }

        @media print {
            body {
                margin: 0;
                padding: 15px;
            }

            .header {
                page-break-after: avoid;
            }

            table {
                page-break-inside: avoid;
            }
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>LAPORAN JANJI TEMU</h1>
        <p>Periode: {{ ucfirst($period) }}</p>
        <p>Digenerate pada: {{ $generatedAt->translatedFormat('d F Y H:i:s') }}</p>
    </div>

    <div class="info-section">
        <div class="info-row">
            <span class="info-label">Total Janji Temu:</span>
            <span>{{ count($appointments) }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Status Ready:</span>
            <span>{{ $appointments->where('status', 1)->count() }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Status Completed:</span>
            <span>{{ $appointments->where('status', 2)->count() }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Status Canceled:</span>
            <span>{{ $appointments->where('status', 3)->count() }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Total Pendapatan:</span>
            <span>Rp {{ number_format($appointments->where('status', 2)->sum('consultation_fee'), 0, ',', '.') }}</span>
        </div>
    </div>

    <div class="summary-stats">
        <div class="stat-item">
            <div class="stat-number">{{ $appointments->where('status', 1)->count() }}</div>
            <div class="stat-label">Ready</div>
        </div>
        <div class="stat-item">
            <div class="stat-number">{{ $appointments->where('status', 2)->count() }}</div>
            <div class="stat-label">Completed</div>
        </div>
        <div class="stat-item">
            <div class="stat-number">{{ $appointments->where('status', 3)->count() }}</div>
            <div class="stat-label">Canceled</div>
        </div>
        <div class="stat-item">
            <div class="stat-number">{{ count($appointments) }}</div>
            <div class="stat-label">Total</div>
        </div>
    </div>

    <div class="table-container">
        <h3>Detail Janji Temu</h3>
        <table>
            <thead>
                <tr>
                    <th style="width: 5%;">#</th>
                    <th style="width: 12%;">Tanggal</th>
                    <th style="width: 8%;">Waktu</th>
                    <th style="width: 20%;">Nama Pasien</th>
                    <th style="width: 20%;">Email Pasien</th>
                    <th style="width: 15%;">Dokter</th>
                    <th style="width: 10%;">Poliklinik</th>
                    <th style="width: 10%;">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($appointments as $index => $appointment)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ \Carbon\Carbon::parse($appointment->appointment_date)->translatedFormat('d M Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i') }}</td>
                        <td>{{ $appointment->user->name }}</td>
                        <td>{{ $appointment->user->email }}</td>
                        <td>{{ $appointment->doctor->name }}</td>
                        <td>{{ optional($appointment->clinic)->name ?? 'N/A' }}</td>
                        <td>
                            @switch($appointment->status)
                                @case(1)
                                    <span class="status-ready">Ready</span>
                                @break

                                @case(2)
                                    <span class="status-completed">Completed</span>
                                @break

                                @case(3)
                                    <span class="status-canceled">Canceled</span>
                                @break

                                @default
                                    <span>Unknown</span>
                            @endswitch
                        </td>
                    </tr>
                    @empty
                        <tr>
                            <td colspan="8" style="text-align: center; padding: 20px; color: #666;">
                                Tidak ada data janji temu untuk periode ini
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="footer">
            <p>
                <strong>Klinik Management System</strong><br>
                Laporan ini digenerate secara otomatis pada {{ $generatedAt->translatedFormat('d F Y H:i:s') }}<br>
                Total {{ count($appointments) }} janji temu tercatat dalam periode {{ $period }}
            </p>
        </div>
    </body>

    </html>
