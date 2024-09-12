<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Aplikasi Laravel')</title>
    @vite('resources/css/app.css') <!-- Pastikan Tailwind CSS di-include -->
</head>

<body class="bg-gray-100">
    <nav class="bg-blue-600 p-4 shadow-md">
        <div class="container mx-auto flex justify-between items-center">
            <div class="flex items-center">
                <a href="{{ route('transactions.index') }}"
                    class="text-white text-lg font-bold hover:text-blue-300 transition">Transaksi</a>
                <a href="{{ route('transactions.create') }}"
                    class="ml-4 text-white text-lg hover:text-blue-300 transition">Tambah Transaksi</a>
                {{-- <a href="{{ route('transactions.printPdf') }}"
                    class="ml-4 text-white text-lg hover:text-blue-300 transition">Cetak PDF</a> --}}
                <a href="{{ route('products.index') }}"
                    class="ml-4 text-white text-lg hover:text-blue-300 transition">Daftar Produk</a>
                <!-- Link daftar produk -->
                <a href="{{ route('products.create') }}"
                    class="ml-4 text-white text-lg hover:text-blue-300 transition">Tambah Produk</a>
                <!-- Link tambah produk -->
            </div>
            <div>
                <!-- Tautan logout atau lainnya jika diperlukan -->
            </div>
        </div>
    </nav>

    <main class="container mx-auto p-4">
        @yield('content')
    </main>

    {{-- <footer class="bg-gray-800 text-white text-center p-4">
        <p>&copy; {{ date('Y') }} Aplikasi Laravel. All rights reserved.</p>
    </footer> --}}
</body>

</html>
