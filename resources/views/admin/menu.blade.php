<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- Toastr CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <title>Daftar Menu</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="{{ asset('backend/js/code.js') }}"></script>
</head>

<body x-data="{ 'darkMode': false, 'sidebarToggle': false }"
    x-init="darkMode = JSON.parse(localStorage.getItem('darkMode'));
    $watch('darkMode', value => localStorage.setItem('darkMode', JSON.stringify(value)))"
    :class="{ 'dark bg-gray-900': darkMode === true }"
    class="relative min-w-screen overflow-x-hidden">


    <!-- Sidebar -->

    @include('admin.body.sidebar')

    <!-- Header -->
    @include('admin.body.header')


    <!-- MAIN CONTENT -->
    <main
        class="p-4 sm:p-5 md:p-6 transition-all duration-300 md:ml-0 lg:ml-64 max-w-full overflow-x-hidden min-h-screen">
        <div
            class="w-full bg-white dark:bg-gray-900 shadow-md rounded-xl overflow-hidden p-4 sm:p-6 md:p-8 transition-all duration-300">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-5 gap-3">
                <h2 class="text-center sm:text-left text-xl font-bold text-gray-800 dark:text-white">
                    Daftar Menu
                </h2>
                <a href="{{ route('admin.tambah.menu') }}"
                    class="inline-flex items-center justify-center bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg text-sm sm:text-base transition">
                    <i class="fas fa-plus mr-2"></i>Tambah Menu
                </a>
            </div>

            <!-- Responsive Table Container -->
            <div class="overflow-x-auto">
                <table
                    class="min-w-full text-sm text-left text-gray-700 dark:text-gray-300 border-collapse border border-gray-200 dark:border-gray-700">
                    <thead
                        class="text-xs uppercase bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300">
                        <tr>
                            <th scope="col" class="px-4 sm:px-6 py-3">Nama Menu</th>
                            <th scope="col" class="px-4 sm:px-6 py-3 hidden md:table-cell">Deskripsi</th>
                            <th scope="col" class="px-4 sm:px-6 py-3">Harga</th>
                            <th scope="col" class="px-4 sm:px-6 py-3">Kategori</th>
                            <th scope="col" class="px-4 sm:px-6 py-3">Stok</th>
                            <th scope="col" class="px-4 sm:px-6 py-3">Rekomendasi</th>
                            <th scope="col" class="px-3 sm:px-4 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($menus as $menu)
                            <tr
                                class="odd:bg-white even:bg-gray-50 dark:odd:bg-gray-900 dark:even:bg-gray-800 border-b border-gray-200 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                                <td class="px-4 sm:px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                    {{ $menu->nama }}
                                </td>

                                <td class="px-4 sm:px-6 py-4 hidden md:table-cell truncate max-w-[150px]">
                                    {{ $menu->deskripsi }}
                                </td>

                                <td class="px-4 sm:px-6 py-4">
                                    Rp{{ number_format($menu->harga, 0, ',', '.') }}
                                </td>

                                <td class="px-4 sm:px-6 py-4">
                                    {{ $menu->kategori->nama }}
                                </td>

                                <!-- Stok -->
                                <td class="px-4 sm:px-6 py-4">
                                    <form action="{{ route('admin.update.stok', $menu->id) }}" method="POST">

                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="stok_baru"
                                            value="{{ $menu->stok === 'habis' ? 'tersedia' : 'habis' }}">
                                        <button type="submit"
                                            class="px-3 py-1 rounded text-xs sm:text-sm font-semibold transition
                                                {{ $menu->stok === 'habis' ? 'bg-red-500 hover:bg-red-600 text-white' : 'bg-green-500 hover:bg-green-600 text-white' }}">
                                            {{ ucfirst($menu->stok) }}
                                        </button>
                                    </form>
                                </td>

                                <!-- Rekomendasi -->
                                <td class="px-4 sm:px-6 py-4">
                                    <form action="{{ route('admin.update.rekomendasi', $menu->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="is_recommended_baru"
                                            value="{{ $menu->is_recommended ? 0 : 1 }}">
                                        <button type="submit"
                                            class="px-3 py-1 rounded text-xs sm:text-sm font-semibold transition
                                                {{ $menu->is_recommended ? 'bg-orange-500 hover:bg-orange-600 text-white' : 'bg-gray-300 hover:bg-gray-400 text-gray-700' }}">
                                            {{ $menu->is_recommended ? 'Ya' : 'Tidak' }}
                                        </button>
                                    </form>
                                </td>

                                <!-- Aksi -->
                                <td class="px-4 sm:px-6 py-4 text-center space-x-2 whitespace-nowrap">
                                    <a href="{{ route('admin.edit.menu', $menu->id) }}"
                                        class="inline-block bg-blue-500 hover:bg-blue-600 text-white font-semibold py-1 px-2 rounded text-xs sm:text-sm">
                                        Edit
                                    </a>
                                    <a href="{{ route('admin.delete.menu', $menu->id) }}"
                                        class="inline-block bg-red-500 hover:bg-red-600 text-white font-semibold py-1 px-2 rounded text-xs sm:text-sm"
                                        id="delete">
                                        Hapus
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <!-- TOASTR NOTIFICATION -->
    <script>
        @if (Session::has('message'))
            var type = "{{ Session::get('alert-type', 'info') }}";
            switch (type) {
                case 'info': toastr.info("{{ Session::get('message') }}"); break;
                case 'success': toastr.success("{{ Session::get('message') }}"); break;
                case 'warning': toastr.warning("{{ Session::get('message') }}"); break;
                case 'error': toastr.error("{{ Session::get('message') }}"); break;
            }
        @endif
    </script>

</body>

</html>
