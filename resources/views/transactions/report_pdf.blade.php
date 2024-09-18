<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Bulanan {{ \Carbon\Carbon::parse($month)->format('F Y') }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 8px;
            border: 1px solid #ddd;
        }

        th {
            background-color: #f4f4f4;
        }
    </style>
</head>

<body>
    <h2>Laporan Transaksi Bulan {{ \Carbon\Carbon::parse($month)->format('F Y') }}</h2>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Produk</th>
                <th>Total Harga</th>
                <th>Metode Pembayaran</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transactions as $transaction)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        @foreach ($transaction->products as $product)
                            {{ $product->name }} ({{ $product->pivot->quantity }}x) <br>
                        @endforeach
                    </td>
                    <td>Rp{{ number_format($transaction->total_price, 0, ',', '.') }}</td>
                    <td>{{ ucfirst($transaction->payment_method) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
