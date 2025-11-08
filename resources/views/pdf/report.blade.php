<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Penjualan</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #333;
            font-size: 12px;
        }
        .container {
            width: 100%;
            margin: 0 auto;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #2c3e50;
        }
        .header p {
            margin: 5px 0;
            color: #7f8c8d;
        }
        .card {
            background-color: #f9f9f9;
            border: 1px solid #ecf0f1;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 20px;
        }
        .summary-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 20px;
        }
        .summary-item {
            background-color: #ffffff;
            border: 1px solid #ecf0f1;
            padding: 10px;
            border-radius: 5px;
        }
        .summary-item p {
            margin: 0;
            font-size: 11px;
            color: #7f8c8d;
        }
        .summary-item h3 {
            margin: 5px 0 0 0;
            font-size: 16px;
            color: #2c3e50;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .text-right {
            text-align: right;
        }
        .footer {
            text-align: center;
            font-size: 10px;
            color: #95a5a6;
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            height: 30px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Laporan Penjualan</h1>
            <p>Qio Coffee</p>
            <p>Periode: 
                @if ($isAllTime)
                    Semua Data ({{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }})
                @else
                    {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}
                @endif
            </p>
        </div>

        <div class="card">
            <div class="summary-grid">
                <div class="summary-item">
                    <p>Total Penjualan</p>
                    <h3>Rp {{ number_format($reportData['totalSales'] ?? 0, 0, ',', '.') }}</h3>
                </div>
                <div class="summary-item">
                    <p>Jumlah Transaksi</p>
                    <h3>{{ number_format($reportData['totalTransactions'] ?? 0, 0, ',', '.') }}</h3>
                </div>
                <div class="summary-item">
                    <p>Rata-rata per Transaksi</p>
                    <h3>Rp {{ number_format($reportData['averagePerTransaction'] ?? 0, 0, ',', '.') }}</h3>
                </div>
                <div class="summary-item">
                    <p>Total Produk Terjual</p>
                    <h3>{{ number_format($reportData['totalProductsSold'] ?? 0, 0, ',', '.') }}</h3>
                </div>
            </div>
        </div>

        <h3>Produk Terlaris</h3>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Produk</th>
                    <th class="text-right">Jumlah Terjual</th>
                    <th class="text-right">Total Pendapatan</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($reportData['topSellingProducts'] ?? [] as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item['product']['name'] ?? 'Produk Dihapus' }}</td>
                        <td class="text-right">{{ $item['total_sold'] }}</td>
                        <td class="text-right">Rp {{ number_format($item['total_revenue'], 0, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="text-align: center;">Tidak ada data.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <h3>Ringkasan Penjualan Harian</h3>
        <table>
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th class="text-right">Total Penjualan</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($reportData['dailySalesData'] ?? [] as $daily)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($daily['date'])->format('d M Y') }}</td>
                        <td class="text-right">Rp {{ number_format($daily['total'], 0, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" style="text-align: center;">Tidak ada data.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="footer">
            Laporan ini dibuat secara otomatis pada {{ now()->format('d M Y, H:i') }}
        </div>
    </div>
</body>
</html>
