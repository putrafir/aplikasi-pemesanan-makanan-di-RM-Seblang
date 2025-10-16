<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pesanan</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body x-data="{ 'darkMode': false, 'sidebarToggle': false}" x-init="
         darkMode = JSON.parse(localStorage.getItem('darkMode'));
         $watch('darkMode', value => localStorage.setItem('darkMode', JSON.stringify(value)))"
    :class="{'dark bg-gray-900': darkMode === true}">

    @include('kasir.body.sidebar')
    @include('kasir.body.header')

<div class="p-4">

    <div class=" container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-6 dark:text-white">Detail Pesanan</h1>

        <div class="mb-4 dark:text-white">
            <p><strong>Tanggal:</strong> {{ $pesanan->created_at->format('d M Y H:i') }}</p>
            <p><strong>Nomor Meja:</strong> {{ $pesanan->nomor_meja }}</p>
        </div>

        <table class="table-auto w-full border-collapse border border-gray-300 mb-6 dark:text-gray-400">
            <thead class="dark:bg-gray-700 dark:text-gray-400">
                <tr class="bg-gray-200">
                    <th class="border px-4 py-2">No</th>
                    <th class="border px-4 py-2">Nama Produk</th>
                    <th class="border px-4 py-2">Harga</th>
                    <th class="border px-4 py-2">Jumlah</th>
                    <th class="border px-4 py-2">Subtotal</th>
                    <th class="border px-4 py-2">Waktu Diantar</th>
                    <th class="border px-4 py-2">Waktu Bayar</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($details as $detail)
                    <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200">
                        <td class="border px-4 py-2">{{ $loop->iteration }}</td>
                        <td class="border px-4 py-2">{{ $detail['nama'] ?? '' }}</td>
                        <td class="border px-4 py-2">
                            @php echo number_format($detail['harga'], 0, ',', '.'); @endphp
                        </td>
                        <td class="border px-4 py-2">{{ $detail['jumlah'] }}</td>
                        <td class="border px-4 py-2">
                            @php echo number_format($detail['subtotal'], 0, ',', '.'); @endphp
                        </td>
                        <td class="border px-4 py-2">{{ $pesanan->waktu_diantar ?? '-' }}</td>
                        <td class="border px-4 py-2">{{ $pesanan->waktu_bayar ?? '-' }}</td>
                    </tr>
                    @endforeach

            </tbody>
        </table>

        <div class="text-right text-xl font-bold">
            Total Bayar: @php echo number_format($pesanan->total_bayar, 0, ',', '.'); @endphp
        </div>

        <div class="flex justify-between pt-4">
            <a href="{{ route('kasir.pesanan') }}"
                class="bg-white text-black font-bold px-6 py-2 rounded border border-gray-300 hover:bg-gray-200 transition flex items-center gap-2">
                <i class="fas fa-arrow-left"></i>
                Back
            </a>
            <div style="text-align: right; margin-top: 10px;">
                <form action="{{ route('kasir.destroy', $pesanan->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pesanan ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" style="padding: 10px 20px; background-color: red; color: white; border: none; border-radius: 5px; cursor: pointer;">
                        Hapus Pesanan
                    </button>
                </form>
            </div>
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
</div>
</body>

</html>
