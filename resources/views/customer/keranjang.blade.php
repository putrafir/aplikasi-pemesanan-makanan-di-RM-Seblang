<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body>

    <nav class="border-gray-200 bg-gray-50 dark:bg-gray-800 dark:border-gray-700">
        <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
            <a href="{{ route('customer.menu') }}"><svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                    viewBox="0 0 24 24">
                    <path fill-rule="evenodd"
                        d="M13.729 5.575c1.304-1.074 3.27-.146 3.27 1.544v9.762c0 1.69-1.966 2.618-3.27 1.544l-5.927-4.881a2 2 0 0 1 0-3.088l5.927-4.88Z"
                        clip-rule="evenodd" />
                </svg>
            </a>
            <a href="{{ route('customer.keranjang.view') }}">
                <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                    <path fill-rule="evenodd"
                        d="M4 4a1 1 0 0 1 1-1h1.5a1 1 0 0 1 .979.796L7.939 6H19a1 1 0 0 1 .979 1.204l-1.25 6a1 1 0 0 1-.979.796H9.605l.208 1H17a3 3 0 1 1-2.83 2h-2.34a3 3 0 1 1-4.009-1.76L5.686 5H5a1 1 0 0 1-1-1Z"
                        clip-rule="evenodd" />
                </svg>
            </a>




        </div>
    </nav>

    <div class="container mx-auto">
        <div class=" justify-between flex">
            <h1 class="text-2xl font-bold mb-4">Keranjang Belanja</h1>
            <h1 class="text-2xl font-bold mb-4">Total @php echo number_format($totalBayar, 0, ',', '.'); @endphp</h1>
        </div>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <table class="table-auto w-full border-collapse border border-gray-300">
            <thead>
                <tr>
                    <th class="border border-gray-300 px-4 py-2">#</th>
                    <th class="border border-gray-300 px-4 py-2">Nama Produk</th>
                    <th class="border border-gray-300 px-4 py-2">Harga</th>
                    <th class="border border-gray-300 px-4 py-2">Jumlah</th>
                    <th class="border border-gray-300 px-4 py-2">Subtotal</th>
                    <th class="border border-gray-300 px-4 py-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($keranjangs as $keranjang)
                    <tr>
                        <td class="border border-gray-300 px-4 py-2">{{ $loop->iteration }}</td>
                        <td class="border border-gray-300 px-4 py-2">
                            {{ $keranjang->menu->nama }}
                            @if ($keranjang->ukuran)
                                <div class="text-xs text-gray-500">(Ukuran: {{ $keranjang->ukuran }})</div>
                            @endif
                        </td>
                        <td class="border border-gray-300 px-4 py-2">
                            @php echo number_format($keranjang->harga_satuan, 0, ',', '.'); @endphp
                        </td>
                        <td class="border border-gray-300 px-4 py-2">{{ $keranjang->jumlah }}</td>
                        <td class="border border-gray-300 px-4 py-2">
                            @php echo number_format($keranjang->total_harga, 0, ',', '.'); @endphp
                        </td>
                        <td class="border border-gray-300 px-4 py-2">
                            <form action="{{ route('customer.keranjang.delete', $keranjang->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:underline">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-4">
            <form action="{{ route('customer.keranjang.checkout') }}" method="POST">
                @csrf
                <div class="mb-5">
                    <label for="nomor_meja" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nomor
                        Meja</label>
                    <select name="nomor_meja" id="nomor_meja" required
                        class="block w-full p-4 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-base focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value="">Pilih Nomor Meja</option>
                        @foreach ($nomor_mejas as $meja)
                            <option value="{{ $meja->nomor }}" {{ old('nomor_meja') == $meja->nomor ? 'selected' : '' }}>
                                Meja {{ $meja->nomor }}
                            </option>
                        @endforeach
                    </select>
                    
                </div>

                <button type="submit"
                    class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                    Pesan
                </button>
            </form>
        </div>
    </div>
</body>

</html>