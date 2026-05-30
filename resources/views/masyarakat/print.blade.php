<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Riwayat Perjalanan - {{ Auth::user()->name }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            font-family: 'Inter', Arial, sans-serif; 
            color: #1e293b; 
            line-height: 1.6;
            padding: 24px;
            background: #fff;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #4a7a8a;
            padding-bottom: 16px;
            margin-bottom: 24px;
        }
        .header h1 {
            font-size: 22px;
            font-weight: 800;
            color: #1a365d;
            letter-spacing: 1px;
        }
        .header p {
            font-size: 11px;
            color: #64748b;
            margin-top: 4px;
        }
        .user-info {
            display: flex;
            justify-content: space-between;
            background: #f8fafc;
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 12px;
            border: 1px solid #e2e8f0;
        }
        .user-info strong { color: #1a365d; }
        .filters {
            font-size: 10px;
            color: #475569;
            margin-bottom: 16px;
            padding: 8px 12px;
            background: #f1f5f9;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
            margin-bottom: 24px;
        }
        thead th {
            background: #f8fafc;
            color: #475569;
            padding: 10px 12px;
            text-align: left;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 9px;
            border-bottom: 2px solid #e2e8f0;
        }
        tbody td {
            padding: 8px 12px;
            border-bottom: 1px solid #e2e8f0;
        }
        tbody tr:nth-child(even) { background: #fdfdfd; }
        .temp-normal { color: #059669; font-weight: 700; }
        .temp-high { color: #dc2626; font-weight: 700; background: #fef2f2; padding: 2px 6px; border-radius: 4px; }
        .footer {
            text-align: center;
            font-size: 10px;
            color: #94a3b8;
            border-top: 1px solid #e2e8f0;
            padding-top: 12px;
        }
        .summary-box {
            display: flex;
            gap: 16px;
            margin-bottom: 20px;
        }
        .summary-item {
            flex: 1;
            text-align: center;
            padding: 10px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            background: #f8fafc;
        }
        .summary-item .value { font-size: 20px; font-weight: 800; color: #1a365d; }
        .summary-item .label { font-size: 9px; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; }
        @media print {
            body { padding: 12px; }
            .no-print { display: none !important; }
        }
    </style>
</head>
<body>
    <!-- Print Button -->
    <div class="no-print" style="text-align: right; margin-bottom: 16px;">
        <button onclick="window.print()" style="padding: 8px 24px; background: #4a7a8a; color: white; border: none; border-radius: 20px; font-weight: 600; cursor: pointer; font-size: 12px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">
            🖨️ Cetak / Simpan PDF
        </button>
        <button onclick="window.close()" style="padding: 8px 16px; background: #f1f5f9; color: #475569; border: 1px solid #cbd5e1; border-radius: 20px; font-weight: 600; cursor: pointer; margin-left: 8px; font-size: 12px;">
            ✕ Tutup
        </button>
    </div>

    <!-- Header -->
    <div class="header">
        <h1>📋 HEALTHYWAY — Riwayat Perjalanan</h1>
        <p>Laporan Personal Log Perjalanan & Suhu Tubuh</p>
    </div>

    <!-- User Info -->
    <div class="user-info">
        <div><strong>Nama:</strong> {{ Auth::user()->name }}</div>
        <div><strong>Email:</strong> {{ Auth::user()->email }}</div>
        <div><strong>Dicetak:</strong> {{ now()->translatedFormat('d M Y, H:i') }}</div>
    </div>

    <!-- Active Filters -->
    @if($search || $filterSuhu || $filterTanggal)
    <div class="filters">
        <strong>Filter aktif:</strong>
        @if($search) Lokasi: "{{ $search }}" @endif
        @if($filterSuhu) | Suhu: {{ $filterSuhu === 'normal' ? 'Normal' : 'Demam' }} @endif
        @if($filterTanggal) | Tanggal: {{ $filterTanggal }} @endif
    </div>
    @endif

    <!-- Summary -->
    <div class="summary-box">
        <div class="summary-item">
            <div class="value">{{ $perjalanans->count() }}</div>
            <div class="label">Total Catatan</div>
        </div>
        <div class="summary-item">
            <div class="value">{{ $perjalanans->count() > 0 ? number_format($perjalanans->avg('suhu_tubuh'), 1) . '°C' : '—' }}</div>
            <div class="label">Rata-Rata Suhu</div>
        </div>
        <div class="summary-item">
            <div class="value">{{ $perjalanans->where('suhu_tubuh', '>=', 37.5)->count() }}</div>
            <div class="label">Log Suhu Tinggi</div>
        </div>
    </div>

    <!-- Data Table -->
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Jam</th>
                <th>Lokasi</th>
                <th>Suhu Tubuh</th>
                <th>Catatan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($perjalanans as $index => $log)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ \Carbon\Carbon::parse($log->tanggal)->translatedFormat('d M Y') }}</td>
                <td>{{ substr($log->jam, 0, 5) }}</td>
                <td>{{ $log->lokasi }}</td>
                <td>
                    <span class="{{ $log->suhu_tubuh >= 37.5 ? 'temp-high' : 'temp-normal' }}">
                        {{ number_format($log->suhu_tubuh, 1) }}°C
                    </span>
                </td>
                <td>{{ $log->catatan ?? '—' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center; padding: 24px; color: #94a3b8;">Tidak ada data perjalanan.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Footer -->
    <div class="footer">
        <p>Dokumen ini digenerate secara otomatis oleh sistem <strong>HealthyWay</strong>.</p>
        <p>Untuk keperluan medis, silakan konsultasikan dengan dokter Anda.</p>
    </div>
</body>
</html>
