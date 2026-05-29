<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan - Langkah Sehat</title>
    
    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
            color: #0f172a;
            background-color: #ffffff;
            margin: 0;
            padding: 40px;
            font-size: 12px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #0f172a;
            padding-bottom: 15px;
        }
        
        .header h1 {
            font-size: 20px;
            margin: 0 0 5px 0;
            text-transform: uppercase;
            font-weight: 700;
            letter-spacing: 0.5px;
        }
        
        .header p {
            margin: 0;
            font-size: 11px;
            color: #64748b;
        }
        
        .meta-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            font-size: 11px;
            color: #334155;
        }
        
        .meta-info p {
            margin: 3px 0;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        
        th {
            background-color: #f1f5f9;
            border: 1px solid #cbd5e1;
            padding: 10px 8px;
            font-weight: 600;
            text-align: left;
            font-size: 10px;
            text-transform: uppercase;
        }
        
        td {
            border: 1px solid #e2e8f0;
            padding: 8px;
            vertical-align: top;
        }
        
        tr:nth-child(even) {
            background-color: #f8fafc;
        }
        
        .badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: 600;
        }
        
        .badge-normal {
            background-color: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0;
        }
        
        .badge-warning {
            background-color: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }
        
        .footer {
            margin-top: 50px;
            text-align: right;
            font-size: 11px;
            color: #475569;
        }
        
        .print-btn-container {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }
        
        .print-btn {
            background-color: #0f172a;
            color: #ffffff;
            border: none;
            padding: 10px 20px;
            font-size: 12px;
            font-weight: 600;
            border-radius: 6px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        
        .print-btn:hover {
            background-color: #1e293b;
        }

        @media print {
            .print-btn-container {
                display: none;
            }
            body {
                padding: 0;
            }
        }
    </style>
</head>
<body onload="window.print()">

    <!-- Print Button (visible on screen, hidden when printing) -->
    <div class="print-btn-container">
        <button class="print-btn" onclick="window.print()">
            Cetak Ulang Dokumen
        </button>
    </div>

    <!-- Document Header -->
    <div class="header">
        <h1>Laporan Rekapitulasi Perjalanan & Suhu Tubuh</h1>
        <p>Aplikasi Kesehatan Perjalanan Mandiri — Langkah Sehat</p>
    </div>

    <!-- Metadata Details -->
    <div class="meta-info">
        <div>
            <p><strong>Tanggal Cetak:</strong> {{ now()->translatedFormat('d F Y, H:i') }} WIB</p>
            <p><strong>Operator:</strong> {{ Auth::user()->name }} (Super Admin)</p>
        </div>
        <div>
            <p><strong>Penyaringan Pencarian:</strong> {{ $search ?: 'Semua Data' }}</p>
            <p><strong>Filter Suhu:</strong> 
                @if($filterSuhu === 'normal')
                    Normal (< 37.5°C)
                @elseif($filterSuhu === 'demam')
                    Demam / Alert (≥ 37.5°C)
                @else
                    Tanpa Filter
                @endif
            </p>
            @if($filterTanggal)
                <p><strong>Filter Tanggal:</strong> {{ \Carbon\Carbon::parse($filterTanggal)->translatedFormat('d M Y') }}</p>
            @endif
        </div>
    </div>

    <!-- Data Table -->
    <table>
        <thead>
            <tr>
                <th style="width: 5%">No</th>
                <th style="width: 20%">Nama Pengguna / Email</th>
                <th style="width: 15%">Tanggal & Jam</th>
                <th style="width: 25%">Lokasi Kunjungan</th>
                <th style="width: 12%">Suhu Tubuh</th>
                <th style="width: 23%">Catatan Medis / Tambahan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($perjalanans as $index => $log)
                <tr>
                    <td style="text-align: center;">{{ $index + 1 }}</td>
                    <td>
                        <strong>{{ $log->user->name ?? 'Guest' }}</strong><br>
                        <span style="font-size: 10px; color: #64748b;">{{ $log->user->email ?? 'N/A' }}</span>
                    </td>
                    <td>
                        {{ \Carbon\Carbon::parse($log->tanggal)->translatedFormat('d M Y') }}<br>
                        <span style="font-size: 10px; color: #64748b;">{{ substr($log->jam, 0, 5) }} WIB</span>
                    </td>
                    <td>
                        <strong>{{ $log->lokasi }}</strong>
                    </td>
                    <td>
                        @if($log->suhu_tubuh < 37.5)
                            <span class="badge badge-normal">{{ number_format($log->suhu_tubuh, 1) }}°C</span>
                        @else
                            <span class="badge badge-warning">{{ number_format($log->suhu_tubuh, 1) }}°C (Demam)</span>
                        @endif
                    </td>
                    <td>
                        {{ $log->catatan ?: '-' }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 20px; color: #64748b;">
                        Tidak ada data perjalanan yang sesuai dengan penyaringan laporan.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Sign-off area -->
    <div class="footer">
        <p>Laporan ini dihasilkan secara otomatis oleh Sistem Langkah Sehat.</p>
        <p style="margin-top: 40px; font-weight: 600;">( ___________________________ )</p>
        <p style="font-size: 9px; margin-top: 5px; color: #94a3b8;">Tanda tangan Penanggung Jawab Admin</p>
    </div>

</body>
</html>
