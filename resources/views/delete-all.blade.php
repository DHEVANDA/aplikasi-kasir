@extends('layouts.app')

@section('title', 'Hapus Semua Data')

@section('content')
    <div class="container mx-auto p-6">
        <h1 class="text-4xl font-extrabold text-gray-900 mb-8 text-center">Hapus Semua Data</h1>

        <div class="max-w-xl mx-auto bg-white p-8 rounded-2xl shadow-xl">
            <p class="text-center text-lg text-gray-700 mb-6">
                Apakah Anda yakin ingin menghapus semua data transaksi dan produk? Tindakan ini tidak bisa dibatalkan.
            </p>

            <!-- Form untuk menghapus semua transaksi -->
            <form action="{{ route('transactions.deleteAll') }}" method="POST" class="mb-4">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="w-full bg-red-500 hover:bg-red-600 text-white font-bold py-3 rounded-lg shadow-lg transition duration-300"
                    onclick="return confirm('Anda yakin ingin menghapus semua transaksi? Ini tidak bisa dibatalkan.')">
                    Hapus Semua Transaksi
                </button>
            </form>

            <!-- Form untuk menghapus semua produk -->
            <form action="{{ route('products.deleteAll') }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="w-full bg-red-500 hover:bg-red-600 text-white font-bold py-3 rounded-lg shadow-lg transition duration-300"
                    onclick="return confirm('Anda yakin ingin menghapus semua produk? Ini tidak bisa dibatalkan.')">
                    Hapus Semua Produk
                </button>
            </form>
        </div>

        <div class="mt-8 text-center">
            <a href="{{ route('transactions.index') }}" class="text-blue-500 hover:text-blue-700 font-medium">
                Kembali ke Transaksi
            </a>
        </div>
    </div>
@endsection
