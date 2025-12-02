<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Dashboard</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
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
    class="p-4 sm:p-5 md:p-6 transition-all duration-300 ml-0 md:ml-0 lg:ml-64 max-w-full overflow-hidden min-h-screen">

    <div class="grid grid-cols-12 gap-4 sm:gap-5 md:gap-6">
      <div class="col-span-12 space-y-6">

        <!-- 📊 METRIC SECTION -->
        <div
          class="grid grid-cols-1 xs:grid-cols-2 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-3 gap-4 sm:gap-5 md:gap-6 mt-4">
          <!-- Metric 1 -->
          <div
            class="cursor-pointer rounded-2xl shadow-lg bg-blue-400 p-5 dark:bg-gray-700 sm:p-6 hover:shadow-xl transform transition duration-300 hover:scale-105 hover:-translate-y-1">
            <div class="flex items-center justify-between">
              <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-200 dark:bg-gray-800 flex-shrink-0">
                <svg class="fill-black dark:fill-white" width="24" height="24" viewBox="0 0 24 24">
                  <path
                    d="M8.8 5.6a2.2 2.2 0 1 0 0 4.4 2.2 2.2 0 0 0 0-4.4zM4.9 15.3c-.7.7-1 1.6-1.1 2.1 0 .1 0 .2.1.3.1.1.2.2.4.2h9.4c.2 0 .3-.1.4-.2.1-.1.1-.2.1-.3-.1-.5-.4-1.4-1.1-2.1-.7-.8-1.9-1.3-3.8-1.3s-3.1.5-3.8 1.3z" />
                </svg>
              </div>
              <div class="flex-1 ml-3">
                <p class="text-md text-white">Customers</p>
                <h4 class="text-2xl font-bold text-white mt-1">{{ number_format($todayCustomer) }}</h4>
              </div>
            </div>
          </div>

          <!-- Metric 2 -->
          <div
            class="cursor-pointer rounded-2xl shadow-lg bg-blue-300 p-5 dark:bg-gray-600 sm:p-6 hover:shadow-xl transform transition duration-300 hover:scale-105 hover:-translate-y-1">
            <div class="flex items-center justify-between">
              <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-100 dark:bg-gray-800 flex-shrink-0">
                <svg class="fill-black dark:fill-white" width="24" height="24" viewBox="0 0 24 24">
                  <path d="M12 3L4 7v10l8 4 8-4V7l-8-4zm0 2.2L18 8l-6 3-6-3 6-2.8z" />
                </svg>
              </div>
              <div class="flex-1 ml-3">
                <p class="text-md text-white">Orders</p>
                <h4 class="text-2xl font-bold text-white mt-1">{{ number_format($todayMenu) }}</h4>
              </div>
            </div>
          </div>

          <!-- Metric 3 -->
          <div
            class="cursor-pointer rounded-2xl shadow-lg bg-gradient-to-r from-blue-700 to-blue-500 p-5 dark:from-gray-700 dark:to-gray-900 sm:p-6 hover:shadow-xl transform transition duration-300 hover:scale-105 hover:-translate-y-1">
            <div class="flex items-center justify-between">
              <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-100 dark:bg-gray-800 flex-shrink-0">
                <svg class="fill-gray-800 dark:fill-white" width="24" height="24" viewBox="0 0 24 24">
                  <path d="M12 1a11 11 0 1 0 11 11A11 11 0 0 0 12 1zm1 17h-2v-2h2zm0-4h-2V6h2z" />
                </svg>
              </div>
              <div class="flex-1 ml-3">
                <p class="text-md text-white">Income</p>
                <h4 class="text-2xl font-bold text-white mt-1">{{ number_format($todayIncome) }}</h4>
              </div>
            </div>
          </div>
        </div>

        <!-- 📈 CHARTS SECTION -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-5 md:gap-6 mt-4">
          <!-- Chart 1 -->
          <div
            class="overflow-hidden rounded-2xl border border-gray-200 bg-white p-4 sm:p-5 dark:border-gray-800 dark:bg-gray-900 flex flex-col">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-3 sm:mb-4">Monthly Sales</h3>
            <div id="chartOne" class="flex-1 w-full min-h-[250px] sm:min-h-[300px] md:min-h-[350px]"></div>
          </div>

          <!-- Chart 2 -->
          <div
            class="overflow-hidden rounded-2xl border border-gray-200 bg-white p-4 sm:p-5 dark:border-gray-800 dark:bg-gray-900 flex flex-col">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-3 sm:mb-4">Monthly Customers</h3>
            <div id="chartCustomer" class="flex-1 w-full min-h-[250px] sm:min-h-[300px] md:min-h-[350px]"></div>
          </div>
        </div>

        <!-- 🏆 BEST SELLER SECTION -->
        <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 sm:gap-5">
          @if(isset($bestSellerMakanan))
          <div class="bg-blue-400 text-white rounded-lg shadow-lg p-4 sm:p-5">
            <h2 class="text-lg font-bold mb-2">Best Seller Makanan</h2>
            <div class="flex items-center space-x-4">
              <img src="{{ asset($bestSellerMakanan->gambar) }}" alt="{{ $bestSellerMakanan->nama }}"
                class="w-16 h-16 rounded-lg object-cover">
              <div>
                <p class="font-semibold">{{ $bestSellerMakanan->nama }}</p>
                <p class="text-sm">Terjual {{ $bestSellerMakanan->jumlah_terjual }} kali</p>
              </div>
            </div>
          </div>
          @endif

          @if(isset($bestSellerMinuman))
          <div class="bg-blue-400 text-white rounded-lg shadow-lg p-4 sm:p-5">
            <h2 class="text-lg font-bold mb-2">Best Seller Minuman</h2>
            <div class="flex items-center space-x-4">
              <img src="{{ asset($bestSellerMinuman->gambar) }}" alt="{{ $bestSellerMinuman->nama }}"
                class="w-16 h-16 rounded-lg object-cover">
              <div>
                <p class="font-semibold">{{ $bestSellerMinuman->nama }}</p>
                <p class="text-sm">Terjual {{ $bestSellerMinuman->jumlah_terjual }} kali</p>
              </div>
            </div>
          </div>
          @endif

          @if(isset($bestSellerCamilan))
          <div class="bg-blue-400 text-white rounded-lg shadow-lg p-4 sm:p-5">
            <h2 class="text-lg font-bold mb-2">Best Seller Camilan</h2>
            <div class="flex items-center space-x-4">
              <img src="{{ asset($bestSellerCamilan->gambar) }}" alt="{{ $bestSellerCamilan->nama }}"
                class="w-16 h-16 rounded-lg object-cover">
              <div>
                <p class="font-semibold">{{ $bestSellerCamilan->nama }}</p>
                <p class="text-sm">Terjual {{ $bestSellerCamilan->jumlah_terjual }} kali</p>
              </div>
            </div>
          </div>
          @endif

        </div>

      </div>
    </div>
  </main>

  <script>
    const incomeChartData = @json($incomeData ?? []);
    const customerChartData = @json($customerData ?? []);
  </script>

  <script type="module">
    import chart01 from '/js/chart/chart-one.js';

    document.addEventListener('DOMContentLoaded', () => chart01());
  </script>

</body>

</html>

