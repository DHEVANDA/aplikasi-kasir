<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Transaksi #{{ $transaction->id }}</title>
    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            /* Mirip seperti font struk */
            width: 80mm;
            /* Lebar kertas struk standar */
            margin: 0 auto;
            padding: 10px;
            font-size: 12px;
        }

        h2,
        h3,
        p {
            margin: 5px 0;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 5px;
            border-bottom: 1px dashed #000;
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
            font-weight: bold;
        }

        .total {
            font-weight: bold;
            font-size: 14px;
            text-align: right;
        }

        .footer {
            text-align: center;
            margin-top: 10px;
            border-top: 1px dashed #000;
            padding-top: 10px;
        }

        .thank-you {
            font-size: 12px;
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <!-- Judul dan ID Transaksi -->
    <h2>STRUK PEMBELIAN</h2>
    <p>ID Transaksi: {{ $transaction->id }}</p>
    <p>Metode Pembayaran: {{ ucfirst($transaction->payment_method) }}</p>

    <!-- Daftar Produk -->
    <table>
        <thead>
            <tr>
                <th>Produk</th>
                <th>Jumlah</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transaction->products as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->pivot->quantity }}</td>
                    <td>Rp{{ number_format($product->pivot->quantity * $product->pivot->price, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Total Harga Sebelum Diskon (Jika ada diskon) -->
    @if ($transaction->discount > 0)
        <p class="total">Total Sebelum Diskon:
            Rp{{ number_format($transaction->total_price / (1 - $transaction->discount / 100), 0, ',', '.') }}</p>
        <p class="total">Diskon: {{ $transaction->discount }}%</p>
    @endif

    <!-- Total Harga Setelah Diskon -->
    <p class="total">Total: Rp{{ number_format($transaction->total_price, 0, ',', '.') }}</p>

    <!-- Bagian Footer -->
    <div class="footer">
        <p class="thank-you">*** TERIMA KASIH ***</p>
        <p>Toko Contoh</p>
        <p>Jl. Jalan Raya No.123, Kota Contoh</p>
        <p>Telp: (021) 123456789</p>
    </div>
</body>

</html>
