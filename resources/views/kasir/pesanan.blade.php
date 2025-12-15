<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Toastr CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <title>Document</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('backend/js/code.js') }}"></script>
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
        <div class="ml-5 overflow-x-auto shadow-md sm:rounded-lg">

            @php
    $tab = request('tab', 'semua');
@endphp

<div class="flex gap-2 mb-4">
    
    <!-- Semua Pesanan -->
    <a href="{{ route('kasir.pesanan', ['tab' => 'semua']) }}"
       class="px-4 py-2 rounded-lg text-sm font-semibold border transition
       {{ $tab === 'semua'
            ? 'bg-blue-600 text-white border-blue-600'
            : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-100'
       }}">
        Semua Pesanan
    </a>
    <!-- Pesanan Baru -->
    <a href="{{ route('kasir.pesanan', ['tab' => 'baru']) }}"
       class="px-4 py-2 rounded-lg text-sm font-semibold border transition
       {{ $tab === 'baru'
            ? 'bg-blue-600 text-white border-blue-600'
            : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-100'
       }}">
        Pesanan Baru
    </a>

    <!-- Belum Bayar -->
    <a href="{{ route('kasir.pesanan', ['tab' => 'belum-bayar']) }}"
       class="px-4 py-2 rounded-lg text-sm font-semibold border transition
       {{ $tab === 'belum-bayar'
            ? 'bg-blue-600 text-white border-blue-600'
            : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-100'
       }}">
        Belum Bayar
    </a>

    <!-- Pesanan Selesai -->
    <a href="{{ route('kasir.pesanan', ['tab' => 'selesai']) }}"
       class="px-4 py-2 rounded-lg text-sm font-semibold border transition
       {{ $tab === 'selesai'
            ? 'bg-blue-600 text-white border-blue-600'
            : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-100'
       }}">
        Pesanan Selesai
    </a>
</div>

<form method="GET" action="{{ route('kasir.pesanan') }}" class="mb-4">
    <input type="hidden" name="tab" value="{{ request('tab', 'baru') }}">

    <div class="flex gap-3 items-end">
        <div>
            <label class="text-sm font-medium dark:text-white">Filter Tanggal</label>
            <input
                type="date"
                name="date"
                value="{{ request('date', date('Y-m-d')) }}"
                class="border rounded px-3 py-2 text-sm"
            >
        </div>

        <button
            type="submit"
            class="px-4 py-2 rounded bg-blue-600 text-white text-sm font-semibold">
            Filter
        </button>
    </div>
</form>





            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Tanggal
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Nomor Meja
                        </th>
                        <th scope="col" class="px-6 py-3">
                            kembalian
                        </th>

                        <th scope="col" class="px-6 py-3">
                            Action
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Status Pesanan
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Status Pembayaran
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Kasir
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transaksis as $transaksi)
                        <tr
                            class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200">
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $transaksi->created_at->format('d M Y H:i') }}
                            </th>
                            <td class="px-6 py-4">
                                {{ $transaksi->nomor_meja }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $transaksi->kembalian }}

                            </td>

                            <td class="px-6 py-4">
                                <div class="flex flex-wrap gap-2">
                                    <!-- Detail -->
                                    <a href="{{ route('kasir.pesanan.detail', ['id' => $transaksi->id]) }}"
                                    class="inline-flex items-center gap-1 px-3 py-1.5
                                            rounded-lg text-sm font-semibold
                                            bg-green-600 hover:bg-green-700
                                            text-white transition">
                                        Detail
                                    </a>

                                    <!-- Bayar -->
                                    <a href="{{ route('kasir.bayar', ['id' => $transaksi->id]) }}"
                                    class="inline-flex items-center gap-1 px-3 py-1.5
                                            rounded-lg text-sm font-semibold
                                            bg-blue-600 hover:bg-blue-700
                                            text-white transition">
                                        Bayar
                                    </a>

                                    <!-- Pesan Lagi -->
                                    <a href="{{ route('kasir.pesan.lagi', ['id' => $transaksi->id, 'from' => 'kasir']) }}"
                                    class="inline-flex items-center gap-1 px-3 py-1.5
                                            rounded-lg text-sm font-semibold
                                            bg-purple-600 hover:bg-purple-700
                                            text-white transition">
                                        Pesan Lagi
                                    </a>
                                </div>
                            </td>

                            <td class="px-6 py-4">
                                <form
                                    action="{{ route('kasir.transaksi.updateStatus', $transaksi->id) }}"
                                    method="POST"
                                    class="form-status-toggle"
                                >
                                    @csrf
                                    @method('PUT')

                                    <input type="hidden" name="status_baru"
                                        value="{{ $transaksi->status === 'aktif' ? 'nonaktif' : 'aktif' }}">

                                    <div class="flex items-center gap-3">
                                        <!-- Toggle -->
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input
                                                type="checkbox"
                                                class="sr-only peer status-toggle"
                                                data-status="{{ $transaksi->status }}"
                                                {{ $transaksi->status === 'nonaktif' ? 'checked' : '' }}
                                            >

                                            <div class="w-11 h-6 bg-gray-300 rounded-full peer
                                                peer-checked:bg-blue-600
                                                after:content-[''] after:absolute after:top-0.5 after:left-[2px]
                                                after:bg-white after:border after:rounded-full after:h-5 after:w-5
                                                after:transition-all peer-checked:after:translate-x-full">
                                            </div>
                                        </label>

                                        <!-- Text -->
                                        <span class="text-sm font-semibold
                                            {{ $transaksi->status === 'nonaktif'
                                                ? 'text-blue-600'
                                                : 'text-gray-600' }}">
                                            {{ $transaksi->status === 'nonaktif'
                                                ? 'Sudah Diantar'
                                                : 'Belum Diantar' }}
                                        </span>
                                    </div>
                                </form>
                            </td>
                             <td class="px-6 py-4">
                                <form
                                    action="{{ route('kasir.transaksi.updateStatusBayar', $transaksi->id) }}"
                                    method="POST"
                                    class="form-status-bayar"
                                >
                                    @csrf
                                    @method('PUT')

                                    <input type="hidden" name="statusbayar_baru"
                                        value="{{ $transaksi->status_bayar === 'belum bayar' ? 'sudah bayar' : 'belum bayar' }}">

                                    <div class="flex items-center gap-3">
                                        <!-- Toggle -->
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input
                                                type="checkbox"
                                                class="sr-only peer status-bayar-toggle"
                                                data-status="{{ $transaksi->status_bayar }}"
                                                {{ $transaksi->status_bayar === 'sudah bayar' ? 'checked' : '' }}
                                            >

                                            <div class="w-11 h-6 bg-gray-300 rounded-full peer
                                                peer-checked:bg-green-600
                                                after:content-[''] after:absolute after:top-0.5 after:left-[2px]
                                                after:bg-white after:border after:rounded-full after:h-5 after:w-5
                                                after:transition-all peer-checked:after:translate-x-full">
                                            </div>
                                        </label>

                                        <!-- Text -->
                                        <span class="text-sm font-semibold
                                            {{ $transaksi->status_bayar === 'sudah bayar'
                                                ? 'text-green-600'
                                                : 'text-red-600' }}">
                                            {{ $transaksi->status_bayar === 'sudah bayar'
                                                ? 'Sudah Bayar'
                                                : 'Belum Bayar' }}
                                        </span>
                                    </div>
                                </form>
                            </td>

                            <td class="px-6 py-4">
                                @if($transaksi->kasir)
                                    {{ $transaksi->kasir->id }} - {{ $transaksi->kasir->name }}
                                @else
                                    Kasir tidak ada
                                @endif
                            </td>
                        </tr>
                    @endforeach


                </tbody>
            </table>

            @if (session()->has('success'))
                <div class="bg-white">
                    {{ session('success') }}
                </div>
            @endif
            @if (session()->has('error'))
                <div class="bg-white">
                    {{ session('error') }}
                </div>
            @endif
        </div>

    </main>

    <script>
        @if (Session::has('message'))
            var type = "{{ Session::get('alert-type', 'info') }}"
            switch (type) {
                case 'info':
                    toastr.info(" {{ Session::get('message') }} ");
                    break;

                case 'success':
                    toastr.success(" {{ Session::get('message') }} ");
                    break;

                case 'warning':
                    toastr.warning(" {{ Session::get('message') }} ");
                    break;

                case 'error':
                    toastr.error(" {{ Session::get('message') }} ");
                    break;
            }
        @endif
    </script>

    <script>
document.querySelectorAll('.status-toggle').forEach(toggle => {
    toggle.addEventListener('change', function (e) {
        e.preventDefault();

        const form = this.closest('form');
        const currentStatus = this.dataset.status;

        const nextText =
            currentStatus === 'aktif'
                ? 'menandai pesanan sebagai SUDAH DIANTAR'
                : 'mengubah status kembali menjadi BELUM DIANTAR';

        Swal.fire({
            title: 'Konfirmasi Perubahan',
            text: `Apakah Anda yakin ingin ${nextText}?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#2563eb',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, lanjutkan',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            } else {
                // kembalikan posisi toggle
                this.checked = !this.checked;
            }
        });
    });
});
</script>


</body>

</html>
