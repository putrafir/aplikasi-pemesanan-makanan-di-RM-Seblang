<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bayar Pesanan</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body x-data="{ darkMode: false, sidebarToggle: false }"
  x-init="
    darkMode = JSON.parse(localStorage.getItem('darkMode')) ?? false;
    $watch('darkMode', value => localStorage.setItem('darkMode', JSON.stringify(value)))
  "
  :class="{
    'dark bg-gray-900': darkMode,
    'bg-gray-100': !darkMode
  }" class=" relative min-w-screen">

    @include('kasir.body.sidebar')
    <!-- OVERLAY (klik → tutup sidebar) -->
  <div
    x-show="sidebarToggle"
    @click="sidebarToggle = false"
    class="fixed inset-0 z-40 bg-black/50 lg:hidden"
    x-transition.opacity
  ></div>
    @include('kasir.body.header')

    <main
  class="pt-16 min-h-screen transition-all duration-300
         dark:bg-gray-900
         lg:ml-64"
>

<nav class="flex text-gray-500 mb-5 ml-5" aria-label="Breadcrumb">
  <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
    <li class="inline-flex items-center">
      <a href="{{ route('kasir.dashboard') }}" class="inline-flex items-center text-sm font-medium text-body hover:text-fg-brand">
        <svg class="w-4 h-4 me-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m4 12 8-8 8 8M6 10.5V19a1 1 0 0 0 1 1h3v-3a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3h3a1 1 0 0 0 1-1v-8.5"/></svg>
        Beranda
      </a>
    </li>
    <li>
      <div class="flex items-center space-x-1.5">
        <svg class="w-3.5 h-3.5 rtl:rotate-180 text-body" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 5 7 7-7 7"/></svg>
        <a href="{{ route('kasir.pesanan') }}" class="inline-flex items-center text-sm font-medium text-body hover:text-fg-brand">Pesanan</a>
      </div>
    </li>
    <li aria-current="page">
      <div class="flex items-center space-x-1.5">
        <svg class="w-3.5 h-3.5 rtl:rotate-180 text-body" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 5 7 7-7 7"/></svg>
        <span class="inline-flex items-center text-sm font-medium text-body-subtle">Bayar Pesanan</span>
      </div>
    </li>
  </ol>
</nav>

    <div class=" container mx-auto p-6 dark:text-gray-200 dark:bg-gray-900">

        <!-- Notifikasi -->
        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Card Utama -->
        <div class="bg-white rounded-lg shadow-md p-6 dark:bg-gray-800">
            <h1 class="text-2xl font-bold mb-4">Bayar Pesanan Nomor Meja {{ $transaksis->nomor_meja}}</h1>

            <!-- Detail Pesanan -->
            <div class="mb-6">
                <h2 class="text-lg font-semibold mb-2">Detail Pesanan</h2>
                <table class="min-w-full border dark:text-gray-500 dark:border-gray-700 dark:bg-gray-800">
                    <thead class="dark:bg-gray-700 dark:text-gray-500">
                        <tr class="bg-gray-100">
                            <th class="py-2 px-4 border">Item</th>
                            <th class="py-2 px-4 border">Harga</th>
                            <th class="py-2 px-4 border">Jumlah</th>
                            <th class="py-2 px-4 border">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="dark:text-white">
                        @php
                            $total = 0 ;
                        @endphp
                        @forelse($pesanan as $item)
                            <tr>
                                <td class="py-2 px-4 border">{{ $item['nama'] }}</td>
                                @php
                                    $total += $item['subtotal'];
                                @endphp
                                <td class="py-2 px-4 border">Rp{{    number_format($item['harga'], 0, ',', '.') }}</td>
                                <td class="py-2 px-4 border">{{ $item['jumlah'] }}</td>
                                <td class="py-2 px-4 border">
                                    Rp{{ number_format($item['harga'] * $item['jumlah'], 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-2 px-4 border text-center text-red-500">Tidak ada item
                                    dalam pesanan.</td>
                            </tr>
                        @endforelse
                        <tr class="bg-gray-50 font-semibold dark:bg-gray-700 dark:text-gray-200">
                            <td colspan="3" class="py-2 px-4 border text-right">Total</td>
                            <td class="py-2 px-4 border">
                                Rp{{ number_format($total ?? 0, 0, ',', '.') }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Form Pembayaran -->
            {{-- @if ($pesanan->status === 'dibayar')
                <div class="p-4 bg-green-50 rounded-lg">
                    <p class="text-green-700 font-medium">Pesanan ini sudah dibayar.</p>
                    <p class="mt-2">Metode Pembayaran: {{ ucfirst($pesanan->metode_pembayaran) }}</p>
                </div> --}}
            {{-- @elseif($pesanan->items->isEmpty())
                <div class="p-4 bg-yellow-100 border border-yellow-400 text-yellow-800 rounded">
                    Pesanan ini belum memiliki item. Tambahkan item terlebih dahulu sebelum melakukan pembayaran.
                </div>
            @else --}}
                <form action="{{ route('pesanan.bayar.proses', $transaksis->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="uang_dibayarkan" class="block mb-1 font-medium">Jumlah Dibayar</label>
                            <input type="number" name="uang_dibayarkan" id="uang_dibayarkan" min="{{ $total }}"
                                required class="w-full p-2 border rounded
               text-gray-900 placeholder-gray-400
               bg-white border-gray-300
               dark:bg-gray-800 dark:border-gray-600
               dark:text-gray-200 dark:placeholder-gray-400" placeholder="Contoh: {{ $total }}">
                        </div>
                        <div>
                            <label for="metode_pembayaran" class="block mb-1 font-medium">Metode Pembayaran</label>
                            <select name="metode_pembayaran" id="metode_pembayaran" required
                                class="w-full p-2 border rounded
               bg-white text-gray-900 border-gray-300
               dark:bg-gray-800 dark:border-gray-600 dark:text-gray-200">
                                <option value="tunai" class="dark:text-gray-400">Tunai</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex justify-between items-center">
                        <a href="{{ route('kasir.pesanan') }}"
                            class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                            Kembali
                        </a>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                            Proses Pembayaran Rp. {{ number_format($total, 0, ',', '.') }}
                        </button>
                    </div>
                </form>


        </div>
    </div>

 
    </form>
    {{-- @endif --}}
    </div>
    </div>
</main>

@if(session('popup_bayar'))
<script>
Swal.fire({
    title: 'Transaksi Berhasil',
    html: `
        <p class="mb-2">Uang Kembali:</p>
        <p class="text-xl font-bold text-green-600">
            Rp {{ number_format(session('kembalian'),0,',','.') }}
        </p>
    `,
    icon: 'success',
    showCancelButton: true,
    confirmButtonText: 'Cetak Struk',
    cancelButtonText: 'Tutup',
    confirmButtonColor: '#2563eb'
}).then((result) => {
    if (result.isConfirmed) {
        printStruk()
    } else {
        window.location.href = "{{ route('kasir.pesanan') }}"
    }
})
</script>
@endif


<script>
function printStruk() {
    const printWindow = window.open('', '_blank', 'width=400,height=600')

    printWindow.document.write(`
        <html>
        <head>
            <title>Struk Pembayaran</title>
            <style>
                body {
                    font-family: monospace;
                    padding: 10px;
                }
                h2 {
                    text-align: center;
                }
                table {
                    width: 100%;
                    border-collapse: collapse;
                    margin-top: 10px;
                }
                td {
                    padding: 4px 0;
                }
                .total {
                    border-top: 1px dashed #000;
                    margin-top: 10px;
                    padding-top: 5px;
                    font-weight: bold;
                }
                .center {
                    text-align: center;
                    margin-top: 10px;
                }
            </style>
        </head>
        <body>
            <h2>WARUNG SEBLANG</h2>
            <p class="center">Meja: {{ $transaksis->nomor_meja }}</p>
            <p class="center">{{ now()->format('d/m/Y H:i') }}</p>

            <table>
                @foreach($pesanan as $item)
                <tr>
                    <td>{{ $item['nama'] }} x{{ $item['jumlah'] }}</td>
                    <td align="right">
                        Rp{{ number_format($item['subtotal'],0,',','.') }}
                    </td>
                </tr>
                @endforeach
            </table>

            <div class="total">
                Total : Rp{{ number_format($total,0,',','.') }}<br>
                Bayar : Rp{{ number_format($transaksis->uang_dibayarkan ?? $total,0,',','.') }}<br>
                Kembali : Rp{{ number_format(session('kembalian'),0,',','.') }}
            </div>

            <p class="center">Terima Kasih 🙏</p>

            <script>
                window.print()
                window.onafterprint = function () {
                    window.close()
                    window.opener.location.href = "{{ route('kasir.pesanan') }}"
                }
            <\/script>
        </body>
        </html>
    `)

    printWindow.document.close()
}
</script>


</body>

</html>