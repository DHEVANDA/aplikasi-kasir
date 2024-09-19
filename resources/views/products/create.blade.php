@extends('layouts.app')

@section('title', 'Tambah Produk')

@section('content')
    <div class="container mx-auto p-6">
        <h1 class="text-4xl font-extrabold text-gray-900 mb-8 text-center">Tambah Produk</h1>

        <div
            class="max-w-lg mx-auto bg-gradient-to-r from-white via-blue-50 to-white p-8 rounded-2xl shadow-2xl transition-shadow hover:shadow-xl duration-300 ease-in-out">
            <form action="{{ route('products.store') }}" method="POST">
                @csrf

                <!-- Nama Produk Input -->
                <div class="mb-6">
                    <label for="name" class="block text-gray-700 text-lg font-semibold mb-2">Nama Produk</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}"
                        class="w-full p-3 bg-white border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-300"
                        placeholder="Masukkan nama produk" required>
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Harga Produk Input -->
                <div class="mb-6">
                    <label for="price" class="block text-gray-700 text-lg font-semibold mb-2">Harga</label>
                    <input type="text" id="price" name="price" value="{{ old('price') }}"
                        class="w-full p-3 bg-white border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-300"
                        placeholder="Masukkan harga produk" required>
                    @error('price')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tombol Simpan dan Kembali -->
                <div class="flex items-center justify-center mt-8">
                    <button type="submit"
                        class="bg-blue-600 text-white px-6 py-3 rounded-lg shadow-lg hover:bg-blue-700 hover:shadow-xl transition duration-300 transform hover:scale-105">
                        Simpan
                    </button>
                    {{-- <a href="{{ route('products.index') }}"
                        class="bg-red-500 text-white px-6 py-3 rounded-lg shadow-md hover:bg-red-600 transition duration-300">
                        Kembali
                    </a> --}}
                </div>
            </form>
        </div>
    </div>
@endsection
