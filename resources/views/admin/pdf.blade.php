<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Laporan Transaksi</title>
    <style>
        * {
            font-family: Verdana, Arial, sans-serif;
        }

        table {
            font-size: small;
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
        }

        th {
            background-color: #007BFF;
            color: white;
        }

        h2 {
            text-align: center;
            color: black;
            margin-bottom: 5px;
        }

        .periode {
            text-align: center;
            font-size: 13px;
            margin-bottom: 15px;
        }

        .total {
            text-align: right;
            margin-top: 10px;
            font-weight: bold;
            font-size: 14px;
        }
    </style>
</head>

<body>
    <h2>Laporan Transaksi</h2>
    <p class="periode">Periode: {{ $tanggalAwal->format('d M Y') }} - {{ $tanggalAkhir->format('d M Y') }}</p>

    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Nomor Meja</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transaksis as $transaksi)
                <tr>
                    <td>{{ $transaksi->created_at->format('d M Y H:i') }}</td>
                    <td>{{ $transaksi->nomor_meja }}</td>
                    <td>Rp{{ number_format($transaksi->total_bayar, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p class="total">
        Total Pendapatan: Rp{{ number_format($totalPendapatan, 0, ',', '.') }}
    </p>
</body>

</html>
