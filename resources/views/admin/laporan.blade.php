<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
  <script src="https://cdn.tailwindcss.com"></script>
  <title>Laporan Transaksi</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body
  x-data="{ darkMode: false, sidebarToggle: false }"
  x-init="darkMode = JSON.parse(localStorage.getItem('darkMode'));
          $watch('darkMode', value => localStorage.setItem('darkMode', JSON.stringify(value)))"
  :class="{ 'dark bg-gray-900': darkMode }"
  class="relative min-w-screen overflow-x-hidden">

  @include('admin.body.sidebar')
  @include('admin.body.header')

  <!-- Konten utama -->
  <main class="p-3 sm:p-4 md:p-6 lg:p-8 transition-all duration-300 md:ml-0 lg:ml-64 max-w-full overflow-x-hidden min-h-screen">

    <div class="bg-white dark:bg-gray-900 shadow-md rounded-xl overflow-hidden p-4 sm:p-6 md:p-8">
      <h1 class="text-center text-lg sm:text-xl md:text-2xl font-bold mb-4 text-gray-800 dark:text-white">
        Laporan Transaksi
      </h1>

      <p class="text-gray-600 dark:text-gray-300 mb-6 text-sm sm:text-base md:text-lg text-center sm:text-left">
        Gunakan filter untuk melihat laporan transaksi berdasarkan rentang tanggal.
      </p>

      <!-- Form Filter -->
      <form id="myForm"
        action="{{ route('admin.search.bydate') }}"
        method="post"
        enctype="multipart/form-data"
        class="flex flex-col sm:flex-row sm:items-end sm:justify-start gap-4 flex-wrap">
        @csrf

        <!-- Tanggal Mulai -->
        <div class="flex-1 min-w-[180px] sm:min-w-[200px] md:min-w-[250px]">
          <label for="tanggal_mulai" class="block mb-1 font-medium text-gray-700 dark:text-gray-200 text-sm sm:text-base">
            Tanggal Mulai
          </label>
          <input
            type="date"
            name="tanggal_awal"
            class="w-full border border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white rounded-lg px-3 py-2 text-sm sm:text-base focus:ring-2 focus:ring-blue-400 focus:outline-none" />
        </div>

        <!-- Tanggal Akhir -->
        <div class="flex-1 min-w-[180px] sm:min-w-[200px] md:min-w-[250px]">
          <label for="tanggal_akhir" class="block mb-1 font-medium text-gray-700 dark:text-gray-200 text-sm sm:text-base">
            Tanggal Akhir
          </label>
          <input
            type="date"
            name="tanggal_akhir"
            class="w-full border border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white rounded-lg px-3 py-2 text-sm sm:text-base focus:ring-2 focus:ring-blue-400 focus:outline-none" />
        </div>

        <!-- Tombol Filter -->
        <div class="pt-2 sm:pt-0">
          <button
            type="submit"
            class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2.5 px-4 sm:px-6 rounded-lg text-sm sm:text-base transition-all duration-200 flex items-center justify-center w-full sm:w-auto">
            <i class="fa-solid fa-filter mr-2"></i>
            <span>Filter</span>
          </button>
        </div>
      </form>
    </div>
  </main>

</body>
</html>
