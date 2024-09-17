@extends('layouts.app')

@section('title', 'Daftar Transaksi')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Daftar Transaksi</h1>

        @if (session('success'))
            <div class="bg-green-100 text-green-800 p-2 rounded-lg mb-4">
                {{ session('success') }}
            </div>
        @endif

        <table class="min-w-full bg-white border">
            <thead>
                <tr>
                    <th class="py-2 px-4 border">ID Transaksi</th>
                    <th class="py-2 px-4 border">Produk</th>
                    <th class="py-2 px-4 border">Total Harga</th>
                    <th class="py-2 px-4 border">Metode Pembayaran</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transactions as $transaction)
                    <tr>
                        <td class="py-2 px-4 border">{{ $transaction->id }}</td>
                        <td class="py-2 px-4 border">
                            @foreach ($transaction->products as $product)
                                {{ $product->name }} ({{ $product->pivot->quantity }}x) <br>
                            @endforeach
                        </td>
                        <td class="py-2 px-4 border">${{ $transaction->total_price }}</td>
                        <td class="py-2 px-4 border">{{ ucfirst($transaction->payment_method) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
