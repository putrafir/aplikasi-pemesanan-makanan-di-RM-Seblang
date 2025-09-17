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

    <div class="sm:ml-64 p-6">
        <h1 class="text-center mb-4 font-bold">Laporan Transaksi</h1>
        <h3 class="mb-5">Gunakan filter untuk melihat laporan transaksi berdasarkan rentang tanggal</h3>

        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <div class="col-lg-12">

                            <form id="myForm" action="{{ route('admin.search.bydate') }}" method="post"
                                enctype="multipart/form-data" class="flex items-center gap-4">
                                @csrf

                                <!-- Tanggal Mulai -->
                                <div>
                                    <label for="tanggal_mulai" class="block mb-1 font-medium">Tanggal Mulai</label>
                                    <input class="form-control" type="date" name="tanggal_awal"
                                        id="example-text-input">
                                </div>

                                <!-- Tanggal Akhir -->
                                <div>
                                    <label for="tanggal_akhir" class="block mb-1 font-medium">Tanggal Akhir</label>
                                    <input class="form-control" type="date" name="tanggal_akhir"
                                        id="example-text-input">
                                </div>

                                <!-- Tombol Filter -->
                                <div class="pt-6">
                                    <button type="submit"
                                        class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded">
                                        <i class="fa-solid fa-filter"></i>
                                        <span class="ml-2">Filter</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</body>

</html>