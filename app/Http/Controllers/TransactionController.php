<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil semua transaksi dari database beserta relasi produk
        $transactions = Transaction::with('product')->get();

        // Tampilkan halaman daftar transaksi dengan data transaksi
        return view('transactions.index', compact('transactions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Ambil semua produk untuk ditampilkan di form transaksi
        $products = Product::all();

        return view('transactions.create', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'total_price' => 'required|numeric',
            'payment_method' => 'required|in:credit_card,paypal,bank_transfer',
        ]);

        $transaction = new Transaction();
        $transaction->product_id = $request->product_id;
        $transaction->quantity = $request->quantity;
        $transaction->total_price = $request->total_price;
        $transaction->payment_method = $request->payment_method;
        $transaction->save();

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil ditambahkan!');
    }


    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        // Menampilkan detail transaksi dengan produk terkait
        return view('transactions.show', compact('transaction'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        // Ambil semua produk untuk form edit
        $products = Product::all();

        return view('transactions.edit', compact('transaction', 'products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        // Validasi data yang diterima dari request
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'total_price' => 'required|numeric|min:0',
        ]);

        // Ambil produk berdasarkan ID yang diterima
        $product = Product::findOrFail($validated['product_id']);
        $pricePerUnit = $product->price;

        // Hitung harga total
        $calculatedTotalPrice = $pricePerUnit * $validated['quantity'];

        // Periksa apakah harga total yang diterima sesuai dengan yang dihitung
        if ($calculatedTotalPrice !== $validated['total_price']) {
            return back()->withInput()->withErrors(['total_price' => 'Harga total tidak sesuai dengan perhitungan.']);
        }

        // Update transaksi dengan data baru
        $transaction->update([
            'product_id' => $validated['product_id'],
            'quantity' => $validated['quantity'],
            'total_price' => $validated['total_price'],
        ]);

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        // Hapus transaksi
        $transaction->delete();

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil dihapus!');
    }

    public function printSelectedPdf(Request $request)
    {
        $transactionIds = $request->input('transaction_ids', []);
        $transactions = Transaction::whereIn('id', $transactionIds)->get();

        $pdf = PDF::loadView('transactions.pdf', compact('transactions'));
        return $pdf->download('transaksi_terpilih.pdf');
    }
}
