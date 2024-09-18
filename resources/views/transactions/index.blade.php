@extends('layouts.app')

@section('title', 'Daftar Transaksi')

@section('content')
    <div class="text-center container mx-auto p-6">
        <h1 class="text-3xl font-bold mb-6 text-gray-800">Daftar Transaksi</h1>

        <!-- Menampilkan pesan sukses jika ada -->
        @if (session('success'))
            <div class="bg-green-100 text-green-800 p-4 rounded-lg shadow-lg mb-6">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto bg-white shadow-lg rounded-lg">
            <table class="min-w-full table-auto border-collapse">
                <thead>
                    <tr>
                        <th class="py-3 px-6 border-b">ID Transaksi</th> <!-- Kolom untuk ID Transaksi -->
                        <th class="py-3 px-6 border-b">Nama Transaksi</th> <!-- Kolom untuk Nama -->
                        <th class="py-3 px-6 border-b">Produk</th> <!-- Kolom untuk Produk -->
                        <th class="py-3 px-6 border-b">Total Harga</th>
                        <th class="py-3 px-6 border-b">Metode Pembayaran</th>
                        <th class="py-3 px-6 border-b text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Menggunakan forelse untuk menampilkan transaksi atau menampilkan pesan kosong -->
                    @forelse ($transactions as $transaction)
                        <tr class="hover:bg-gray-50 transition duration-200">
                            <td class="py-3 px-6 border-b">{{ $transaction->id }}</td> <!-- Tampilkan ID transaksi -->
                            <td class="py-3 px-6 border-b">{{ $transaction->name }}</td> <!-- Tampilkan nama transaksi -->
                            <td class="py-3 px-6 border-b">
                                @foreach ($transaction->products as $product)
                                    {{ $product->name }} ({{ $product->pivot->quantity }}x) -
                                    Rp{{ number_format($product->pivot->price * $product->pivot->quantity, 0, ',', '.') }}
                                    <br>
                                @endforeach
                            </td>
                            <td class="py-3 px-6 border-b">Rp{{ number_format($transaction->total_price, 0, ',', '.') }}
                            </td>
                            <td class="py-3 px-6 border-b">{{ ucwords($transaction->payment_method) }}</td>
                            <td class="py-3 px-6 border-b text-center">
                                <!-- Tombol Hapus dengan konfirmasi -->
                                <form action="{{ route('transactions.destroy', $transaction->id) }}" method="POST"
                                    class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg shadow-md transition duration-300"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus transaksi ini?')">
                                        Hapus
                                    </button>
                                </form>
                                <!-- Tombol Cetak PDF -->
                                <a href="{{ route('transactions.pdf', $transaction->id) }}" target="_blank"
                                    class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg shadow-md transition duration-300 ml-2">
                                    Cetak PDF
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-3 px-6 text-center">Tidak ada transaksi yang ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
