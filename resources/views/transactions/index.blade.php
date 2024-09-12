<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Transaksi</title>
    @vite('resources/css/app.css') <!-- Pastikan Tailwind CSS di-include -->
</head>

<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Daftar Transaksi</h1>

        <a href="{{ route('transactions.create') }}"
            class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">Tambah Transaksi</a>

        @if (session('success'))
            <div class="bg-green-500 text-white p-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <table class="w-full bg-white shadow rounded-lg">
            <thead class="bg-gray-200">
                <tr>
                    <th class="px-4 py-2 border-b">ID</th>
                    <th class="px-4 py-2 border-b">Produk</th>
                    <th class="px-4 py-2 border-b">Jumlah</th>
                    <th class="px-4 py-2 border-b">Harga Total</th>
                    <th class="px-4 py-2 border-b">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transactions as $transaction)
                    <tr>
                        <td class="px-4 py-2 border-b">{{ $transaction->id }}</td>
                        <td class="px-4 py-2 border-b">{{ $transaction->product->name }}</td>
                        <td class="px-4 py-2 border-b">{{ $transaction->quantity }}</td>
                        <td class="px-4 py-2 border-b">${{ $transaction->total_price }}</td>
                        <td class="px-4 py-2 border-b">
                            <a href="{{ route('transactions.edit', $transaction->id) }}"
                                class="text-blue-500 hover:text-blue-700">Edit</a>
                            |
                            <form action="{{ route('transactions.destroy', $transaction->id) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>

</html>
