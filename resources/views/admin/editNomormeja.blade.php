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

    <form id="myForm" action="{{ route('admin.update.nomormeja') }}" method="POST" enctype="multipart/form-data"
        class="max-w-xl mx-auto p-6 bg-white rounded-lg shadow space-y-4">
        @csrf
        <input type="hidden" name="id" value="{{ $nomor_meja->id }}">

        <h3 class="text-2xl font-bold text-center mb-4">Edit Nomor Meja</h3>

        <div>
            <label for="nomor_meja" class="block text-sm font-medium text-gray-700">Nomor Meja</label>
            <input type="text" id="nomor_meja" name="nomor" value="{{ $nomor_meja->nomor }}"
                class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring focus:border-blue-500"
                required>
        </div>

        <div>
            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
            <select id="status" name="status"
                class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring focus:border-blue-500">
                <option value="">-- Pilih Status --</option>
                <option value="tersedia" {{ $nomor_meja->status == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                <option value="terisi" {{ $nomor_meja->status == 'terisi' ? 'selected' : '' }}>Terisi</option>
                <option value="reservasi" {{ $nomor_meja->status == 'reservasi' ? 'selected' : '' }}>Reservasi</option>
                <option value="rusak" {{ $nomor_meja->status == 'rusak' ? 'selected' : '' }}>Rusak</option>
            </select>
        </div>
        

        <!-- Tombol -->
        <div class="flex justify-between pt-4">

            <a href="{{ route('admin.nomormeja') }}"
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