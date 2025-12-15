<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    

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

  <div class="mx-auto max-w-7xl p-4 md:p-6">
    <div
    class="relative overflow-hidden rounded-2xl
           bg-gradient-to-r from-blue-600 to-sky-500
           min-h-[260px] md:min-h-[340px]
           flex items-center
           p-8 md:p-14 text-white shadow-lg"
>
    

    <!-- image -->
    <img
    src="{{ asset('src/images/cashier-pict.jpg') }}"
    class="pointer-events-none absolute top-0 right-0
           h-full w-auto object-contain opacity-20
           [mask-image:linear-gradient(to_left,black_60%,transparent)]
           [-webkit-mask-image:linear-gradient(to_left,black_60%,transparent)]"
/>


    <!-- konten -->
    <div class="relative z-10 max-w-3xl">
        <h1 class="text-4xl md:text-5xl font-extrabold leading-tight">
            Selamat Datang<br>di Halaman Kasir
        </h1>

        <p class="mt-4 text-xl md:text-2xl font-semibold">
            Selamat bertugas, {{ auth()->user()->name }} 👋
        </p>

        <p class="mt-6 text-lg md:text-xl text-blue-100 max-w-2xl">
            Kelola pesanan, layani pelanggan, dan pastikan transaksi
            berjalan lancar hari ini.
        </p>
    </div>
</div>


</div>

</main>


</body>

</html>

