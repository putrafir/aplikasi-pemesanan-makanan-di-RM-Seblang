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

    <title>Document</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="{{ asset('backend/js/code.js') }}"></script>

</head>

<body x-data="{ 'darkMode': false, 'sidebarToggle': false }" x-init="darkMode = JSON.parse(localStorage.getItem('darkMode'));
$watch('darkMode', value => localStorage.setItem('darkMode', JSON.stringify(value)))" :class="{ 'dark bg-gray-900': darkMode === true }"
    class=" relative min-w-screen">
    @include('admin.body.sidebar')
    @include('admin.body.header')

    <div class="p-4 ">
        <div class=" overflow-x-auto shadow-md sm:rounded-lg">
            <h2 class="text-center mb-5 font-bold">Kategori Menu </h2>
            <a href="{{ route('admin.tambah.kategori') }}"
                class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-1 px-1 rounded mb-3"> <i
                    class="fas fa-plus px-1"></i>Tambah kategori</a>

            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            No
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Nama
                        </th>
                        <th scope="col" class="px-4 py-3">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($kategori as $key => $item)
                        <tr>
                            <td class="text-center">{{ $key + 1 }}</td>
                            <td>{{ $item->nama }}</td>
                            <td class="px-6 py-4">

                                <a href="{{ route('admin.edit.kategori', $item->id) }}"
                                    class="inline-block bg-blue-500 hover:bg-blue-600 text-white font-semibold py-1 px-1 rounded">
                                    Edit </a>
                                <a href="{{ route('admin.delete.kategori', $item->id) }}"
                                    class="inline-block bg-red-500 hover:bg-red-600 text-white font-semibold py-1 px-1 rounded"
                                    id="deleteKategori">
                                    Hapus </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
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
