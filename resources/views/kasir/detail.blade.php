<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pesanan</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
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
        <span class="inline-flex items-center text-sm font-medium text-body-subtle">Detail Pesanan</span>
      </div>
    </li>
  </ol>
</nav>

    <div class=" container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-6 dark:text-white">Detail Pesanan Nomor Meja {{ $pesanan->nomor_meja }}</h1>

        <div class="mb-4 dark:text-white">
            <p><strong>Tanggal:</strong> {{ $pesanan->created_at->format('d M Y H:i') }}</p>
        </div>

        <div class="hidden md:block">
            <table class="table-auto w-full border-collapse border border-gray-300 mb-6 dark:text-gray-500">
            <thead class="dark:bg-gray-700 dark:text-gray-400">
                <tr class="bg-gray-200">
                    <th class="border px-4 py-2">No</th>
                    <th class="border px-4 py-2">Nama Produk</th>
                    <th class="border px-4 py-2">Harga</th>
                    <th class="border px-4 py-2">Jumlah</th>
                    <th class="border px-4 py-2">Subtotal</th>
                    <th class="border px-4 py-2">Catatan</th>
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
                        <td class="border px-4 py-2">{{ $detail['catatan'] ?? '-' }}</td>
                        <td class="border px-4 py-2">{{ $pesanan->waktu_diantar ?? '-' }}</td>
                        <td class="border px-4 py-2">{{ $pesanan->waktu_bayar ?? '-' }}</td>
                    </tr>
                    @endforeach

            </tbody>
        </table>
        </div>

        <div class="md:hidden space-y-4">
    @foreach ($details as $detail)
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 mb-5">
        <div class="flex justify-between mb-2">
            <h3 class="font-semibold text-lg dark:text-white">
                {{ $detail['nama'] }}
            </h3>
            <span class="text-sm text-gray-500">
                x{{ $detail['jumlah'] }}
            </span>
        </div>

        <div class="text-sm space-y-1 text-gray-600 dark:text-gray-300">
            <div class="flex justify-between">
                <span>Harga</span>
                <span>Rp {{ number_format($detail['harga'],0,',','.') }}</span>
            </div>

            <div class="flex justify-between font-semibold">
                <span>Subtotal</span>
                <span>Rp {{ number_format($detail['subtotal'],0,',','.') }}</span>
            </div>

            <div>
                <span class="font-medium">Catatan:</span>
                <span>{{ $detail['catatan'] ?? '-' }}</span>
            </div>
        </div>

        <div class="border-t mt-3 pt-2 text-xs text-gray-500">
            <div>Diantar: {{ $pesanan->waktu_diantar ?? '-' }}</div>
            <div>Bayar: {{ $pesanan->waktu_bayar ?? '-' }}</div>
        </div>
    </div>
    @endforeach
</div>

        

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

        <div class="flex justify-end gap-3 mt-6">

            {{-- Tombol Cetak Struk (hanya jika sudah bayar) --}}
            @if ($pesanan->status_bayar === 'sudah bayar')
                <a href="{{ route('kasir.pesanan.cetak', $pesanan->id) }}"
                target="_blank"
                class="bg-blue-600 hover:bg-blue-800 text-white font-semibold px-6 py-2 rounded flex items-center gap-2">
                    <i class="fas fa-print"></i>
                    Cetak Struk
                </a>
            @endif

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
</main>

<!-- MODAL EDIT PESANAN -->
{{-- <div id="editModal"
    class="fixed inset-0 bg-black/50 hidden z-50 flex items-center justify-center">

    <div class="bg-white dark:bg-gray-800 w-full max-w-3xl rounded-lg shadow-lg p-6">
        <h2 class="text-xl font-bold mb-4 dark:text-white">Edit Pesanan</h2>

        <form action="{{ route('kasir.update', $pesanan->id) }}" method="POST">
            @csrf
            @method('PUT')

            <table class="w-full border mb-4 dark:text-gray-300">
                <thead class="bg-gray-100 dark:bg-gray-700">
                    <tr>
                        <th class="border px-3 py-2">Produk</th>
                        <th class="border px-3 py-2">Harga</th>
                        <th class="border px-3 py-2">Jumlah</th>
                        <th class="border px-3 py-2">Subtotal</th>
                        <th class="border px-3 py-2">Catatan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($details as $i => $detail)
                        <tr>
                            <td class="border px-3 py-2">{{ $detail['nama'] }}</td>

                            <td class="border px-3 py-2">
                                Rp {{ number_format($detail['harga'],0,',','.') }}
                                <input type="hidden"
                                    id="harga-{{ $i }}"
                                    value="{{ $detail['harga'] }}">
                            </td>

                            <td class="border px-3 py-2">
                                <input type="number"
                                    name="items[{{ $i }}][jumlah]"
                                    value="{{ $detail['jumlah'] }}"
                                    min="1"
                                    class="w-20 border rounded px-2 py-1"
                                    oninput="updateSubtotal({{ $i }})"
                                    id="jumlah-{{ $i }}">
                            </td>

                            <td class="border px-3 py-2 font-semibold">
                                Rp <span id="subtotal-{{ $i }}">
                                    {{ number_format($detail['subtotal'],0,',','.') }}
                                </span>
                            </td>

                            <td class="border px-3 py-2">
                                <input type="text"
                                    name="items[{{ $i }}][catatan]"
                                    value="{{ $detail['catatan'] }}"
                                    class="w-full border rounded px-2 py-1">
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="text-right font-bold text-lg mb-4 dark:text-white">
                Total: Rp <span id="totalHarga">
                    {{ number_format($pesanan->total_bayar,0,',','.') }}
                </span>
            </div>

            <div class="flex justify-end gap-3">
                <button type="button"
                    onclick="closeEditModal()"
                    class="px-4 py-2 bg-gray-400 text-white rounded hover:bg-gray-500">
                    Batal
                </button>

                <button type="submit"
                    class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openEditModal() {
        document.getElementById('editModal').classList.remove('hidden')
    }

    function closeEditModal() {
        document.getElementById('editModal').classList.add('hidden')
    }

    function updateSubtotal(index) {
        let harga = document.getElementById(`harga-${index}`).value
        let jumlah = document.getElementById(`jumlah-${index}`).value

        let subtotal = harga * jumlah
        document.getElementById(`subtotal-${index}`).innerText =
            subtotal.toLocaleString('id-ID')

        updateTotal()
    }

    function updateTotal() {
        let total = 0
        document.querySelectorAll('[id^="subtotal-"]').forEach(el => {
            total += parseInt(el.innerText.replace(/\./g, ''))
        })

        document.getElementById('totalHarga').innerText =
            total.toLocaleString('id-ID')
    }
</script> --}}


</body>

</html>
