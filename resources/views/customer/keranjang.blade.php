<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Keranjang Pesanan</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        /* Toast Animation */
        .toast {
            animation: slideIn 0.5s, fadeOut 0.5s 3s forwards;
        }

        @keyframes slideIn {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }

        @keyframes fadeOut {
            from { opacity: 1; }
            to { opacity: 0; transform: translateX(100%); }
        }

        /* Footer animation */
        .footer-anim {
            animation: slideUp 0.6s ease-out;
        }

        @keyframes slideUp {
            from {
                transform: translateY(100%);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }
    </style>
</head>

<body class="bg-blue-100" x-data="{ toast: '', showToast: false }">

     @include('customer.body.nav')

    <div class="container mx-auto mt-6 p-4 bg-white rounded-lg shadow-md">
        <div class="flex justify-between">
            <h1 class="text-2xl font-bold mb-8">Keranjang Anda</h1>
        </div>
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-4 py-2 text-center">No</th>
                        <th scope="col" class="px-4 py-2 text-center">Nama Produk</th>
                        <th scope="col" class="px-4 py-2 text-center">Harga</th>
                        <th scope="col" class="px-4 py-2 text-center">Jumlah</th>
                        <th scope="col" class="px-4 py-2 text-center">Subtotal</th>
                        <th scope="col" class="px-4 py-2 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($keranjangs as $keranjang)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                            <td class="px-4 py-2">{{ $loop->iteration }}</td>
                            <td scope="row" class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $keranjang->menu->nama }}
                                @if ($keranjang->ukuran)
                                    <div class="text-xs text-gray-500">(Ukuran: {{ $keranjang->ukuran }})</div>
                                @endif
                            </td>
                            <td class="px-4 py-2">
                                Rp. @php echo number_format($keranjang->harga_satuan, 0, ',', '.'); @endphp
                            </td>

                            {{-- QTY Buttons --}}
                            <td class="px-2 py-2 text-center">
                                <form action="{{ route('customer.keranjang.update', $keranjang->id) }}"
                                    method="POST" class="inline-flex items-center"
                                    x-data="{ jumlah: {{ $keranjang->jumlah }} }">
                                    @csrf
                                    @method('PUT')

                                    <!-- Tombol - -->
                                    <button type="submit" name="action" value="decrement"
                                        class="mx-1 px-3 py-1 bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold rounded-l transition">
                                        −
                                    </button>

                                    <!-- Input jumlah (animated bounce) -->
                                    <input type="number" name="jumlah" x-model="jumlah"
                                        class="w-13 text-center border-t border-b border-gray-300 focus:outline-none text-lg font-semibold transform transition-transform duration-150"
                                        x-effect="$el.classList.add('scale-110'); setTimeout(()=> $el.classList.remove('scale-110'),150)">

                                    <!-- Tombol + -->
                                    <button type="submit" name="action" value="increment"
                                        class="mx-1 px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-r transition">
                                        +
                                    </button>
                                </form>
                            </td>

                            <td class="px-4 py-2 text-center text-blue-600 font-semibold">
                                Rp. @php echo number_format($keranjang->total_harga, 0, ',', '.'); @endphp
                            </td>
                            <td class="px-4 py-2 text-center">
                                <form action="{{ route('customer.keranjang.delete', $keranjang->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="text-white bg-red-600 hover:bg-red-800 rounded-lg px-2 py-1">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        

        <!-- Checkout -->
        <div class="mt-8">
            <form action="{{ route('customer.keranjang.checkout') }}" method="POST">
                @csrf
                <div class="mb-5">
                    <label for="nomor_meja"
                        class="block mb-2 text-sm font-bold text-gray-900">Nomor Meja</label>
                    <select name="nomor_meja" id="nomor_meja" required
                        class="block w-full p-3 border border-gray-300 rounded-lg bg-gray-50">
                        <option value="">Pilih Nomor Meja</option>
                        @foreach ($nomor_mejas as $meja)
                            <option value="{{ $meja->nomor }}"
                                {{ old('nomor_meja') == $meja->nomor ? 'selected' : '' }}>
                                Meja {{ $meja->nomor }}
                            </option>
                        @endforeach
                    </select>
                </div>
        </div>
        <div class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 shadow-lg p-4 footer-anim">
            <div class="max-w-4xl mx-auto flex items-center justify-between">
                
                <!-- Harga -->
                <span class="text-2xl md:text-3xl font-bold text-blue-600">
                    Total Rp. @php echo number_format($totalBayar, 0, ',', '.'); @endphp
                </span>
                <div class="flex space-x-3">
                    <button type="submit"
                        class="w-20 text-white bg-blue-600 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-3">
                        Pesan
                    </button>
                </form>
                    
                    <button onclick="showPopUpAdd()" class="bg-white text-blue-600 border border-blue-600 px-4 py-2 rounded-lg hover:bg-blue-600 hover:text-white transition">
                        Lihat Detail
                    </button>
                    
                </div>
            </div>
        </div>
    </div>

    @if ($pesanan)
    <div id="popUpAdd" class="hidden fixed inset-0 z-50 flex items-center justify-center">
        <!-- Overlay -->
        <div class="absolute inset-0 bg-black bg-opacity-50" onclick="hidePopUpAdd()"></div>

        <!-- Modal content -->
        <div class="relative bg-white dark:bg-gray-800 rounded-lg shadow-lg w-full max-w-md z-10 p-6">
            <!-- Close button -->
            <button onclick="hidePopUpAdd()"
                class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 dark:hover:text-white text-xl font-bold">
                &times;
            </button>

            <h1 class="text-xl font-bold text-blue-900 dark:text-white mb-4">Ringkasan <p class="font-medium">Pesanan Anda</p></h1>
            <!-- Info tanggal & meja -->
            <div class="mb-4 text-sm text-gray-700 dark:text-gray-300">
                <p><b>Tanggal:</b> {{ $pesanan->created_at?->format('d M Y H:i') ?? 'Tanggal tidak tersedia' }}</p>
                <p><b>Nomor Meja:</b> {{ $pesanan->nomor_meja }}</p>
            </div>
            <!-- Daftar pesanan -->
            <div class="space-y-4">
                @php
                    $details = json_decode($pesanan->details, true);
                @endphp

                @foreach ($details as $detail)
                    <div class="flex items-center justify-between">
                        <div class="flex items-center justifiy-between space-x-5">
                            <p class="text-gray-800 dark:text-gray-200 font-medium">{{ $detail["nama"] }}</p>
                            <span class="text-sm text-gray-500">x {{ $detail["jumlah"] }}</span>
                        </div>
                        <span class="text-gray-800 dark:text-gray-200 font-medium">
                            Rp {{ number_format($detail["subtotal"], 0, ',', '.') }}
                        </span>
                    </div>
                @endforeach
            </div>

            <!-- Garis pemisah -->
            <hr class="my-4 border-gray-300 dark:border-gray-600">

            <!-- Total -->
            <div class="flex justify-between text-lg font-bold text-blue-400 dark:text-white">
                <span>Total:</span>
                <span>Rp {{ number_format($pesanan->total_bayar, 0, ',', '.') }}</span>
            </div>
        </div>
    </div>
    @endif

    <!-- Toast Notification -->
    <!-- Toast Container -->
    <div id="toast-container" class="fixed top-5 right-5 space-y-2 z-50"></div>

    <script>
        // Jika session success/error, munculkan toast
        @if (session('success'))
            // fungsi toast
            function showToast(message) {
                const container = document.getElementById("toast-container");
                const toast = document.createElement("div");
                toast.className = "toast bg-blue-600 text-white px-4 py-2 rounded-lg shadow-md";
                toast.innerText = message;
                container.appendChild(toast);

                // auto remove setelah animasi selesai
                setTimeout(() => {
                    toast.remove();
                }, 4000);
            }

            // cek apakah ada session flash dari Laravel
            @if(session('success'))
                showToast("{{ session('success') }}");
            @endif
        @endif

        @if (session('error'))
                function showToast(message) {
                const container = document.getElementById("toast-container");
                const toast = document.createElement("div");
                toast.className = "toast bg-red-600 text-white px-4 py-2 rounded-lg shadow-md";
                toast.innerText = message;
                container.appendChild(toast);

                // auto remove setelah animasi selesai
                setTimeout(() => {
                    toast.remove();
                }, 4000);
            }

            // cek apakah ada session flash dari Laravel
            @if(session('error'))
                showToast("{{ session('error') }}");
            @endif
        @endif
    </script>

    <script>
        function showPopUpAdd() {
            document.getElementById('popUpAdd').classList.remove('hidden');
        }

        function hidePopUpAdd() {
            document.getElementById('popUpAdd').classList.add('hidden');
        }
    </script>
</body>

</html>
