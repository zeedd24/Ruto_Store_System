<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Shopping List — {{ \Carbon\Carbon::parse($laporan->tanggal)->format('d_m_Y') }}</title>
    <style>
        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            color: #1a1a1a;
            background: #ffffff;
            margin: 0;
            padding: 20px;
            font-size: 14px;
            line-height: 1.5;
        }
        .header {
            text-align: center;
            border-bottom: 2px double #000;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0 0 5px 0;
            font-size: 20px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .header p {
            margin: 0;
            color: #555;
            font-size: 12px;
        }
        .meta-info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 20px;
            font-size: 13px;
        }
        .meta-info div p {
            margin: 4px 0;
        }
        .meta-info strong {
            display: inline-block;
            width: 120px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #1a1a1a;
            padding: 8px 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 12px;
        }
        .status-badge {
            font-weight: bold;
            text-transform: uppercase;
            font-size: 11px;
        }
        .status-habis {
            color: #dc2626;
        }
        .status-menipis {
            color: #d97706;
        }
        .write-column {
            width: 120px;
        }
        .notes-section {
            border: 1px solid #000;
            padding: 10px;
            margin-top: 20px;
            background: #fafafa;
        }
        .notes-section h3 {
            margin: 0 0 5px 0;
            font-size: 12px;
            text-transform: uppercase;
            color: #555;
        }
        .notes-section p {
            margin: 0;
            font-size: 13px;
        }
        .no-print-btn {
            display: block;
            width: 200px;
            margin: 20px auto;
            padding: 10px;
            text-align: center;
            background: #2563eb;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 14px;
            font-weight: bold;
            cursor: pointer;
            text-decoration: none;
        }
        @media print {
            body {
                padding: 0;
            }
            .no-print-btn {
                display: none;
            }
        }
    </style>
</head>
<body>

    <button onclick="window.print()" class="no-print-btn">Cetak Daftar Belanja</button>

    <div class="header">
        <h1>RUTO STORE SYSTEM</h1>
        <p>Daftar Belanja Bahan Baku & Wadah</p>
    </div>

    <div class="meta-info">
        <div>
            <p><strong>Tanggal Laporan:</strong> {{ \Carbon\Carbon::parse($laporan->tanggal)->format('d/m/Y') }}</p>
            <p><strong>Dilaporkan Oleh:</strong> {{ $laporan->user->name }}</p>
        </div>
        <div>
            <p><strong>Waktu Cetak:</strong> {{ now()->format('d/m/Y H:i') }} WIB</p>
            <p><strong>Status:</strong> Siap Dibelanjakan</p>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%">No</th>
                <th>Nama Bahan Baku</th>
                <th>Kategori</th>
                <th style="width: 15%">Kondisi</th>
                <th style="width: 15%; text-align: right">Stok Sistem</th>
                <th class="write-column">Qty Belanja</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @forelse ($laporan->details->sortBy('status') as $detail)
                <tr>
                    <td style="text-align: center">{{ $no++ }}</td>
                    <td><strong>{{ $detail->produk->nama_produk }}</strong></td>
                    <td>{{ $detail->produk->kategori->nama_kategori }}</td>
                    <td>
                        <span class="status-badge {{ $detail->status === 'habis' ? 'status-habis' : 'status-menipis' }}">
                            {{ $detail->status }}
                        </span>
                    </td>
                    <td style="text-align: right">{{ $detail->produk->stok }}</td>
                    <td></td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 20px;">
                        Semua stok bahan baku aman. Tidak ada item yang perlu dibelanjakan.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    @if ($laporan->catatan)
        <div class="notes-section">
            <h3>Catatan Tambahan dari Kasir:</h3>
            <p>{{ $laporan->catatan }}</p>
        </div>
    @endif

    <script>
        // Auto-open print dialog
        window.onload = function() {
            setTimeout(function() {
                window.print();
            }, 500);
        };
    </script>
</body>
</html>
