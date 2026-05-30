<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Cetak Laporan') }} - HealthyWay</title>
    
    <!-- Google Fonts: Inter & Outfit -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        * {
            box-sizing: border-box;
        }
        body {
            font-family: 'Inter', sans-serif;
            color: #1e293b;
            background-color: #ffffff;
            margin: 0;
            padding: 30px;
            font-size: 11px;
            line-height: 1.5;
        }
        
        /* Report Header Container */
        .report-header {
            display: table;
            width: 100%;
            border-bottom: 2px solid #334155;
            padding-bottom: 20px;
            margin-bottom: 25px;
        }
        .header-left {
            display: table-cell;
            vertical-align: middle;
            width: 60%;
        }
        .header-right {
            display: table-cell;
            vertical-align: middle;
            text-align: right;
            width: 40%;
        }
        
        .brand-badge {
            background-color: #0f172a;
            color: #ffffff;
            font-family: 'Outfit', sans-serif;
            font-size: 18px;
            font-weight: 800;
            padding: 6px 14px;
            border-radius: 8px;
            display: inline-block;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }
        .brand-badge span {
            color: #7da8b6;
        }
        
        .report-title {
            font-family: 'Outfit', sans-serif;
            font-size: 18px;
            font-weight: 700;
            color: #1e3a8a;
            margin: 0 0 4px 0;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .report-subtitle {
            font-size: 11px;
            color: #64748b;
            margin: 0;
        }
        
        .doc-details {
            font-size: 10px;
            color: #475569;
        }
        .doc-details table {
            width: 100%;
            border-collapse: collapse;
        }
        .doc-details td {
            border: none;
            padding: 2px 0;
        }
        
        /* Meta Info Section */
        .meta-container {
            margin-bottom: 25px;
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 12px 16px;
        }
        .meta-container table {
            width: 100%;
            border-collapse: collapse;
        }
        .meta-container td {
            border: none;
            padding: 4px 8px;
            width: 50%;
            vertical-align: top;
            font-size: 10px;
        }
        
        /* Summary Matrix Box */
        .matrix-title {
            font-family: 'Outfit', sans-serif;
            font-size: 12px;
            font-weight: 700;
            color: #0f172a;
            margin: 0 0 10px 0;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .matrix-row {
            display: table;
            width: 100%;
            margin-bottom: 25px;
        }
        .matrix-col {
            display: table-cell;
            width: 25%;
            padding: 0 8px;
        }
        .matrix-col:first-child {
            padding-left: 0;
        }
        .matrix-col:last-child {
            padding-right: 0;
        }
        
        .matrix-card {
            background-color: #f8fafc;
            border: 1px solid #cbd5e1;
            border-left: 4px solid #4a7a8a;
            border-radius: 8px;
            padding: 10px 12px;
            text-align: center;
        }
        .matrix-card.fever {
            border-left-color: #ef4444;
        }
        .matrix-card.printed {
            border-left-color: #3b82f6;
        }
        .matrix-card-label {
            font-size: 8px;
            font-weight: 700;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }
        .matrix-card-value {
            font-family: 'Outfit', sans-serif;
            font-size: 18px;
            font-weight: 800;
            color: #0f172a;
            margin: 0;
        }
        .matrix-card.fever .matrix-card-value {
            color: #b91c1c;
        }
        
        /* Data Table Styling */
        .table-container {
            margin-bottom: 30px;
        }
        table.data-table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #94a3b8;
        }
        table.data-table th {
            background-color: #0f172a;
            color: #ffffff;
            border: 1px solid #334155;
            padding: 8px 10px;
            font-family: 'Outfit', sans-serif;
            font-weight: 600;
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            text-align: left;
        }
        table.data-table td {
            border: 1px solid #cbd5e1;
            padding: 8px 10px;
            vertical-align: top;
            font-size: 10px;
        }
        table.data-table tr:nth-child(even) td {
            background-color: #f8fafc;
        }
        
        .badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 9px;
            font-weight: 700;
            text-align: center;
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
        
        /* Sign-off & Footer */
        .report-footer {
            display: table;
            width: 100%;
            margin-top: 40px;
            border-top: 1px solid #e2e8f0;
            padding-top: 15px;
        }
        .footer-left {
            display: table-cell;
            vertical-align: top;
            width: 50%;
            font-size: 9px;
            color: #94a3b8;
        }
        .footer-right {
            display: table-cell;
            vertical-align: top;
            text-align: right;
            width: 50%;
        }
        
        .signature-title {
            font-size: 10px;
            color: #475569;
            margin-bottom: 50px;
        }
        .signature-line {
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 2px;
        }
        .signature-sub {
            font-size: 8px;
            color: #64748b;
            margin: 0;
            text-transform: uppercase;
        }
        
        /* Print Control Button */
        .print-control-row {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }
        .print-control-btn {
            background-color: #0f172a;
            color: #ffffff;
            border: none;
            padding: 10px 24px;
            font-family: 'Outfit', sans-serif;
            font-size: 12px;
            font-weight: 700;
            border-radius: 30px;
            cursor: pointer;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            transition: all 0.2s;
        }
        .print-control-btn:hover {
            background-color: #1e293b;
            transform: translateY(-1px);
        }
        
        @media print {
            .print-control-row {
                display: none;
            }
            body {
                padding: 0;
            }
        }
    </style>
</head>
<body onload="window.print()">

    <!-- Reprint Button Control (screen only) -->
    <div class="print-control-row">
        <button class="print-control-btn" onclick="window.print()">
            {{ __('Cetak Ulang Dokumen') }}
        </button>
    </div>

    <!-- Document Header -->
    <div class="report-header">
        <div class="header-left">
            <div class="brand-badge">Healthy<span>Way</span></div>
            <h1 class="report-title">{{ __('Laporan Rekapitulasi Perjalanan & Suhu Tubuh') }}</h1>
            <p class="report-subtitle">{{ __('Pusat Pemantauan Kesehatan Mandiri — HealthyWay') }}</p>
        </div>
        <div class="header-right">
            <div class="doc-details">
                <table>
                    <tr>
                        <td style="font-weight: 700; text-align: right; width: 50%;">Ref:</td>
                        <td style="text-align: right; width: 50%;">HW-GL-REP</td>
                    </tr>
                    <tr>
                        <td style="font-weight: 700; text-align: right;">{{ __('Tanggal Cetak') }}:</td>
                        <td style="text-align: right;">{{ now()->translatedFormat('d F Y, H:i') }}</td>
                    </tr>
                    <tr>
                        <td style="font-weight: 700; text-align: right;">{{ __('Operator') }}:</td>
                        <td style="text-align: right;">{{ Auth::user()->name }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <!-- Metadata Details -->
    <div class="meta-container">
        <table>
            <tr>
                <td>
                    <strong>{{ __('Kata Kunci Pencarian') }}:</strong> {{ $search ?: __('Semua Data') }}
                </td>
                <td>
                    <strong>{{ __('Filter Suhu') }}:</strong> 
                    @if($filterSuhu === 'normal')
                        {{ __('Suhu Normal (< 37.5°C)') }}
                    @elseif($filterSuhu === 'demam')
                        {{ __('Suhu Demam (>= 37.5°C)') }}
                    @else
                        {{ __('Tanpa Filter') }}
                    @endif
                </td>
            </tr>
            @if($filterTanggal)
            <tr>
                <td>
                    <strong>{{ __('Filter Tanggal') }}:</strong> {{ \Carbon\Carbon::parse($filterTanggal)->translatedFormat('d M Y') }}
                </td>
                <td></td>
            </tr>
            @endif
        </table>
    </div>

    <!-- Summary Matrix Box -->
    <h3 class="matrix-title">{{ __('Ringkasan Laporan') }}</h3>
    <div class="matrix-row">
        <div class="matrix-col">
            <div class="matrix-card">
                <div class="matrix-card-label">{{ __('Total Log Sistem') }}</div>
                <div class="matrix-card-value">{{ \App\Models\Perjalanan::count() }}</div>
            </div>
        </div>
        <div class="matrix-col">
            <div class="matrix-card">
                <div class="matrix-card-label">{{ __('Total Pengguna Terdaftar') }}</div>
                <div class="matrix-card-value">{{ \App\Models\User::count() }}</div>
            </div>
        </div>
        <div class="matrix-col">
            <div class="matrix-card fever">
                <div class="matrix-card-label">{{ __('Total Kasus Demam') }}</div>
                <div class="matrix-card-value">{{ \App\Models\Perjalanan::where('suhu_tubuh', '>=', 37.5)->count() }}</div>
            </div>
        </div>
        <div class="matrix-col">
            <div class="matrix-card printed">
                <div class="matrix-card-label">{{ __('Jumlah Log yang Dicetak') }}</div>
                <div class="matrix-card-value">{{ $perjalanans->count() }}</div>
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th style="width: 5%; text-align: center;">{{ __('No') }}</th>
                    <th style="width: 25%;">{{ __('Nama Pengguna') }}</th>
                    <th style="width: 20%;">{{ __('Tanggal & Jam') }}</th>
                    <th style="width: 25%;">{{ __('Lokasi Kunjungan') }}</th>
                    <th style="width: 10%;">{{ __('Suhu Tubuh') }}</th>
                    <th style="width: 15%;">{{ __('Catatan Medis') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($perjalanans as $index => $log)
                    <tr>
                        <td style="text-align: center; font-weight: 600;">{{ $index + 1 }}</td>
                        <td>
                            <strong style="color: #0f172a;">{{ $log->user->name ?? 'Guest' }}</strong><br>
                            <span style="font-size: 9px; color: #64748b;">{{ $log->user->email ?? 'N/A' }}</span>
                        </td>
                        <td>
                            {{ \Carbon\Carbon::parse($log->tanggal)->translatedFormat('d M Y') }}<br>
                            <span style="font-size: 9px; color: #64748b;"><i class="fa-regular fa-clock"></i> {{ substr($log->jam, 0, 5) }}</span>
                        </td>
                        <td>
                            <strong style="color: #1e3a8a;">{{ $log->lokasi }}</strong>
                        </td>
                        <td style="text-align: center;">
                            @if($log->suhu_tubuh < 37.5)
                                <span class="badge badge-normal">{{ number_format($log->suhu_tubuh, 1) }}°C</span>
                            @else
                                <span class="badge badge-warning">{{ number_format($log->suhu_tubuh, 1) }}°C</span>
                            @endif
                        </td>
                        <td>
                            <span style="font-size: 9px; color: #334155; font-style: italic;">{{ $log->catatan ?: '—' }}</span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 25px; color: #64748b; font-weight: 500;">
                            {{ __('Tidak ada data perjalanan yang sesuai dengan penyaringan laporan.') }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Sign-off & Footer -->
    <div class="report-footer">
        <div class="footer-left">
            <p>{{ __('Laporan ini dihasilkan secara otomatis oleh Sistem HealthyWay.') }}</p>
        </div>
        <div class="footer-right">
            <div class="signature-title">{{ __('Tanda tangan Penanggung Jawab Admin') }}</div>
            <div class="signature-line">___________________________</div>
            <div class="signature-sub">{{ Auth::user()->name }}</div>
        </div>
    </div>

</body>
</html>
