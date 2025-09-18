<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pesanan</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div class="container mx-auto p-6">

        <h1 class="text-2xl font-bold mb-6">Detail Pesanan Anda</h1>

        <div class="mb-4">
            <p><strong>Tanggal:</strong> {{ $pesanan->created_at->format('d M Y H:i') }}</p>
            <p><strong>Nomor Meja:</strong> {{ $pesanan->nomor_meja }}</p>
        </div>

        <table class="table-auto w-full border-collapse border border-gray-300 mb-6">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border px-4 py-2">No</th>
                    <th class="border px-4 py-2">Nama Produk</th>
                    <th class="border px-4 py-2">Harga</th>
                    <th class="border px-4 py-2">Jumlah</th>
                    <th class="border px-4 py-2">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $details = json_decode($pesanan->details, true);
                @endphp
                @foreach ($details as $detail)
                    <tr>
                        <td class="border px-4 py-2">{{ $loop->iteration }}</td>
                        <td class="border px-4 py-2">{{ $detail['nama'] }}</td>

                        <td class="border px-4 py-2">@php echo number_format($detail["harga"], 0, ',', '.'); @endphp</td>
                        <td class="border px-4 py-2">{{ $detail['jumlah'] }}</td>
                        <td class="border px-4 py-2">@php echo number_format($detail["subtotal"], 0, ',', '.'); @endphp</td>
                    </tr>
                @endforeach

            </tbody>
        </table>

        <div class="text-right text-xl font-bold">
            Total Bayar: @php echo number_format($pesanan->total_bayar, 0, ',', '.'); @endphp
        </div>

        <div style="text-align: left; margin-top: 10px;">

            <a href="{{ route('customer.keranjang.view') }}" type="submit"
                style="padding: 10px 20px; background-color: blue; color: white; border: none; border-radius: 5px; cursor: pointer;">
                Kembali
            </a>
        </div>

        <div class="mt-6">
            {{-- <form action="{{ route('admin.pesanan.bayar', $pesanan->id) }}" method="POST">
                @csrf
                <button type="submit"
                    class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                    Bayar Sekarang
                </button>
            </form> --}}
        </div>
    </div>
</body>


</html>
