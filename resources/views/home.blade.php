<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
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

    @foreach ($kategoris as $index => $kategori)
        @php $kategoriId = Str::slug($kategori->nama); @endphp
        <div class="kategori-content {{ $index == 0 ? '' : 'hidden' }}" id="kategori-{{ $kategoriId }}">
            <h2 class="text-2xl font-bold text-gray-900 mt-8">{{ $kategori->nama }}</h2>
            <div class="px-2 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @if ($kategori->menus->isEmpty())
                    <p class="text-red-500">Tidak ada menu di kategori ini.</p>
                    {{-- @dd($kategori) --}}
                    {{ $kategori }}
                @endif
                @foreach ($kategori->menus as $menu)
                    <div class="w-full max-w-sm bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-lg">
                        <a href="#">
                            <img class="p-4 rounded-t-lg w-full h-40 object-cover"
                                src="/docs/images/products/apple-watch.png" alt="{{ $menu->nama }}" />
                        </a>
                        <div class="px-5 pb-5">
                            <a href="#">
                                <h5 class="text-xl font-semibold tracking-tight text-gray-900">{{ $menu->nama }}</h5>
                            </a>
                            <div class="flex items-center mt-2.5 mb-5">
                                <span
                                    class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded-sm">5.0</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-3xl font-bold text-gray-900">
                                    @php echo number_format($menu->harga, 0, ',', '.'); @endphp
                                </span>
                                <a href="#"
                                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5">
                                    Add to cart
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach

    <script>
        function showCategory(category) {
            document.querySelectorAll('.kategori-content').forEach(el => el.classList.add('hidden'));
            let kategoriEl = document.getElementById('kategori-' + category);
            if (kategoriEl) {
                kategoriEl.classList.remove('hidden');
            }

            document.querySelectorAll('.kategori-tab').forEach(el => el.classList.remove('text-blue-600', 'bg-gray-100',
                'active'));
            let tabEl = document.getElementById('tab-' + category);
            if (tabEl) {
                tabEl.classList.add('text-blue-600', 'bg-gray-100', 'active');
            }
        }
    </script>

</body>

</html>
