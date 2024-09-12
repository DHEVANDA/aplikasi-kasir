<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Transaksi</title>
    @vite('resources/css/app.css') <!-- Pastikan Tailwind CSS di-include -->
    <script>
        function updateTotalPrice() {
            const productSelect = document.getElementById('product_id');
            const quantityInput = document.getElementById('quantity');
            const totalPriceInput = document.getElementById('total_price');

            const selectedOption = productSelect.options[productSelect.selectedIndex];
            const pricePerUnit = parseFloat(selectedOption.getAttribute('data-price'));
            const quantity = parseInt(quantityInput.value, 10) || 0;

            const totalPrice = pricePerUnit * quantity;
            totalPriceInput.value = totalPrice.toFixed(2);
        }
    </script>
</head>

<body class="bg-gray-100">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Tambah Transaksi</h1>

        <form action="{{ route('transactions.store') }}" method="POST" class="bg-white p-6 rounded-lg shadow">
            @csrf

            <div class="mb-4">
                <label for="product_id" class="block text-gray-700 font-semibold mb-2">Produk</label>
                <select id="product_id" name="product_id" class="w-full p-2 border border-gray-300 rounded"
                    onchange="updateTotalPrice()" required>
                    <option value="">Pilih Produk</option>
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}" data-price="{{ $product->price }}">
                            {{ $product->name }} - ${{ $product->price }}
                        </option>
                    @endforeach
                </select>
                @error('product_id')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="quantity" class="block text-gray-700 font-semibold mb-2">Jumlah</label>
                <input type="number" id="quantity" name="quantity" min="1" value="{{ old('quantity') }}"
                    oninput="updateTotalPrice()" class="w-full p-2 border border-gray-300 rounded" required>
                @error('quantity')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="total_price" class="block text-gray-700 font-semibold mb-2">Harga Total</label>
                <input type="text" id="total_price" name="total_price" value="{{ old('total_price') }}"
                    class="w-full p-2 border border-gray-300 rounded" readonly>
            </div>

            <div class="flex space-x-4">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Simpan</button>
                <button type="submit" name="action" value="save_and_add"
                    class="bg-green-500 text-white px-4 py-2 rounded">Simpan dan Tambah Lagi</button>
                <a href="{{ route('transactions.index') }}" class="bg-red-500 text-white px-4 py-2 rounded">Batal</a>
            </div>
        </form>
    </div>
</body>

</html>
