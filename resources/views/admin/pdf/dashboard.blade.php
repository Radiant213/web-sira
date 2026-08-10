<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Dashboard SIRA</title>
    <style>
        body {
            font-family: sans-serif;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #e11d48;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .header h1 {
            margin: 0;
            color: #0f172a;
            font-size: 24px;
        }
        .header p {
            margin: 5px 0 0 0;
            color: #64748b;
            font-size: 14px;
        }
        .stats-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 40px;
        }
        .stats-table th, .stats-table td {
            border: 1px solid #e2e8f0;
            padding: 12px;
            text-align: left;
        }
        .stats-table th {
            background-color: #f8fafc;
            color: #475569;
            font-size: 14px;
        }
        .stats-table td {
            font-size: 14px;
            font-weight: bold;
        }
        .chart-container {
            text-align: center;
            margin-top: 20px;
        }
        .chart-container img {
            max-width: 100%;
            height: auto;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 10px;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 12px;
            color: #94a3b8;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Laporan Statistik SIRA</h1>
        <p>Sistem Informasi & Pelaporan RT/RW</p>
        <p>Dicetak pada: {{ now()->format('d M Y, H:i') }}</p>
    </div>

    <table class="stats-table">
        <tr>
            <th>Total Warga Terdaftar</th>
            <td>{{ $stats['total_warga'] }}</td>
            <th>Menunggu Verifikasi</th>
            <td>{{ $stats['warga_pending'] }}</td>
        </tr>
        <tr>
            <th>Surat Pengantar Pending</th>
            <td>{{ $stats['surat_pending'] }}</td>
            <th>Pengaduan Aktif</th>
            <td>{{ $stats['pengaduan_pending'] }}</td>
        </tr>
        <tr>
            <th>Total Iuran Lunas</th>
            <td style="color: #059669;">Rp {{ number_format($stats['total_iuran'], 0, ',', '.') }}</td>
            <th>Warga Belum Bayar Iuran</th>
            <td style="color: #e11d48;">{{ $stats['iuran_belum_bayar'] }}</td>
        </tr>
    </table>

    @if($chartImage)
        <div class="chart-container">
            <h3>Grafik Aktivitas</h3>
            <img src="{{ $chartImage }}" alt="Grafik Aktivitas">
        </div>
    @endif

    <div class="footer">
        Dicetak secara otomatis oleh sistem.
    </div>
</body>
</html>
