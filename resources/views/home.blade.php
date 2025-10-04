<!DOCTYPE html>
<html lang="en">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SelfServe</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>


    

    <!-- Tab Kategori -->

        <nav class="border-gray-200 bg-gray-50 dark:bg-gray-800 dark:border-gray-700">
            <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
                <a href="{{ route('customer.menu') }}"><svg class="w-6 h-6 text-gray-800 dark:text-white"
                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd"
                            d="M13.729 5.575c1.304-1.074 3.27-.146 3.27 1.544v9.762c0 1.69-1.966 2.618-3.27 1.544l-5.927-4.881a2 2 0 0 1 0-3.088l5.927-4.88Z"
                            clip-rule="evenodd" />
                    </svg>
                </a>
                <!-- Form Pencarian -->
    <div class="relative max-w-md ml-4 mt-4">
        <form method="GET" action="{{ url('/menu') }}" class="relative">
            <input id="searchInput" type="text" name="search" placeholder="Cari Menu ..."
                class="w-full pl-4 pr-12 py-2 text-left border rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500">
            <button type="submit"
                class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-blue-500 text-white rounded-full w-8 h-8 flex items-center justify-center transition duration-200 hover:bg-white hover:text-blue-500">
                <i class="fas fa-arrow-right text-sm"></i>
            </button>
        </form>
    </div>
                <a href="{{ route('customer.keranjang.view') }}">
                    <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                        viewBox="0 0 24 24">
                        <path fill-rule="evenodd"
                            d="M4 4a1 1 0 0 1 1-1h1.5a1 1 0 0 1 .979.796L7.939 6H19a1 1 0 0 1 .979 1.204l-1.25 6a1 1 0 0 1-.979.796H9.605l.208 1H17a3 3 0 1 1-2.83 2h-2.34a3 3 0 1 1-4.009-1.76L5.686 5H5a1 1 0 0 1-1-1Z"
                            clip-rule="evenodd" />
                    </svg>
                </a>




            </div>
        </nav>

        <ul class="flex flex-wrap text-sm font-medium text-center text-gray-500 border-b border-gray-200">

            @foreach ($kategoris as $index => $kategori)
                @php $kategoriId = Str::slug($kategori->nama); @endphp
                <li class="me-2">
                    <a href="javascript:void(0)" onclick="showCategory('{{ $kategoriId }}')"
                        class="inline-block p-4 rounded-t-lg kategori-tab {{ $index == 0 ? 'text-blue-600 bg-gray-100 active' : '' }}"
                        id="tab-{{ $kategoriId }}">
                        {{ $kategori->nama }}
                    </a>
                </li>
            @endforeach
        </ul>

        <!-- Konten per Kategori -->
        @foreach ($kategoris as $index => $kategori)
            @php $kategoriId = Str::slug($kategori->nama); @endphp
            <div class="kategori-content {{ $index == 0 ? '' : 'hidden' }}" id="kategori-{{ $kategoriId }}">
                <h2 class="text-2xl font-bold text-gray-900 mt-8 ml-4">{{ $kategori->nama }}</h2>
                <div class="px-4 py-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @if ($kategori->menus->isEmpty())
                        <p class="text-red-500">Tidak ada menu di kategori ini.</p>
                    @endif

                    @foreach ($kategori->menus as $menu)
                        <div data-nama="{{ strtolower($menu->nama) }}"
                            class="menu-item w-full max-w-sm bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-lg">
                            <a href="#">
                                <img class="p-4 rounded-t-lg w-full h-90 aspect-square object-cover"
                                    src="{{ asset($menu->gambar) }}" alt="{{ $menu->nama }}" />
                            </a>
                            <div class="px-5 pb-5">
                                <a href="#">
                                    <h5 class="text-xl font-semibold tracking-tight text-gray-900">{{ $menu->nama }}
                                    </h5>
                                </a>
                                <div class="flex items-center mt-2.5 mb-5">
                                    <span
                                        class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded-sm">5.0</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-3xl font-bold text-gray-900">
                                        @php echo number_format($menu->harga, 0, ',', '.'); @endphp
                                    </span>
                                    @if(strtolower($menu->stok) === 'tersedia')
                                    <form action="{{ route('customer.keranjang.add', $menu->id) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="menu_id" value="{{ $menu->id }}">
                                        <button type="submit"
                                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                            Tambah
                                        </button>
                                    </form>
                                    @else
                                        <button
                                            class="text-white bg-gray-400 cursor-not-allowed font-medium rounded-lg text-sm px-5 py-2.5 text-center"
                                            disabled>
                                            Habis
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach

        <!-- Script: Pencarian -->
        <script>
            const searchInput = document.getElementById('searchInput');
            searchInput.addEventListener('input', function() {
                const searchValue = this.value.toLowerCase();
                const menuItems = document.querySelectorAll('.menu-item');
                menuItems.forEach(item => {
                    const namaMenu = item.getAttribute('data-nama');
                    item.style.display = namaMenu.includes(searchValue) ? 'block' : 'none';
                });
            });
        </script>

        <!-- Script: Navigasi Tab -->
        <script>
            function showCategory(category) {
                document.querySelectorAll('.kategori-content').forEach(el => el.classList.add('hidden'));
                const kategoriEl = document.getElementById('kategori-' + category);
                if (kategoriEl) kategoriEl.classList.remove('hidden');

                document.querySelectorAll('.kategori-tab').forEach(el =>
                    el.classList.remove('text-blue-600', 'bg-gray-100', 'active')
                );
                const tabEl = document.getElementById('tab-' + category);
                if (tabEl) tabEl.classList.add('text-blue-600', 'bg-gray-100', 'active');
            }
        </script>

</body>

</html>
