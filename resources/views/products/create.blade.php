<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk</title>
    @vite('resources/css/app.css') <!-- Pastikan Tailwind CSS di-include -->
</head>

<body class="bg-gray-100">

    <div class="container mx-auto p-6">
        <h1 class="text-4xl font-extrabold text-gray-900 mb-8">Tambah Produk</h1>

        <div class="max-w-md mx-auto bg-white p-8 rounded-lg shadow-lg">
            <form action="{{ route('products.store') }}" method="POST">
                @csrf

                <div class="mb-6">
                    <label for="name" class="block text-gray-700 text-lg font-medium mb-2">Nama Produk</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}"
                        class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="price" class="block text-gray-700 text-lg font-medium mb-2">Harga</label>
                    <input type="number" id="price" name="price" value="{{ old('price') }}" step="0.01"
                        class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>
                    @error('price')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="stock" class="block text-gray-700 text-lg font-medium mb-2">Stok</label>
                    <input type="number" id="stock" name="stock" value="{{ old('stock') }}"
                        class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>
                    @error('stock')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between">
                    <button type="submit"
                        class="bg-blue-600 text-white px-6 py-3 rounded-lg shadow-md hover:bg-blue-700 transition duration-300">Simpan</button>
                    <a href="{{ route('products.index') }}"
                        class="text-blue-600 hover:text-blue-700 text-lg font-medium">Kembali</a>
                </div>
            </form>
        </div>
    </div>

</body>

</html>
