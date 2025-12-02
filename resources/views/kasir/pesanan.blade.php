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

<body x-data="{ 'darkMode': false, 'sidebarToggle': false}" x-init="
         darkMode = JSON.parse(localStorage.getItem('darkMode'));
         $watch('darkMode', value => localStorage.setItem('darkMode', JSON.stringify(value)))"
    :class="{'dark bg-gray-900': darkMode === true}">

    @include('kasir.body.sidebar')
    @include('kasir.body.header')

    <div class="p-4">
        <div class=" overflow-x-auto shadow-md sm:rounded-lg">

            <td class="px-6 py-4">
                <form method="GET" action="{{ route('kasir.pesanan') }}">
                    <div class="flex align-items-center gap-5 mb-3">
                        <div>
                            <label for="date" class="form-label">Filter by Date</label>
                            <input type="date" name="date" value="{{ old('date', date('Y-m-d')) }}"
                                class="form-control">
                        </div>
                        <div>
                            <label for="status" class="form-label">Status Pesanan</label>
                            <select name="status" class="form-select">
                                <option value="">Select Status</option>
                                <option value="nonaktif" {{ request('status') == 'nonaktif' ? 'selected' : '' }}>
                                    Sudah di Antar</option>
                                <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>
                                    Belum di Antar</option>
                            </select>
                        </div>
                        <div>
                            <label for="status_bayar" class="form-label">Status Pembayaran</label>
                            <select name="status_bayar" class="form-select">
                                <option value="">Select Status</option>
                                <option value="sudah bayar"
                                    {{ request('status_bayar') == 'sudah bayar' ? 'selected' : '' }}>
                                    sudah bayar</option>
                                <option value="belum Bayar"
                                    {{ request('status_bayar') == 'belum bayar' ? 'selected' : '' }}>
                                    Belum Bayar</option>
                            </select>
                        </div>

                        <div>
                            <label class="form-label d-block invisible ">Filter</label>
                            <button type="submit" class="px-3 py-1 rounded font-semibold transition ">Filter</button>

                        </div>
                    </div>
                </form>
                <hr>
            </td>

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

                            <td class="px-6 py-4 flex gap-2">
                                <a href="{{ route('kasir.pesanan.detail', ['id' => $transaksi->id]) }}"
                                    class="font-medium text-green-600 dark:text-blue-500 hover:underline">Detail</a>
                                <a href="{{ route('kasir.bayar', ['id' => $transaksi->id]) }}"
                                    class="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                                    Bayar
                                </a>
                                <a href="{{  route('kasir.pesan.lagi', ['id' => $transaksi->id]) }}">
                                    <button type="button"
                                        class="font-medium text-purple-600 dark:text-purple-400 hover:underline">
                                        Pesan Lagi
                                    </button>

                                </a>
                                </form>
                            </td>
                            <td class="px-6 py-4">
                                <form action="{{ route('kasir.transaksi.updateStatus', $transaksi->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status_baru" value="{{ $transaksi->status === 'aktif' ? 'nonaktif' : 'aktif' }}">
                                    <button type="submit" class="px-3 py-1 rounded font-semibold transition {{ $transaksi->status === 'aktif' ? 'bg-blue-500 hover:bg-blue-600 text-white' : 'bg-green-500 hover:bg-green-600 text-white' }} btn-status">
                                        {{ $transaksi->status === 'aktif' ? 'Belum Diantar' : 'Sudah Diantar' }}
                                    </button>
                                </form>
                            </td>
                             <td>

                                <form action="{{ route('kasir.transaksi.updateStatusBayar', $transaksi->id) }}"
                                    method="POST">
                                    @csrf
                                    @method('PUT')

                                    <input type="hidden" name="statusbayar_baru"
                                        value="{{ $transaksi->status_bayar === 'belum bayar' ? 'sudah bayar' : 'belum bayar' }}">

                                    @php
                                        $isBayar = $transaksi->status_bayar === 'sudah bayar';
                                        $bgColor = $isBayar ? 'bg-green-600' : 'bg-red-600';
                                    @endphp

                                    <button type="submit" id="btn-status"
                                        class="px-3 py-2 rounded font-semibold transition  {{ $bgColor }} text-white  btn-status">
                                        {{ $transaksi->status_bayar }}
                                    </button>
                                </form>
                            </td>
                            <td>

                                <form action="{{ route('kasir.transaksi.updateStatusBayar', $transaksi->id) }}"
                                    method="POST">
                                    @csrf
                                    @method('PUT')

                                    <input type="hidden" name="statusbayar_baru"
                                        value="{{ $transaksi->status_bayar === 'belum bayar' ? 'sudah bayar' : 'belum bayar' }}">

                                    @php
                                        $isBayar = $transaksi->status_bayar === 'sudah bayar';
                                        $bgColor = $isBayar ? 'bg-green-600' : 'bg-blue-600';
                                    @endphp

                                    <button type="submit" id="btn-status"
                                        class="px-3 py-2 rounded font-semibold transition  {{ $bgColor }} text-white  ">
                                        {{ $transaksi->status_bayar }}
                                    </button>
                                </form>
                            </td>

                            {{-- <td class="px-6 py-4">
                                @if($transaksi->kasir)
                                    {{ $transaksi->kasir->id }} - {{ $transaksi->kasir->name }}
                                @else
                                    Kasir tidak ada
                                @endif
                            </td> --}}
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

    </div>

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

</body>

</html>
