@extends('layouts.app')

@section('title', 'Tambah Transaksi')

@section('content')
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-bold mb-6 text-center text-gray-900">Tambah Transaksi</h1>

        <form action="{{ route('transactions.store') }}" method="POST"
            class="bg-white p-8 rounded-lg shadow-2xl max-w-3xl mx-auto">
            @csrf

            <!-- Input untuk nama transaksi -->
            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-semibold mb-2">Nama Pembeli</label>
                <input type="text" id="name" name="name"
                    class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 shadow-sm"
                    placeholder="Masukkan nama Pembeli" required>
            </div>

            <!-- Container untuk transaksi dinamis -->
            <div id="transaction-container">
                <!-- Contoh Produk -->
                <div class="transaction-item mb-4 flex items-center space-x-4" data-index="0">
                    <div class="flex-1">
                        <label for="product_id_0" class="block text-gray-700 font-semibold mb-2">Produk</label>
                        <select id="product_id_0" name="transactions[0][product_id]"
                            class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 shadow-sm product-select"
                            onchange="updateTotalPrice()" required>
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
                        <input type="number" id="quantity_0" name="transactions[0][quantity]" min="1" value="1"
                            oninput="updateTotalPrice()"
                            class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 shadow-sm"
                            required>
                    </div>

                    <div class="flex-1">
                        <label for="total_price_0" class="block text-gray-700 font-semibold mb-2">Harga Total</label>
                        <input type="text" id="total_price_0" name="transactions[0][total_price]" value="Rp0,00"
                            class="w-full p-3 border border-gray-300 rounded-lg bg-gray-100 shadow-sm" readonly>
                    </div>

                    <button type="button"
                        class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition duration-300 shadow-md remove-transaction-btn">
                        Hapus
                    </button>
                </div>
            </div>

            <!-- Tambahkan elemen untuk menampilkan total harga keseluruhan -->
            <div class="mb-6">
                <label for="grand_total" class="block text-gray-700 font-semibold mb-2">Total Belanja Keseluruhan</label>
                <input type="text" id="grand_total"
                    class="w-full p-3 border border-gray-300 rounded-lg bg-gray-100 shadow-sm" value="Rp0,00" readonly>
            </div>

            <!-- Tombol untuk menambah transaksi baru -->
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
                </select>
            </div>

            <div class="flex justify-between">
                <button type="submit"
                    class="bg-blue-500 text-white px-6 py-3 rounded-lg shadow-md hover:bg-blue-600 transition duration-300">
                    Simpan
                </button>
                <a href="{{ route('transactions.index') }}"
                    class="text-blue-500 hover:text-blue-700 text-lg font-medium">Kembali</a>
            </div>
        </form>
    </div>

    <!-- Script untuk memformat dan menghitung harga -->
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

            // Cek jika tidak ada transaksi
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

                if (!isNaN(price) && !isNaN(quantity)) {
                    const total = price * quantity;
                    totalPriceInput.value = formatRupiah(total);
                    grandTotal += total; // Tambahkan harga ke total keseluruhan
                } else {
                    totalPriceInput.value = 'Rp0,00';
                }
            });

            // Perbarui total belanja keseluruhan
            document.getElementById('grand_total').value = formatRupiah(grandTotal);
        }

        // Fungsi untuk menambah baris transaksi baru
        document.getElementById('add-transaction-btn').addEventListener('click', function() {
            const transactionContainer = document.getElementById('transaction-container');

            // Template untuk baris transaksi baru
            const newTransactionItem = `
                <div class="transaction-item mb-4 flex items-center space-x-4" data-index="${transactionCount}">
                    <div class="flex-1">
                        <label for="product_id_${transactionCount}" class="block text-gray-700 font-semibold mb-2">Produk</label>
                        <select id="product_id_${transactionCount}" name="transactions[${transactionCount}][product_id]" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 shadow-sm product-select"
                            onchange="updateTotalPrice()" required>
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
                        <input type="number" id="quantity_${transactionCount}" name="transactions[${transactionCount}][quantity]" min="1" value="1"
                            oninput="updateTotalPrice()" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 shadow-sm"
                            required>
                    </div>

                    <div class="flex-1">
                        <label for="total_price_${transactionCount}" class="block text-gray-700 font-semibold mb-2">Harga Total</label>
                        <input type="text" id="total_price_${transactionCount}" name="transactions[${transactionCount}][total_price]" value="Rp0,00"
                            class="w-full p-3 border border-gray-300 rounded-lg bg-gray-100 shadow-sm" readonly>
                    </div>

                    <button type="button" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition duration-300 shadow-md remove-transaction-btn">
                        Hapus
                    </button>
                </div>
            `;

            // Tambahkan elemen baru ke form
            transactionContainer.insertAdjacentHTML('beforeend', newTransactionItem);
            transactionCount++;

            // Daftarkan event listener untuk menghapus baris transaksi
            registerRemoveTransaction();

            // Inisialisasi Select2 di dropdown baru dengan matcher custom
            $('.product-select').select2({
                placeholder: 'Cari Produk',
                allowClear: true,
                matcher: matchStart
            });

            // Trigger manual update harga total
            updateTotalPrice();
        });

        // Fungsi custom matcher untuk Select2 (match hanya di awal string)
        function matchStart(params, data) {
            // Jika tidak ada term pencarian, tampilkan data asli
            if ($.trim(params.term) === '') {
                return data;
            }

            // Pastikan data memiliki properti text
            if (typeof data.text === 'undefined') {
                return null;
            }

            // Hanya tampilkan hasil yang cocok di awal string
            if (data.text.toUpperCase().indexOf(params.term.toUpperCase()) === 0) {
                return $.extend({}, data, true);
            }

            // Jika tidak cocok, kembalikan null
            return null;
        }

        // Inisialisasi Select2 dengan matcher custom pada halaman load
        $(document).ready(function() {
            $('.product-select').select2({
                placeholder: 'Cari Produk',
                allowClear: true,
                matcher: matchStart
            });
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

        // Panggil fungsi ini pada load pertama kali untuk mengatur event listener
        registerRemoveTransaction();
    </script>
@endsection
