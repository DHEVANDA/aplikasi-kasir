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
        $transactions = Transaction::with('products')->get();  // Ambil transaksi dengan produk terkait
        return view('transactions.index', compact('transactions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::all();
        return view('transactions.create', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'transactions' => 'required|array',
            'transactions.*.product_id' => 'required|exists:products,id',
            'transactions.*.quantity' => 'required|integer|min:1',
            'payment_method' => 'required|string',
        ]);

        // Hitung total harga dari semua transaksi
        $totalPrice = 0;
        foreach ($request->transactions as $transaction) {
            $product = Product::find($transaction['product_id']);
            $totalPrice += $product->price * $transaction['quantity'];
        }

        // Buat transaksi utama
        $newTransaction = Transaction::create([
            'total_price' => $totalPrice,
            'payment_method' => $request->payment_method,
        ]);

        // Simpan setiap produk dalam transaksi
        foreach ($request->transactions as $transaction) {
            $product = Product::find($transaction['product_id']);
            $newTransaction->products()->attach($product->id, [
                'quantity' => $transaction['quantity'],
                'price' => $product->price,
            ]);
        }

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil disimpan!');
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
