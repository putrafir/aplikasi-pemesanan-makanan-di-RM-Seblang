<!DOCTYPE html>
<html>
<head>
    <title>Struk Pembayaran</title>
    <style>
        body {
            font-family: monospace;
            width: 280px;
            margin: auto;
        }
        hr { border: dashed 1px #000; }
        table { width: 100%; font-size: 12px; }
        td { padding: 2px 0; }
        .center { text-align: center; }
        .right { text-align: right; }
    </style>
</head>

<body onload="window.print()">

<div class="center">
    <strong>WARUNG SEBLANG</strong><br>
    ======================
</div>

<p>
    Meja : {{ $pesanan->nomor_meja }} <br>
    Tgl  : {{ $pesanan->waktu_bayar ?? $pesanan->created_at }}
</p>

<hr>

<table>
@foreach ($details as $item)
<tr>
    <td>{{ $item['nama'] }}</td>
</tr>
<tr>
    <td>{{ $item['jumlah'] }} x {{ number_format($item['harga']) }}</td>
    <td class="right">{{ number_format($item['subtotal']) }}</td>
</tr>
@endforeach
</table>

<hr>

<table>
<tr>
    <td>Total</td>
    <td class="right">{{ number_format($pesanan->total_bayar) }}</td>
</tr>
</table>

<hr>

<div class="center">
    Terima kasih 🙏<br>
    Selamat Menikmati
</div>

</body>
</html>
