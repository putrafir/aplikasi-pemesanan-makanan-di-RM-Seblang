<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <title>Document</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body x-data="{ 'darkMode': false, 'sidebarToggle': false }" x-init="darkMode = JSON.parse(localStorage.getItem('darkMode'));
$watch('darkMode', value => localStorage.setItem('darkMode', JSON.stringify(value)))" :class="{ 'dark bg-gray-900': darkMode === true }"
    class=" relative min-w-screen">




    @include('admin.body.sidebar')
    @include('admin.body.header')

    <div class="p-4 ">

        <div class=" overflow-x-auto shadow-md sm:rounded-lg">
            <div class="mb-4">
                <h2 class="text-xl text-blue-500 font-bold mb-4">
                    Hasil Pencarian dari {{ $tanggalAwal->format('d M Y') }} sampai {{ $tanggalAkhir->format('d M Y') }}
                </h2>

                <h2 class="text-xl text-blue-500 font-bold mb-2">
                    Total Pendapatan:
                    <span class="text-green-600">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</span>
                </h2>

                <a href="{{ route('laporan.pdf', ['tanggalAwal' => $tanggalAwal->format('Y-m-d'), 'tanggalAkhir' => $tanggalAkhir->format('Y-m-d')]) }}"
                    class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded shadow mt-2">
                    <i class="fa fa-print"></i> Print
                </a>
            </div>



            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Tanggal
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Meja
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Total
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Action
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
                                Rp{{ number_format($transaksi->total_bayar, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{ route('admin.pesanan.detail', ['id' => $transaksi->id]) }}"
                                    class="font-medium text-red-500 dark:text-blue-500 hover:underline"><i
                                        class="fas fa-eye  me-1"></i>Detail</a>
                            </td>

                        </tr>
                    @endforeach


                </tbody>
            </table>

        </div>

    </div>
</body>

</html>
