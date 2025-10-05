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
$watch('darkMode', value => localStorage.setItem('darkMode', JSON.stringify(value)))" :class="{ 'dark bg-gray-900': darkMode === true }" class=" relative min-w-screen">

    @include('admin.body.sidebar')


    <div class="p-4 sm:ml-64">
        <div class=" py-2 overflow-x-auto shadow-md sm:rounded-lg">
            <h2 class="text-center mb-5 font-bold dark:text-white">Daftar Akun Kasir</h2>
            <button onclick="showPopUpAdd()" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-1 px-1 rounded mb-5 ml-5">
                 <i
                    class="fas fa-plus px-1"></i>Tambah
                Kasir
            </button>

            {{-- di bawah ini --}}

            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">Nama</th>
                        <th scope="col" class="px-6 py-3">Email</th>
                        <th scope="col" class="px-6 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $kasir)
                        <tr
                            class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200">
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $kasir->name }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $kasir->email }}
                            </td>
                            <td class="px-6 py-4">
                                <button type="button"
                                onclick="showPopUpEdit('{{ $kasir->id }}', '{{ $kasir->name }}', '{{ $kasir->email }}')"
                             class="inline-block bg-blue-500 hover:bg-blue-600 text-white font-semibold py-1 px-2 rounded">
                              Edit
                             </button>
                                <a href="{{ route('admin.delete.kasir', $kasir->id) }}"
                                    class="inline-block bg-red-500 hover:bg-red-600 text-white font-semibold py-1 px-2 rounded"
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


        </div>
    </div>

    <script>
        @if (Session::has('message'))
            var type = "{{ Session::get('alert-type', 'info') }}"
            switch (type) {
                case 'info': toastr.info(" {{ Session::get('message') }} "); break;
                case 'success': toastr.success(" {{ Session::get('message') }} "); break;
                case 'warning': toastr.warning(" {{ Session::get('message') }} "); break;
                case 'error': toastr.error(" {{ Session::get('message') }} "); break;
            }
        @endif
    </script>



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

        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Tambah Kasir Baru</h3>

        <form action="{{route('admin.kelolakasir.tambah')}}"method="POST">
            @csrf
            <div class="mb-4">
                <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama</label>
                <input type="text" id="name" name="name"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                    required />
            </div>

            <div class="mb-4">
                <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                <input type="email" name="email" id="email"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                    placeholder="nama@contoh.com" required />
            </div>

            <input type="hidden" name="role" value="kasir">

            <div class="mb-4">
                <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                <input name="password" type="password" id="password"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                    required />
            </div>

            <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2.5 rounded-lg text-sm transition duration-300">
                Tambah
            </button>
        </form>
    </div>
</div>

    <!-- Modal Edit Kasir -->
    <div id="popUpEdit" class="hidden fixed inset-0 z-50 flex items-center justify-center">
        <div class="absolute inset-0 bg-black bg-opacity-50" onclick="hidePopUpEdit()"></div>
        <div class="relative bg-white dark:bg-gray-800 rounded-lg shadow-lg w-full max-w-md z-10 p-6">
            <button onclick="hidePopUpEdit()" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 dark:hover:text-white text-xl font-bold">&times;</button>
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Edit Kasir</h3>
            <form id="editKasirForm" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label for="edit_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama</label>
                    <input type="text" id="edit_name" name="name"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                               focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5
                               dark:bg-gray-700 dark:border-gray-600 dark:text-white" required />
                </div>
                <div class="mb-4">
                    <label for="edit_email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                    <input type="email" id="edit_email" name="email"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                               focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5
                               dark:bg-gray-700 dark:border-gray-600 dark:text-white" required />
                </div>
                <div class="mb-4">
                    <label for="edit_password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password (opsional)</label>
                    <input type="password" id="edit_password" name="password"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                               focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5
                               dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                        placeholder="Kosongkan jika tidak diubah" />
                </div>
                <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2.5 rounded-lg text-sm transition duration-300">
                    Update
                </button>
            </form>
        </div>
    </div>

    <!-- Semua script di sini -->
    <script>
        function showPopUpAdd() {
            document.getElementById('popUpAdd').classList.remove('hidden');
        }
        function hidePopUpAdd() {
            document.getElementById('popUpAdd').classList.add('hidden');
        }

        function showPopUpEdit(id, name, email) {
            document.getElementById('popUpEdit').classList.remove('hidden');
            document.getElementById('edit_name').value = name;
            document.getElementById('edit_email').value = email;
            document.getElementById('editKasirForm').action = '/admin/update/kasir/' + id;
        }
        function hidePopUpEdit() {
            document.getElementById('popUpEdit').classList.add('hidden');
        }
    </script>

</body>
</html>
