<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Aplikasi Laravel')</title>

    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Custom CSS via Vite -->
    @vite('resources/css/app.css')

    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>

<body class="bg-gray-100">
    <!-- Navbar -->
    <nav class="bg-blue-600 p-4 shadow-md">
        <div class="container mx-auto flex justify-between items-center">
            <!-- Brand / Logo -->
            <div class="flex items-center space-x-4">
                <a href="{{ route('transactions.index') }}"
                    class="text-white text-2xl font-bold hover:text-blue-300 transition">
                    <i class="fas fa-cash-register"></i> Transaksi
                </a>

                <!-- Mobile Menu Toggle Button -->
                <div class="lg:hidden">
                    <button id="navbar-toggle" class="text-white focus:outline-none">
                        <i class="fas fa-bars fa-lg"></i>
                    </button>
                </div>
            </div>

            <!-- Desktop Menu -->
            <div class="hidden lg:flex space-x-6">
                <a href="{{ route('transactions.create') }}" class="text-white text-lg hover:text-blue-300 transition">
                    <i class="fas fa-plus-circle"></i> Tambah Transaksi
                </a>
                <a href="{{ route('products.index') }}" class="text-white text-lg hover:text-blue-300 transition">
                    <i class="fas fa-box-open"></i> Daftar Produk
                </a>
                <a href="{{ route('products.create') }}" class="text-white text-lg hover:text-blue-300 transition">
                    <i class="fas fa-plus-square"></i> Tambah Produk
                </a>
                <a href="{{ route('transactions.reportForm') }}"
                    class="text-white text-lg hover:text-blue-300 transition">
                    <i class="fas fa-file-alt"></i> Laporan Transaksi
                </a>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="navbar-menu"
            class="lg:hidden hidden flex-col space-y-4 mt-4 bg-blue-500 p-4 rounded-md shadow-lg transition-all duration-300 ease-in-out">
            <a href="{{ route('transactions.index') }}"
                class="flex items-center text-white hover:text-blue-300 transition">
                <i class="fas fa-cash-register mr-2"></i> Transaksi
            </a>
            <a href="{{ route('transactions.create') }}"
                class="flex items-center text-white hover:text-blue-300 transition">
                <i class="fas fa-plus-circle mr-2"></i> Tambah Transaksi
            </a>
            <a href="{{ route('products.index') }}" class="flex items-center text-white hover:text-blue-300 transition">
                <i class="fas fa-box-open mr-2"></i> Daftar Produk
            </a>
            <a href="{{ route('products.create') }}"
                class="flex items-center text-white hover:text-blue-300 transition">
                <i class="fas fa-plus-square mr-2"></i> Tambah Produk
            </a>
            <a href="{{ route('transactions.reportForm') }}"
                class="flex items-center text-white hover:text-blue-300 transition">
                <i class="fas fa-file-alt mr-2"></i> Laporan Transaksi
            </a>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="container mx-auto p-4">
        @yield('content')
    </main>

    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- Script for mobile menu toggle -->
    <script>
        // Toggle mobile menu
        document.getElementById('navbar-toggle').addEventListener('click', function() {
            var menu = document.getElementById('navbar-menu');
            if (menu.classList.contains('hidden')) {
                menu.classList.remove('hidden');
                menu.classList.add('flex');
            } else {
                menu.classList.add('hidden');
                menu.classList.remove('flex');
            }
        });
    </script>
</body>

</html>
