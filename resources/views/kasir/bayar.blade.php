<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bayar Pesanan</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-4 max-w-4xl">

        <!-- Notifikasi -->
        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Card Utama -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h1 class="text-2xl font-bold mb-4">Bayar Pesanan #{{ $pesanan->id }}</h1>

            <!-- Detail Pesanan -->
            <div class="mb-6">
                <h2 class="text-lg font-semibold mb-2">Detail Pesanan</h2>
                <table class="min-w-full border">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="py-2 px-4 border">Item</th>
                            <th class="py-2 px-4 border">Harga</th>
                            <th class="py-2 px-4 border">Jumlah</th>
                            <th class="py-2 px-4 border">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pesanan->items as $item)
                        <tr>
                            <td class="py-2 px-4 border">{{ $item->nama }}</td>
                            <td class="py-2 px-4 border">Rp{{ number_format($item->harga, 0, ',', '.') }}</td>
                            <td class="py-2 px-4 border">{{ $item->jumlah }}</td>
                            <td class="py-2 px-4 border">Rp{{ number_format($item->harga * $item->jumlah, 0, ',', '.') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="py-2 px-4 border text-center text-red-500">Tidak ada item dalam pesanan.</td>
                        </tr>
                        @endforelse
                        <tr class="bg-gray-50 font-semibold">
                            <td colspan="3" class="py-2 px-4 border text-right">Total</td>
                            <td class="py-2 px-4 border">
                                Rp{{ number_format($total ?? 0, 0, ',', '.') }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Form Pembayaran -->
            @if($pesanan->status === 'dibayar')
                <div class="p-4 bg-green-50 rounded-lg">
                    <p class="text-green-700 font-medium">Pesanan ini sudah dibayar.</p>
                    <p class="mt-2">Metode Pembayaran: {{ ucfirst($pesanan->metode_pembayaran) }}</p>
                </div>
            @elseif($pesanan->items->isEmpty())
                <div class="p-4 bg-yellow-100 border border-yellow-400 text-yellow-800 rounded">
                    Pesanan ini belum memiliki item. Tambahkan item terlebih dahulu sebelum melakukan pembayaran.
                </div>
            @else
                <form action="{{ route('pesanan.bayar.proses', $pesanan->id) }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="jumlah_bayar" class="block mb-1 font-medium">Jumlah Dibayar</label>
                            <input type="number" name="jumlah_bayar" id="jumlah_bayar"
                                   min="{{ $total }}"
                                   required
                                   class="w-full p-2 border rounded"
                                   placeholder="Contoh: {{ $total }}">
                        </div>
                        <div>
                            <label for="metode_pembayaran" class="block mb-1 font-medium">Metode Pembayaran</label>
                            <select name="metode_pembayaran" id="metode_pembayaran" required class="w-full p-2 border rounded">
                                <option value="">Pilih Metode</option>
                                <option value="tunai">Tunai</option>
                                <option value="qris">QRIS</option>
                            </select>
                        </div>
                    </div>

                    {{-- <div class="flex justify-between items-center">
                        <a href="{{ route('kasir.pesanan') }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                            Kembali
                        </a>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                            Proses Pembayaran
                        </button>
                    </div> --}}
                </form>
            @endif
        </div>
    </div>
</body>
</html>