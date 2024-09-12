<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Transaksi</title>
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
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Edit Transaksi</h1>

        <form action="{{ route('transactions.update', $transaction->id) }}" method="POST"
            class="bg-white p-6 rounded-lg shadow">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="product_id" class="block text-gray-700 font-semibold mb-2">Produk</label>
                <select id="product_id" name="product_id" class="w-full p-2 border border-gray-300 rounded"
                    onchange="updateTotalPrice()" required>
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}" data-price="{{ $product->price }}"
                            {{ $transaction->product_id == $product->id ? 'selected' : '' }}>
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
                <input type="number" id="quantity" name="quantity" min="1"
                    value="{{ old('quantity', $transaction->quantity) }}" oninput="updateTotalPrice()"
                    class="w-full p-2 border border-gray-300 rounded" required>
                @error('quantity')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="total_price" class="block text-gray-700 font-semibold mb-2">Harga Total</label>
                <input type="text" id="total_price" name="total_price"
                    value="{{ old('total_price', $transaction->total_price) }}"
                    class="w-full p-2 border border-gray-300 rounded" readonly>
            </div>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Update</button>
            <a href="{{ route('transactions.index') }}" class="text-blue-500 hover:text-blue-700 ml-4">Kembali</a>
        </form>
    </div>
</body>

</html>
