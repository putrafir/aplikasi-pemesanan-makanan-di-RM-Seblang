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

<body>

    @include('admin.body.sidebar')

    <form id="myForm" action="{{ route('admin.update.menu') }}" method="POST" enctype="multipart/form-data"
        class="max-w-xl mx-auto p-6 bg-white rounded-lg shadow space-y-4">
        @csrf
        <input type="hidden" name="id" value="{{ $menu->id }}">

        <h3 class="text-2xl font-bold text-center mb-4">Edit Menu</h3>

        <!-- Nama Menu -->
        <div>
            <label for="nama_menu" class="block text-sm font-medium text-gray-700">Nama Menu</label>
            <input type="text" id="nama_menu" name="nama_menu" value="{{ $menu->nama }}"
                class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring focus:border-blue-500"
                required>
        </div>

        <!-- Gambar -->
        <div class="mb-3">
            <label for="example-text-input" class="form-label">Gambar</label>
            <input class="form-control" name="image" type="file" id="image" accept="image/*">
        </div>
        <div class="mb-3">

            <img id="showImage" src="{{ asset($menu->gambar) }}" alt=""
                class="rounded-circle p-1 bg-primary" width="110">
        </div>



        <!-- Deskripsi -->
        <div>
            <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi</label>
            <textarea id="deskripsi" name="deskripsi" rows="4"
                class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring focus:border-blue-500">{{ $menu->deskripsi }}</textarea>
        </div>

        <!-- Kategori -->
        <select id="kategori" name="kategori"
            class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring focus:border-blue-500">
            <option value="">-- Pilih Kategori --</option>
            <option value="1" {{ $menu->kategori_id == 1 ? 'selected' : '' }}>Makanan</option>
            <option value="2" {{ $menu->kategori_id == 2 ? 'selected' : '' }}>Minuman</option>
            <option value="3" {{ $menu->kategori_id == 3 ? 'selected' : '' }}>Dessert</option>
        </select>


        <!-- Stok -->
        {{-- <div>
            <label for="stok" class="block text-sm font-medium text-gray-700">Stok</label>
            <select id="stok" name="stok" min="0"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                <option value="">-- Pilih Stok --</option>
                <option value="habis" {{ $menu->stok == 'habis' ? 'selected' : '' }}>Habis</option>
                <option value="tersedia" {{ $menu->stok == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
            </select>
        </div> --}}

        <!-- Harga -->
        <div>
            <label for="harga" class="block text-sm font-medium text-gray-700">Harga </label>
            <input type="number" id="harga" name="harga" value="{{ $menu->harga }}"
                class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring focus:border-blue-500">
        </div>

        <!-- Tombol -->
        <div class="flex justify-between pt-4">

            <a href="{{ route('admin.menu') }}"
                class="bg-white text-black font-bold px-6 py-2 rounded border border-gray-300 hover:bg-gray-200 transition flex items-center gap-2">
                <i class="fas fa-arrow-left"></i>
                Back
            </a>

            <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700 transition">
                Simpan
            </button>
        </div>

    </form>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#image').change(function(e) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#showImage').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            })
        })
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#myForm').validate({
                rules: {
                    category_name: {
                        required: true,
                    },


                },
                messages: {
                    category_name: {
                        required: 'Please Enter Category Name',
                    },



                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                },
            });
        });
    </script>

</body>

</html>