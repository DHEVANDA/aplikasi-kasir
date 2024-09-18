@extends('layouts.app')

@section('title', 'Edit Produk')

@section('content')
    <div class="container mx-auto p-6">
        <h1 class="text-4xl font-extrabold text-gray-900 mb-8 text-center">Edit Produk</h1>

        <div
            class="max-w-lg mx-auto bg-gradient-to-r from-white via-blue-50 to-white p-8 rounded-2xl shadow-2xl transition-shadow hover:shadow-xl duration-300 ease-in-out">
            <form action="{{ route('products.update', $product->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Input Nama Produk -->
                <div class="mb-6">
                    <label for="name" class="block text-gray-700 text-lg font-semibold mb-2">Nama Produk</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}"
                        class="w-full p-3 bg-white border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-300"
                        placeholder="Nama Produk" required>
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Input Harga -->
                <div class="mb-6">
                    <label for="price" class="block text-gray-700 text-lg font-semibold mb-2">Harga</label>
                    <input type="number" id="price" name="price" value="{{ old('price', $product->price) }}"
                        step="0.01"
                        class="w-full p-3 bg-white border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-300"
                        placeholder="Harga Produk" required>
                    @error('price')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>


                <!-- Tombol Perbarui dan Kembali -->
                <div class="flex items-center justify-between mt-8">
                    <button type="submit"
                        class="bg-blue-600 text-white px-6 py-3 rounded-lg shadow-lg hover:bg-blue-700 hover:shadow-xl transition duration-300 transform hover:scale-105">
                        Perbarui
                    </button>
                    <a href="{{ route('products.index') }}"
                        class="text-blue-600 hover:text-blue-700 text-lg font-medium transition-colors duration-300">Kembali</a>
                </div>
            </form>
        </div>
    </div>
@endsection
