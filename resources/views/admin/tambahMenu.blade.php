<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Document</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>

    @include('admin.body.sidebar')


    <form id="myForm" action="{{ route('admin.store.menu') }}" method="POST" enctype="multipart/form-data"
        class="max-w-md mx-auto mt-8 p-6 bg-white rounded-md shadow-md">
        @csrf
        <h2 class="text-2xl font-bold text-center mb-6">Tambah Menu</h2>

        <div class="mb-4">
            <label for="nama_menu" class="block text-gray-700 text-sm font-bold mb-2">Nama Menu</label>
            <input type="text" id="nama_menu" name="nama_menu"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                required>
        </div>

        <div class="mb-6">
            <label for="image" class="block text-gray-700 text-sm font-bold mb-2">Gambar</label>
            <input type="file" id="image" name="image" accept="image/*"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            <img id="showImage"
                src="{{ !empty($profileData->gambar)
                    ? url('upload/menu/1.jpg' . $profileData->gambar)
                    : url(
                        'upload/menu/1.jpg                                                                                                                                                                                               .jpg',
                    ) }}"
                alt="" class="mt-2 max-w-xs rounded">
        </div>

        <div class="mb-4">
            <label for="deskripsi" class="block text-gray-700 text-sm font-bold mb-2">Deskripsi</label>
            <textarea id="deskripsi" name="deskripsi" rows="4"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
        </div>

        <div class="mb-4">
            <label for="kategori" class="block text-gray-700 text-sm font-bold mb-2">Kategori</label>
            <select id="kategori" name="kategori"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                <option value="">-- Pilih Kategori --</option>
                <option value="1">Makanan</option>
                <option value="2">Minuman</option>
                <option value="3">Camilan</option>
            </select>
        </div>

        {{-- <div class="mb-4">
            <label for="stok" class="block text-gray-700 text-sm font-bold mb-2">Stok</label>
            <select id="stok" name="stok" min="0"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                <option value="">-- Pilih Stok --</option>
                <option value="habis">Habis</option>
                <option value="tersedia">Tersedia</option>
            </select>
        </div> --}}

        <div class="mb-4">
            <label for="harga" class="block text-gray-700 text-sm font-bold mb-2">Harga</label>
            <input type="number" id="harga" name="harga"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>

        <div class="flex justify-between pt-4">
            <button type="reset"
                class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Hapus
            </button>
            <button type="submit"
                class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
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
                    nama_menu: {
                        required: true,
                    },
                    image: {
                        required: true,
                    },

                },
                messages: {
                    nama_menu: {
                        required: 'Please Menu Name',
                    },
                    image: {
                        required: 'Please Select Image',
                    },


                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.parent().append(error);
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