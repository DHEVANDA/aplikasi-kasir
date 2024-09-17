@extends('layouts.app')

@section('title', 'Tambah Transaksi')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Tambah Transaksi</h1>

        <form action="{{ route('transactions.store') }}" method="POST" class="bg-white p-6 rounded-lg shadow">
            @csrf

            <!-- Container untuk transaksi dinamis -->
            <div id="transaction-container">
                <div class="transaction-item mb-4">
                    <div class="mb-4">
                        <label for="product_id_0" class="block text-gray-700 font-semibold mb-2">Produk</label>
                        <select id="product_id_0" name="transactions[0][product_id]"
                            class="w-full p-2 border border-gray-300 rounded" onchange="updateTotalPrice()" required>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}" data-price="{{ $product->price }}">
                                    {{ $product->name }} - ${{ $product->price }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="quantity_0" class="block text-gray-700 font-semibold mb-2">Jumlah</label>
                        <input type="number" id="quantity_0" name="transactions[0][quantity]" min="1" value="1"
                            oninput="updateTotalPrice()" class="w-full p-2 border border-gray-300 rounded" required>
                    </div>

                    <div class="mb-4">
                        <label for="total_price_0" class="block text-gray-700 font-semibold mb-2">Harga Total</label>
                        <input type="text" id="total_price_0" name="transactions[0][total_price]" value="0.00"
                            class="w-full p-2 border border-gray-300 rounded" readonly>
                    </div>

                    <button type="button" class="bg-red-500 text-white px-4 py-2 rounded remove-transaction-btn">
                        Hapus
                    </button>
                </div>
            </div>

            <!-- Tombol untuk menambah transaksi baru -->
            <button type="button" class="bg-green-500 text-white px-4 py-2 rounded mb-4" id="add-transaction-btn">Tambah
                Produk</button>

            <div class="mb-4">
                <label for="payment_method" class="block text-gray-700 font-semibold mb-2">Metode Pembayaran</label>
                <select id="payment_method" name="payment_method" class="w-full p-2 border border-gray-300 rounded"
                    required>
                    <option value="credit_card">Kartu Kredit</option>
                    <option value="paypal">PayPal</option>
                    <option value="bank_transfer">Transfer Bank</option>
                </select>
                @error('payment_method')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Simpan</button>
            <a href="{{ route('transactions.index') }}" class="text-blue-500 hover:text-blue-700 ml-4">Kembali</a>
        </form>
    </div>

    <script>
        let transactionCount = 1;

        // Fungsi untuk menghitung total harga setiap baris transaksi
        function updateTotalPrice() {
            document.querySelectorAll('.transaction-item').forEach((item, index) => {
                const productSelect = item.querySelector(`select[name="transactions[${index}][product_id]"]`);
                const quantityInput = item.querySelector(`input[name="transactions[${index}][quantity]"]`);
                const totalPriceInput = item.querySelector(`input[name="transactions[${index}][total_price]"]`);

                const selectedOption = productSelect.options[productSelect.selectedIndex];
                const price = parseFloat(selectedOption.getAttribute('data-price'));
                const quantity = parseInt(quantityInput.value, 10);

                if (!isNaN(price) && !isNaN(quantity)) {
                    totalPriceInput.value = (price * quantity).toFixed(2);
                } else {
                    totalPriceInput.value = '0.00';
                }
            });
        }

        // Fungsi untuk menambah baris transaksi baru
        document.getElementById('add-transaction-btn').addEventListener('click', function() {
            const transactionContainer = document.getElementById('transaction-container');

            // Template untuk baris transaksi baru
            const newTransactionItem = `
                <div class="transaction-item mb-4">
                    <div class="mb-4">
                        <label for="product_id_${transactionCount}" class="block text-gray-700 font-semibold mb-2">Produk</label>
                        <select id="product_id_${transactionCount}" name="transactions[${transactionCount}][product_id]" class="w-full p-2 border border-gray-300 rounded"
                            onchange="updateTotalPrice()" required>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}" data-price="{{ $product->price }}">
                                    {{ $product->name }} - ${{ $product->price }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="quantity_${transactionCount}" class="block text-gray-700 font-semibold mb-2">Jumlah</label>
                        <input type="number" id="quantity_${transactionCount}" name="transactions[${transactionCount}][quantity]" min="1" value="1"
                            oninput="updateTotalPrice()" class="w-full p-2 border border-gray-300 rounded" required>
                    </div>

                    <div class="mb-4">
                        <label for="total_price_${transactionCount}" class="block text-gray-700 font-semibold mb-2">Harga Total</label>
                        <input type="text" id="total_price_${transactionCount}" name="transactions[${transactionCount}][total_price]" value="0.00"
                            class="w-full p-2 border border-gray-300 rounded" readonly>
                    </div>

                    <button type="button" class="bg-red-500 text-white px-4 py-2 rounded remove-transaction-btn">
                        Hapus
                    </button>
                </div>
            `;

            // Tambahkan elemen baru ke form
            transactionContainer.insertAdjacentHTML('beforeend', newTransactionItem);
            transactionCount++;

            // Daftarkan event listener untuk menghapus baris transaksi
            registerRemoveTransaction();
        });

        // Fungsi untuk mendaftarkan tombol "Hapus" ke setiap baris transaksi
        function registerRemoveTransaction() {
            document.querySelectorAll('.remove-transaction-btn').forEach((btn) => {
                btn.removeEventListener('click', removeTransaction); // Hindari duplikasi event listener
                btn.addEventListener('click', removeTransaction);
            });
        }

        // Fungsi untuk menghapus baris transaksi
        function removeTransaction(event) {
            event.target.closest('.transaction-item').remove();
            updateTotalPrice(); // Update total harga setelah transaksi dihapus
        }

        // Panggil fungsi ini pada load pertama kali untuk mengatur event listener
        registerRemoveTransaction();
    </script>
@endsection
