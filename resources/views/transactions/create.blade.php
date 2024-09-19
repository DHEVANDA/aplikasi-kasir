@extends('layouts.app')

@section('title', 'Tambah Transaksi')

@section('content')
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-bold mb-6 text-center text-gray-900">Tambah Transaksi</h1>

        <form action="{{ route('transactions.store') }}" method="POST" class="bg-white p-8 rounded-lg shadow-2xl mx-auto">
            @csrf

            <!-- Input untuk nama pembeli -->
            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-semibold mb-2">Nama Pembeli</label>
                <input type="text" id="name" name="name"
                    class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 shadow-sm"
                    placeholder="Masukkan nama Pembeli" required>
            </div>

            <!-- Container untuk transaksi dinamis -->
            <div id="transaction-container">
                <div class="transaction-item mb-4 flex items-center space-x-4" data-index="0">
                    <div class="flex-1">
                        <label for="product_id_0" class="block text-gray-700 font-semibold mb-2">Produk</label>
                        <select id="product_id_0" name="transactions[0][product_id]"
                            class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 shadow-sm product-select"
                            onchange="handleProductChange(this, 0);" required>
                            <option value="" disabled selected>Pilih Produk</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}" data-price="{{ $product->price }}">
                                    {{ $product->name }} - Rp{{ number_format($product->price, 0, ',', '.') }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex-1">
                        <label for="quantity_0" class="block text-gray-700 font-semibold mb-2">Jumlah</label>
                        <input type="number" id="quantity_0" name="transactions[0][quantity]" min="1000" value="0"
                            oninput="checkMinimumQuantity(this); updateTotalPrice();"
                            class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 shadow-sm"
                            required disabled>
                    </div>

                    <div class="flex-1">
                        <label for="total_price_0" class="block text-gray-700 font-semibold mb-2">Harga Total</label>
                        <input type="text" id="total_price_0" name="transactions[0][total_price]" value="Rp0,00"
                            class="w-full p-3 border border-gray-300 rounded-lg bg-gray-100 shadow-sm" readonly>
                    </div>

                    <button type="button"
                        class="bg-red-500 text-white px-4 py-2 mt-9 rounded-lg hover:bg-red-600 transition duration-300 shadow-md remove-transaction-btn">
                        Hapus
                    </button>
                </div>
            </div>

            <!-- Diskon -->
            <div class="mb-6">
                <label for="discount" class="block text-gray-700 font-semibold mb-2">Diskon (%)</label>
                <input type="number" id="discount" name="discount" min="0" max="100" value="0"
                    class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 shadow-sm"
                    oninput="updateTotalPrice()" required>
            </div>

            <!-- Total Belanja Keseluruhan -->
            <div class="mb-6">
                <label for="grand_total" class="block text-gray-700 font-semibold mb-2">Total Belanja Keseluruhan</label>
                <input type="text" id="grand_total"
                    class="w-full p-3 border border-gray-300 rounded-lg bg-gray-100 shadow-sm" value="Rp0,00" readonly>
            </div>

            <button type="button"
                class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition duration-300 mb-6 shadow-md"
                id="add-transaction-btn">Tambah Produk</button>

            <div class="mb-6">
                <label for="payment_method" class="block text-gray-700 font-semibold mb-2">Metode Pembayaran</label>
                <select id="payment_method" name="payment_method"
                    class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 shadow-sm"
                    required>
                    <option value="credit_card">Kartu Kredit</option>
                    <option value="paypal">PayPal</option>
                    <option value="bank_transfer">Transfer Bank</option>
                    <option value="cash">Cash</option>
                </select>
            </div>

            <div class="flex justify-between">
                <button type="submit"
                    class="bg-blue-500 text-white px-6 py-3 rounded-lg shadow-md hover:bg-blue-600 transition duration-300">
                    Simpan
                </button>
                <a href="{{ route('transactions.index') }}"
                    class="bg-red-500 text-white px-6 py-3 rounded-lg shadow-md hover:bg-red-600 transition duration-300">Kembali</a>
            </div>
        </form>
    </div>

    <script>
        let transactionCount = 1;

        // Fungsi untuk memformat angka menjadi Rupiah
        function formatRupiah(angka) {
            let numberString = angka.toString().replace(/[^,\d]/g, '');
            let split = numberString.split(',');
            let sisa = split[0].length % 3;
            let rupiah = split[0].substr(0, sisa) + split[0].substr(sisa).match(/\d{3}/gi).join('.');
            return 'Rp' + rupiah + (split[1] ? ',' + split[1] : '');
        }

        // Fungsi untuk menghitung total harga setiap baris transaksi dan total keseluruhan
        function updateTotalPrice() {
            let grandTotal = 0;

            const transactionItems = document.querySelectorAll('.transaction-item');
            const discountInput = document.getElementById('discount');
            const discount = parseFloat(discountInput.value) || 0;

            if (transactionItems.length === 0) {
                document.getElementById('grand_total').value = 'Rp0,00'; // Set total menjadi Rp0,00
                return;
            }

            transactionItems.forEach((item) => {
                const productSelect = item.querySelector('select');
                const quantityInput = item.querySelector('input[type="number"]');
                const totalPriceInput = item.querySelector('input[name*="total_price"]');

                const selectedOption = productSelect.options[productSelect.selectedIndex];
                const price = parseFloat(selectedOption.getAttribute('data-price'));
                const quantity = parseInt(quantityInput.value, 10);

                // Pastikan produk dan jumlah valid, jika tidak, set ke 0
                if (!isNaN(price) && !isNaN(quantity) && quantity >= 1000) {
                    const total = price * quantity;
                    totalPriceInput.value = formatRupiah(total);
                    grandTotal += total; // Tambahkan harga ke total keseluruhan
                } else {
                    totalPriceInput.value = 'Rp0,00'; // Reset total harga jika produk tidak valid
                }
            });

            // Hitung grand total setelah diskon
            if (grandTotal > 0 && discount > 0) {
                grandTotal = grandTotal - (grandTotal * (discount / 100));
            }

            // Perbarui total belanja keseluruhan
            document.getElementById('grand_total').value = formatRupiah(grandTotal);
        }

        // Fungsi untuk memeriksa minimum pembelian
        function checkMinimumQuantity(input) {
            if (input.value < 1000) {
                input.value = 1000;
            }
        }

        // Fungsi untuk mengatur harga dan jumlah menjadi 0 jika produk tidak dipilih
        function handleProductChange(selectElement, index) {
            const quantityInput = document.getElementById(`quantity_${index}`);
            const totalPriceInput = document.getElementById(`total_price_${index}`);

            if (selectElement.value) {
                quantityInput.disabled = false;
                quantityInput.value = 1000; // Set jumlah default ke 1000 setelah produk dipilih
                totalPriceInput.value = "Rp0,00"; // Reset total harga saat produk diubah
            } else {
                // Jika produk tidak jadi dipilih, reset jumlah dan total harga ke 0
                quantityInput.disabled = true;
                quantityInput.value = 0;
                totalPriceInput.value = "Rp0,00";
            }
            updateTotalPrice(); // Selalu panggil updateTotalPrice untuk memperbarui total keseluruhan
        }

        // Fungsi untuk menambah baris transaksi baru
        document.getElementById('add-transaction-btn').addEventListener('click', function() {
            const transactionContainer = document.getElementById('transaction-container');

            const newTransactionItem = `
                <div class="transaction-item mb-4 flex items-center space-x-4" data-index="${transactionCount}">
                    <div class="flex-1">
                        <label for="product_id_${transactionCount}" class="block text-gray-700 font-semibold mb-2">Produk</label>
                        <select id="product_id_${transactionCount}" name="transactions[${transactionCount}][product_id]" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 shadow-sm product-select" onchange="handleProductChange(this, ${transactionCount});" required>
                            <option value="" disabled selected>Pilih Produk</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}" data-price="{{ $product->price }}">
                                    {{ $product->name }} - Rp{{ number_format($product->price, 0, ',', '.') }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex-1">
                        <label for="quantity_${transactionCount}" class="block text-gray-700 font-semibold mb-2">Jumlah</label>
                        <input type="number" id="quantity_${transactionCount}" name="transactions[${transactionCount}][quantity]" min="1000" value="0" oninput="checkMinimumQuantity(this); updateTotalPrice();" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 shadow-sm" required disabled>
                    </div>

                    <div class="flex-1">
                        <label for="total_price_${transactionCount}" class="block text-gray-700 font-semibold mb-2">Harga Total</label>
                        <input type="text" id="total_price_${transactionCount}" name="transactions[${transactionCount}][total_price]" value="Rp0,00" class="w-full p-3 border border-gray-300 rounded-lg bg-gray-100 shadow-sm" readonly>
                    </div>

                    <button type="button" class="bg-red-500 text-white px-4 py-2 mt-9 rounded-lg hover:bg-red-600 transition duration-300 shadow-md remove-transaction-btn">Hapus</button>
                </div>
            `;

            transactionContainer.insertAdjacentHTML('beforeend', newTransactionItem);
            transactionCount++;

            // Daftarkan event listener untuk menghapus baris transaksi
            registerRemoveTransaction();

            // Inisialisasi Select2 pada dropdown baru
            $('.product-select').select2({
                placeholder: 'Cari Produk',
                allowClear: true
            });

            // Trigger manual update harga total
            updateTotalPrice();
        });

        // Fungsi untuk mendaftarkan tombol "Hapus" ke setiap baris transaksi
        function registerRemoveTransaction() {
            document.querySelectorAll('.remove-transaction-btn').forEach((btn) => {
                btn.removeEventListener('click', removeTransaction); // Hindari duplikasi event listener
                btn.addEventListener('click', removeTransaction);
            });
        }

        // Fungsi untuk menghapus baris transaksi dan memperbarui harga total
        function removeTransaction(event) {
            event.target.closest('.transaction-item').remove();
            updateTotalPrice(); // Update total harga setelah transaksi dihapus

            // Re-index transaksi setelah penghapusan
            reindexTransactions();
        }

        // Fungsi untuk memperbarui index semua transaksi yang ada
        function reindexTransactions() {
            let index = 0;
            document.querySelectorAll('.transaction-item').forEach((item) => {
                item.setAttribute('data-index', index);
                item.querySelectorAll('select, input').forEach((el) => {
                    const name = el.name.replace(/\d+/g,
                        index); // Replace angka pada name dengan index baru
                    el.name = name;
                    el.id = el.id.replace(/\d+/g, index); // Ganti id sesuai index baru
                });
                index++;
            });
            transactionCount = index;
        }

        // Inisialisasi Select2 pada halaman pertama kali load
        $(document).ready(function() {
            $('.product-select').select2({
                placeholder: 'Cari Produk',
                allowClear: true
            });

            // Panggil fungsi ini pada load pertama kali untuk mengatur event listener
            registerRemoveTransaction();
        });
    </script>
@endsection
