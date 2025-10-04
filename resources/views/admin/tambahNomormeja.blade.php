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


    <form id="myForm" action="{{ route('admin.store.nomormeja') }}" method="POST" enctype="multipart/form-data"
        class="max-w-md mx-auto mt-8 p-6 bg-white rounded-md shadow-md">
        @csrf
        <h2 class="text-2xl font-bold text-center mb-6">Tambah Nomor Meja</h2>

        <div class="mb-4">
            <label for="nomor_meja" class="block text-gray-700 text-sm font-bold mb-2">Nomor Meja</label>
            <input type="text" id="nomor_meja" name="nomor"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                required>
        </div>

        <div class="mb-4">
            <label for="status" class="block text-gray-700 text-sm font-bold mb-2">Status</label>
            <select id="status" name="status"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                <option value="">-- Pilih Status --</option>
                <option value="tersedia">Tersedia</option>
                <option value="terisi">Terisi</option>
                <option value="reservasi">Reservasi</option>
                <option value="rusak">Rusak</option>
            </select>
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
            $('#myForm').validate({
                rules: {
                    nomor_meja: {
                        required: true,
                    },
                    

                },
                messages: {
                    nomor_meja: {
                        required: 'Mohon masukkan nomor meja',
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