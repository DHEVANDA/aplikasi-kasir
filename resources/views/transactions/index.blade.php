@extends('layouts.app')

@section('title', 'Daftar Transaksi')

@section('content')
    <div class="container mx-auto p-6">
        <h1 class="text-4xl font-extrabold mb-8 text-center text-gray-900">Daftar Transaksi</h1>

        <!-- Menampilkan pesan sukses jika ada -->
        @if (session('success'))
            <div id="success-alert"
                class="bg-green-100 text-green-800 p-4 rounded-lg shadow-md mb-6 flex items-center justify-between">
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    {{ session('success') }}
                </div>
                <button class="text-green-800 font-bold ml-4"
                    onclick="document.getElementById('success-alert').style.display='none'">
                    &times;
                </button>
            </div>
        @endif

        <div class="overflow-x-auto bg-white shadow-lg rounded-lg">
            <table class="min-w-full table-auto border-collapse">
                <thead>
                    <tr class="bg-gray-900 text-white uppercase text-sm leading-normal shadow-lg">
                        <th class="py-5 px-6 text-left font-semibold text-lg">ID Transaksi</th>
                        <th class="py-5 px-6 text-left font-semibold text-lg">Nama Pembeli</th>
                        <th class="py-5 px-6 text-left font-semibold text-lg">Produk</th>
                        <th class="py-5 px-6 text-right font-semibold text-lg">Total Harga</th>
                        <th class="py-5 px-6 text-left font-semibold text-lg">Metode Pembayaran</th>
                        <th class="py-5 px-6 text-center font-semibold text-lg">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700 text-md font-medium">
                    @forelse ($transactions as $transaction)
                        <tr class="border-b border-gray-300 hover:bg-gray-100 transition duration-300">
                            <td class="py-4 px-6 text-left">
                                <span class="font-bold">{{ $transaction->id }}</span>
                            </td>
                            <td class="py-4 px-6 text-left">
                                <span class="font-semibold">{{ $transaction->name }}</span>
                            </td>
                            <td class="py-4 px-6 text-left">
                                @foreach ($transaction->products as $product)
                                    <div class="text-gray-700">
                                        {{ $product->name }} ({{ $product->pivot->quantity }}x) <br>
                                        <span
                                            class="text-gray-600 text-sm">Rp{{ number_format($product->pivot->price * $product->pivot->quantity, 0, ',', '.') }}</span>
                                    </div>
                                @endforeach
                            </td>
                            <td class="py-4 px-6 text-right">
                                <!-- Tampilkan Total Harga Sebelum Diskon -->
                                @if ($transaction->discount > 0)
                                    <span
                                        class="text-gray-500 line-through">Rp{{ number_format($transaction->total_price / (1 - $transaction->discount / 100), 0, ',', '.') }}</span><br>
                                @endif
                                <!-- Tampilkan Total Harga Setelah Diskon -->
                                <span
                                    class="font-bold text-gray-900">Rp{{ number_format($transaction->total_price, 0, ',', '.') }}</span>
                                <!-- Tampilkan Diskon Jika Ada -->
                                @if ($transaction->discount > 0)
                                    <br>
                                    <span class="text-green-600 text-sm">Diskon: {{ $transaction->discount }}%</span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-left">
                                <span
                                    class="bg-blue-200 text-blue-800 text-sm font-semibold px-3 py-1 rounded-full shadow-md">
                                    {{ ucwords($transaction->payment_method) }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-center">
                                <div class="flex items-center justify-center space-x-3">
                                    <!-- Tombol Hapus dengan konfirmasi -->
                                    <form action="{{ route('transactions.destroy', $transaction->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-500 text-white px-5 py-2 rounded-md shadow-md hover:bg-red-600 transition duration-200 flex items-center">
                                            <i class="fas fa-trash-alt mr-2"></i> Hapus
                                        </button>
                                    </form>

                                    <!-- Tombol Cetak PDF -->
                                    <a href="{{ route('transactions.pdf', $transaction->id) }}" target="_blank"
                                        class="bg-blue-500 text-white px-5 py-2 rounded-md shadow-md hover:bg-blue-600 transition duration-200 flex items-center">
                                        <i class="fas fa-print mr-2"></i> Cetak PDF
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-5 px-6 text-center text-gray-600 font-semibold">
                                Tidak ada transaksi yang ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination Links -->
        <div class="mt-4">
            {{ $transactions->links('pagination::tailwind') }}
        </div>
    </div>
@endsection
