@extends('layouts.app')

@section('title', 'Daftar Produk')

@section('content')
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-bold mb-8 text-center text-gray-800">Daftar Produk</h1>

        <!-- Tampilkan pesan sukses jika ada -->
        @if (session('success'))
            <div class="bg-green-100 text-green-800 p-4 rounded-lg mb-6 shadow-lg flex items-center justify-center">
                <i class="fas fa-check-circle mr-2"></i>
                {{ session('success') }}
            </div>
        @endif

        <!-- Link ke form pembuatan produk -->
        <div class="flex justify-end mb-6">
            <a href="{{ route('products.create') }}"
                class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition-all duration-300 ease-in-out">
                <i class="fas fa-plus mr-2"></i> Tambah Produk
            </a>
        </div>

        <!-- Tabel daftar produk -->
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <table class="min-w-full table-auto">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="py-4 px-6 text-left text-sm font-semibold">ID</th>
                        <th class="py-4 px-6 text-left text-sm font-semibold">Nama Produk</th>
                        <th class="py-4 px-6 text-left text-sm font-semibold">Harga</th>
                        <th class="py-4 px-6 text-center text-sm font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    @foreach ($products as $product)
                        <tr class="border-b border-gray-200 hover:bg-gray-100 transition duration-200">
                            <td class="py-4 px-6 text-left">{{ $product->id }}</td>
                            <td class="py-4 px-6 text-left">{{ $product->name }}</td>
                            <td class="py-4 px-6 text-left">Rp{{ number_format($product->price, 0, ',', '.') }}</td>
                            <td class="py-4 px-6 text-center">
                                <div class="flex justify-center space-x-4">
                                    <!-- Link edit produk -->
                                    <a href="{{ route('products.edit', $product->id) }}"
                                        class="bg-yellow-400 hover:bg-yellow-500 text-white py-2 px-3 rounded-md shadow-md transition duration-300 ease-in-out">
                                        <i class="fas fa-edit mr-1"></i> Edit
                                    </a>

                                    <!-- Form hapus produk -->
                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST"
                                        class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-500 hover:bg-red-600 text-white py-2 px-3 rounded-md shadow-md transition duration-300 ease-in-out"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
                                            <i class="fas fa-trash-alt mr-1"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination links -->
        <div class="mt-6 flex justify-center">
            {{ $products->links('pagination::tailwind') }}
        </div>
    </div>
@endsection
