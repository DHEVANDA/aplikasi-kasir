<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Produk</title>
    @vite('resources/css/app.css') <!-- Pastikan Tailwind CSS di-include -->
</head>

<body class="bg-gray-100">

    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Daftar Produk</h1>

        <!-- Tampilkan pesan sukses jika ada -->
        @if (session('success'))
            <div class="bg-green-500 text-white p-4 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- Link ke form pembuatan produk -->
        <a href="{{ route('products.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">Tambah
            Produk</a>

        <!-- Tabel daftar produk -->
        <table class="min-w-full bg-white border border-gray-300 rounded-lg shadow">
            <thead>
                <tr>
                    <th class="px-4 py-2 border-b">ID</th>
                    <th class="px-4 py-2 border-b">Nama</th>
                    <th class="px-4 py-2 border-b">Harga</th>
                    <th class="px-4 py-2 border-b">Stok</th>
                    <th class="px-4 py-2 border-b">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td class="px-4 py-2 border-b">{{ $product->id }}</td>
                        <td class="px-4 py-2 border-b">{{ $product->name }}</td>
                        <td class="px-4 py-2 border-b">{{ number_format($product->price, 2) }}</td>
                        <td class="px-4 py-2 border-b">{{ $product->stock }}</td>
                        <td class="px-4 py-2 border-b">
                            <!-- Link edit produk -->
                            <a href="{{ route('products.edit', $product->id) }}"
                                class="text-blue-500 hover:text-blue-700">Edit</a>

                            <!-- Form hapus produk -->
                            <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</body>

</html>
