<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />

  <!-- Toastr -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

  <title>Kategori Menu</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
  <script src="{{ asset('backend/js/code.js') }}"></script>
</head>


<body
  x-data="{ darkMode: false, sidebarToggle: false }"
  x-init="darkMode = JSON.parse(localStorage.getItem('darkMode'));
          $watch('darkMode', value => localStorage.setItem('darkMode', JSON.stringify(value)))"
  :class="{ 'dark bg-gray-900': darkMode }"
  class="relative min-w-screen overflow-x-hidden">

  <!-- Sidebar -->
  @include('admin.body.sidebar')

  <!-- Header -->
  @include('admin.body.header')

  <!-- Main Content -->
  <main
    class="p-4 sm:p-5 md:p-6 transition-all duration-300 md:ml-0 lg:ml-64 max-w-full overflow-x-hidden min-h-screen">

    <div
      class="w-full bg-white dark:bg-gray-900 shadow-md rounded-xl overflow-hidden p-4 sm:p-6 md:p-8 transition-all duration-300">

      <!-- Header Section -->
      <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-5 gap-3">
        <h2 class="text-center sm:text-left text-xl font-bold text-gray-800 dark:text-white">
          Kategori Menu
        </h2>

        <a href="{{ route('admin.tambah.kategori') }}"
          class="inline-flex items-center justify-center bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg text-sm sm:text-base transition">
          <i class="fas fa-plus mr-2"></i>Tambah Kategori
        </a>
      </div>

      <!-- Tabel Responsif -->
      <div class="overflow-x-auto">
        <table
          class="min-w-full text-sm text-left text-gray-700 dark:text-gray-300 border-collapse border border-gray-200 dark:border-gray-700">
          <thead
            class="text-xs uppercase bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300">
            <tr>
              <th scope="col" class="px-4 sm:px-6 py-3 text-center">No</th>
              <th scope="col" class="px-4 sm:px-6 py-3 text-left">Nama</th>
              <th scope="col" class="px-4 sm:px-6 py-3 text-center">Aksi</th>
            </tr>
          </thead>

          <tbody>
            @foreach ($kategori as $key => $item)
              <tr
                class="odd:bg-white even:bg-gray-50 dark:odd:bg-gray-900 dark:even:bg-gray-800 border-b border-gray-200 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-700 transition">

                <!-- No -->
                <td class="px-4 sm:px-6 py-4 text-center font-semibold text-gray-900 dark:text-white">
                  {{ $key + 1 }}
                </td>

                <!-- Nama -->
                <td class="px-4 sm:px-6 py-4 font-medium text-gray-800 dark:text-gray-200 whitespace-nowrap">
                  {{ $item->nama }}
                </td>

                <!-- Aksi -->
                <td class="px-4 sm:px-6 py-4 text-center space-x-2 whitespace-nowrap">
                  <a href="{{ route('admin.edit.kategori', $item->id) }}"
                    class="inline-block bg-blue-500 hover:bg-blue-600 text-white font-semibold py-1 px-2 rounded text-xs sm:text-sm transition">
                    Edit
                  </a>
                  <a href="{{ route('admin.delete.kategori', $item->id) }}"
                    class="inline-block bg-red-500 hover:bg-red-600 text-white font-semibold py-1 px-2 rounded text-xs sm:text-sm transition"
                    id="deleteKategori">
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

  <!-- Toastr Notification -->
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
