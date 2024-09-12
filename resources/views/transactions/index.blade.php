@extends('layouts.app')

@section('title', 'Daftar Transaksi')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-bold mb-6">Daftar Transaksi</h1>

        <!-- Formulir untuk memilih transaksi dan cetak PDF -->
        <form action="{{ route('transactions.printSelectedPdf') }}" method="POST">
            @csrf
            <div class="mb-6 flex space-x-4">
                <a href="{{ route('transactions.create') }}"
                    class="bg-green-600 text-white px-4 py-2 rounded shadow hover:bg-green-700 transition">
                    Tambah Transaksi
                </a>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700 transition">
                    Cetak PDF Terpilih
                </button>
            </div>

            <!-- Daftar transaksi -->
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-300 rounded-lg shadow-md">
                    <thead class="bg-gray-100 text-gray-700">
                        <tr class="border-b">
                            <th class="py-2 px-4 text-left">Pilih</th>
                            <th class="py-2 px-4 text-left">ID</th>
                            <th class="py-2 px-4 text-left">Produk</th>
                            <th class="py-2 px-4 text-left">Jumlah</th>
                            <th class="py-2 px-4 text-left">Harga Total</th>
                            <th class="py-2 px-4 text-left">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600">
                        @foreach ($transactions as $transaction)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="py-2 px-4">
                                    <input type="checkbox" name="transaction_ids[]" value="{{ $transaction->id }}">
                                </td>
                                <td class="py-2 px-4">{{ $transaction->id }}</td>
                                <td class="py-2 px-4">{{ $transaction->product->name }}</td>
                                <td class="py-2 px-4">{{ $transaction->quantity }}</td>
                                <td class="py-2 px-4">${{ number_format($transaction->total_price, 2) }}</td>
                                <td class="py-2 px-4">{{ $transaction->created_at->format('d-m-Y H:i:s') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </form>
    </div>
@endsection
