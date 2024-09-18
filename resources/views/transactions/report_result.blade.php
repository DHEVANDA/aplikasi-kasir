@extends('layouts.app')

@section('title', 'Laporan Bulanan')

@section('content')
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-bold mb-6 text-gray-800 text-center">Laporan Transaksi Bulan
            {{ \Carbon\Carbon::parse($month)->format('F Y') }}</h1>

        @if ($transactions->isEmpty())
            <div class="bg-yellow-100 text-yellow-800 p-4 rounded-lg shadow-lg mb-6 text-center">
                Tidak ada transaksi di bulan ini.
            </div>
        @else
            <div class="overflow-x-auto bg-white shadow-lg rounded-lg">
                <table class="min-w-full table-auto border-collapse">
                    <thead>
                        <tr class="bg-gray-700 text-white text-left text-sm uppercase font-semibold">
                            <th class="py-3 px-6 border-b">No</th>
                            <th class="py-3 px-6 border-b">Produk</th>
                            <th class="py-3 px-6 border-b">Total Harga</th>
                            <th class="py-3 px-6 border-b">Metode Pembayaran</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700 text-sm">
                        @foreach ($transactions as $transaction)
                            <tr class="hover:bg-gray-50 transition duration-200">
                                <td class="py-3 px-6 border-b">{{ $loop->iteration }}</td>
                                <td class="py-3 px-6 border-b">
                                    @foreach ($transaction->products as $product)
                                        {{ $product->name }} ({{ $product->pivot->quantity }}x) <br>
                                    @endforeach
                                </td>
                                <td class="py-3 px-6 border-b">Rp{{ number_format($transaction->total_price, 0, ',', '.') }}
                                </td>
                                <td class="py-3 px-6 border-b">{{ ucfirst($transaction->payment_method) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Tombol Cetak PDF -->
            <form action="{{ route('transactions.exportReportPdf') }}" method="GET" class="text-center mt-6">
                @csrf
                <input type="hidden" name="month" value="{{ $month }}">
                <button type="submit"
                    class="bg-green-500 text-white px-6 py-3 rounded-lg shadow-md hover:bg-green-600 transition duration-300">
                    Cetak PDF
                </button>
            </form>
        @endif
    </div>
@endsection
