@extends('layouts.app')

@section('title', 'Edit Produk')

@section('content')
    <div class="container mx-auto p-6">
        <h1 class="text-4xl font-extrabold text-gray-900 mb-8">Edit Produk</h1>

        <div class="max-w-md mx-auto bg-white p-8 rounded-lg shadow-lg">
            <form action="{{ route('products.update', $product->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-6">
                    <label for="name" class="block text-gray-700 text-lg font-medium mb-2">Nama Produk</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}"
                        class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="price" class="block text-gray-700 text-lg font-medium mb-2">Harga</label>
                    <input type="number" id="price" name="price" value="{{ old('price', $product->price) }}"
                        step="0.01"
                        class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>
                    @error('price')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="stock" class="block text-gray-700 text-lg font-medium mb-2">Stok</label>
                    <input type="number" id="stock" name="stock" value="{{ old('stock', $product->stock) }}"
                        class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>
                    @error('stock')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between">
                    <button type="submit"
                        class="bg-blue-600 text-white px-6 py-3 rounded-lg shadow-md hover:bg-blue-700 transition duration-300">Perbarui</button>
                    <a href="{{ route('products.index') }}"
                        class="text-blue-600 hover:text-blue-700 text-lg font-medium">Kembali</a>
                </div>
            </form>
        </div>
    </div>
@endsection
