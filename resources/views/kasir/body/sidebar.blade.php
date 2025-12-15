<aside id="default-sidebar"
        class="sidebar fixed inset-y-0 top-0 left-0 z-50 w-64 h-screen border-r border-gray-200 bg-white transform transition-transform duration-300 ease-in-out lg:translate-x-0 dark:border-gray-700 dark:bg-gray-800" :class="{
    '-translate-x-full': !sidebarToggle,
    'translate-x-0': sidebarToggle,
    'lg:translate-x-0': true
  }"
        aria-label="Sidebar">


        {{-- sidebar header --}}
         {{-- sidebar header --}}
<div class="sidebar-header relative px-3 pt-5 pb-2">

    <!-- ❌ TOMBOL CLOSE (POJOK KANAN ATAS) -->
    <button
        @click="sidebarToggle = false"
        class="absolute top-2 right-2
               lg:hidden
               flex h-9 w-9 items-center justify-center
               rounded-full
               text-gray-500 hover:bg-gray-100
               dark:text-gray-400 dark:hover:bg-gray-800"
        aria-label="Close sidebar"
    >
        <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
            <path
                fill-rule="evenodd"
                clip-rule="evenodd"
                d="M6.225 6.225a.75.75 0 011.06 0L12 10.94l4.715-4.715a.75.75 0 111.06 1.06L13.06 12l4.715 4.715a.75.75 0 11-1.06 1.06L12 13.06l-4.715 4.715a.75.75 0 11-1.06-1.06L10.94 12 6.225 7.285a.75.75 0 010-1.06z"
            />
        </svg>
    </button>

    <!-- LOGO / TITLE -->
    <a href="{{ route('kasir.dashboard') }}">
        <span class="logo block mt-6">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white">
                Kasir Seblang
            </h1>
        </span>
    </a>

</div>

        {{-- end sidebar header --}}

        <div class="h-full px-3 py-4 overflow-y-auto">
            <ul class="mb-6 flex flex-col gap-4 font-medium">
                <li>
                    <a href="{{ route('kasir.dashboard') }}"
                        class="flex items-center p-2 text-gray-900 rounded-lg group {{ request()->routeIs('kasir.dashboard') 
                            ? 'bg-blue-100 text-blue-700 dark:bg-gray-700 dark:text-blue-400 ' 
                            : 'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                        <svg
                            class="w-5 h-5 transition duration-75 {{ request()->routeIs('kasir.dashboard') 
                                ? 'text-blue-700 dark:text-blue-400 dark:group-hover:text-sky-300' 
                                : 'text-gray-500 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white' }}"
                            aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path d="M3 10.5L12 3l9 7.5V21a1 1 0 0 1-1 1h-5v-6h-6v6H4a1 1 0 0 1-1-1v-10.5z"/>
                        </svg>

                        <span class="flex-1 ms-3 whitespace-nowrap">Beranda</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('kasir.pesanan') }}"
                        class="flex items-center p-2 text-gray-900 rounded-lg group {{ request()->routeIs('kasir.pesanan') 
                            ? 'bg-blue-100 text-blue-700 dark:bg-gray-700 dark:text-blue-400 ' 
                            : 'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                        <svg class="shrink-0 w-5 h-5 transition duration-75 {{ request()->routeIs('kasir.pesanan') 
                            ? 'text-blue-700 dark:text-blue-400 dark:group-hover:text-sky-300' 
                            : 'text-gray-500 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white' }}"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                            viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M14 7h-4v3a1 1 0 0 1-2 0V7H6a1 1 0 0 0-.997.923l-.917 11.924A2 2 0 0 0 6.08 22h11.84a2 2 0 0 0 1.994-2.153l-.917-11.924A1 1 0 0 0 18 7h-2v3a1 1 0 1 1-2 0V7Zm-2-3a2 2 0 0 0-2 2v1H8V6a4 4 0 0 1 8 0v1h-2V6a2 2 0 0 0-2-2Z" clip-rule="evenodd"/>
                        </svg>
                        <span class="flex-1 ms-3 whitespace-nowrap">Pesanan</span>
                        {{-- <span
                            class="inline-flex items-center justify-center w-3 h-3 p-3 ms-3 text-sm font-medium text-blue-800 bg-blue-100 rounded-full dark:bg-blue-900 dark:text-blue-300">3</span> --}}
                    </a>
                </li>
            </ul>
        </div>
    </aside>