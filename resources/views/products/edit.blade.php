<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk</title>
    @vite('resources/css/app.css') <!-- Pastikan Tailwind CSS di-include -->
</head>

<body class="bg-gray-100">

    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Edit Produk</h1>

        <form action="{{ route('products.update', $product->id) }}" method="POST" class="bg-white p-6 rounded-lg shadow">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-semibold mb-2">Nama Produk</label>
                <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}"
                    class="w-full p-2 border border-gray-300 rounded" required>
                @error('name')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="price" class="block text-gray-700 font-semibold mb-2">Harga</label>
                <input type="number" id="price" name="price" value="{{ old('price', $product->price) }}"
                    step="0.01" class="w-full p-2 border border-gray-300 rounded" required>
                @error('price')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="stock" class="block text-gray-700 font-semibold mb-2">Stok</label>
                <input type="number" id="stock" name="stock" value="{{ old('stock', $product->stock) }}"
                    class="w-full p-2 border border-gray-300 rounded" required>
                @error('stock')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Perbarui</button>
            <a href="{{ route('products.index') }}" class="text-blue-500 hover:text-blue-700 ml-4">Kembali</a>
        </form>
    </div>

</body>

</html>
