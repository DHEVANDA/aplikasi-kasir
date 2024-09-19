<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Bulanan {{ \Carbon\Carbon::parse($month)->format('F Y') }}</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f9f9f9;
            color: #333;
        }

        h2 {
            text-align: center;
            color: #4A90E2;
            margin-bottom: 20px;
            font-size: 24px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: white;
        }

        th,
        td {
            padding: 12px 15px;
            text-align: left;
            font-size: 14px;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #4A90E2;
            color: white;
            text-transform: uppercase;
            font-size: 13px;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        td {
            color: #555;
        }

        /* Highlight rows */
        tbody tr:nth-child(even) {
            background-color: #f7f7f7;
        }

        tbody tr:nth-child(odd) {
            background-color: #fff;
        }

        /* Responsive design */
        @media (max-width: 768px) {
            table {
                font-size: 12px;
            }

            h2 {
                font-size: 20px;
            }

            th,
            td {
                padding: 8px 10px;
            }
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
                            {{ $product->name }} ({{ $product->pivot->quantity }}x)<br>
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
