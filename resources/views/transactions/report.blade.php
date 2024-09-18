@extends('layouts.app')

@section('title', 'Laporan Transaksi')

@section('content')
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-bold mb-6 text-gray-800 text-center">Laporan Transaksi</h1>

        <!-- Form untuk memilih bulan -->
        <form action="{{ route('transactions.generateReport') }}" method="POST"
            class="bg-white p-8 rounded-lg shadow-2xl max-w-md mx-auto">
            @csrf

            <div class="mb-6">
                <label for="month" class="block text-gray-700 font-semibold mb-2">Pilih Bulan</label>
                <input type="month" id="month" name="month"
                    class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 shadow-sm"
                    required>
            </div>

            <button type="submit"
                class="bg-blue-500 text-white px-6 py-3 rounded-lg shadow-md hover:bg-blue-600 transition duration-300">
                Lihat Laporan
            </button>
        </form>
    </div>
@endsection
