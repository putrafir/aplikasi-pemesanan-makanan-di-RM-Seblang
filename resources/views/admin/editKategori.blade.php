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

    <form id="myForm" action="{{ route('admin.update.kategori') }}" method="POST" enctype="multipart/form-data"
        class="max-w-xl mx-auto p-6 bg-white rounded-lg shadow space-y-4">
        @csrf
        <input type="hidden" name="id" value="{{ $kategori->id }}">

        <h3 class="text-2xl font-bold text-center mb-4">Edit Kategori</h3>

        <!-- Nama Menu -->
        <div>
            <label for="nama" class="block text-sm font-medium text-gray-700">Nama Kategori</label>
            <input type="text" id="nama" name="nama" value="{{ $kategori->nama }}"
                class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring focus:border-blue-500"
                required>
        </div>

        <!-- Tombol -->
        <div class="flex justify-between pt-4">

            <a href="{{ route('admin.kategori.menu') }}"
                class="bg-white text-black font-bold px-6 py-2 rounded border border-gray-300 hover:bg-gray-200 transition flex items-center gap-2">
                <i class="fa-solid fa-arrow-left"></i>
                Back
            </a>

            <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700 transition"><i
                    class="fa-regular fa-floppy-disk"></i>
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
