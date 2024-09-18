@extends('layouts.app')

@section('title', 'Daftar Produk')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-6 text-gray-800">Daftar Produk</h1>

        <!-- Tampilkan pesan sukses jika ada -->
        @if (session('success'))
            <div class="bg-green-500 text-white p-4 rounded-lg mb-4 shadow-lg">
                {{ session('success') }}
            </div>
        @endif

        <!-- Link ke form pembuatan produk -->
        <div class="flex justify-end mb-6">
            <a href="{{ route('products.create') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg shadow transition-all duration-300 ease-in-out">
                Tambah Produk
            </a>
        </div>

        <!-- Tabel daftar produk -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <table class="min-w-full table-auto">
                <thead>
                    <tr class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                        <th class="py-3 px-6 text-left">ID</th>
                        <th class="py-3 px-6 text-left">Nama</th>
                        <th class="py-3 px-6 text-left">Harga</th>
                        <th class="py-3 px-6 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm font-light">
                    @foreach ($products as $product)
                        <tr class="border-b border-gray-200 hover:bg-gray-100 transition duration-200 ease-in-out">
                            <td class="py-3 px-6 text-left whitespace-nowrap">
                                <span class="font-medium">{{ $product->id }}</span>
                            </td>
                            <td class="py-3 px-6 text-left">
                                <span>{{ $product->name }}</span>
                            </td>
                            <td class="py-3 px-6 text-left">
                                <span>Rp{{ number_format($product->price, 0, ',', '.') }}</span>
                            </td>
                            <td class="py-3 px-6 text-center">
                                <div class="flex item-center justify-center">
                                    <!-- Link edit produk -->
                                    <a href="{{ route('products.edit', $product->id) }}"
                                        class="w-4 mr-2 transform hover:text-blue-500 hover:scale-110 transition-transform">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12h.01M7 12h.01M12 16h.01M12 8h.01M4 6v4a1 1 0 001 1h14a1 1 0 001-1V6m-1-1H5m14-1V4a1 1 0 00-1-1h-4.586a1 1 0 00-.707.293L7.293 5.707a1 1 0 00-.293.707V6M7 8h10" />
                                        </svg>
                                    </a>
                                    <!-- Form hapus produk -->
                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST"
                                        class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="w-4 ml-2 transform hover:text-red-500 hover:scale-110 transition-transform">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor" class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
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
        <div class="mt-6">
            {{ $products->links('pagination::tailwind') }} <!-- Menampilkan pagination dengan Tailwind CSS styling -->
        </div>
    </div>
@endsection
