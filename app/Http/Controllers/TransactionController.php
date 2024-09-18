<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil transaksi dengan relasi ke produk dan tambahkan pagination (10 transaksi per halaman)
        $transactions = Transaction::with('products')->paginate(10);

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
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'payment_method' => 'required',
            'transactions' => 'required|array',
            'transactions.*.product_id' => 'required|exists:products,id',
            'transactions.*.quantity' => 'required|integer|min:1',
        ]);

        // Hitung total harga
        $totalPrice = 0;
        foreach ($request->transactions as $trans) {
            $product = Product::findOrFail($trans['product_id']);
            $totalPrice += $product->price * $trans['quantity'];
        }

        // Simpan transaksi
        $transaction = Transaction::create([
            'name' => $request->name,
            'total_price' => $totalPrice,
            'payment_method' => $request->payment_method,
        ]);

        // Simpan detail produk di pivot table termasuk harga
        foreach ($request->transactions as $trans) {
            $product = Product::findOrFail($trans['product_id']);
            $transaction->products()->attach($trans['product_id'], [
                'quantity' => $trans['quantity'],
                'price' => $product->price,  // Masukkan harga produk di pivot table
            ]);
        }

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil disimpan.');
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

    // Fungsi untuk menampilkan PDF dari transaksi yang dipilih
    public function exportPdf($id)
    {
        // Ambil transaksi berdasarkan ID
        $transaction = Transaction::with('products')->findOrFail($id);

        // Generate PDF menggunakan view
        $pdf = PDF::loadView('transactions.pdf', compact('transaction'));

        // Download atau tampilkan PDF
        return $pdf->download('transaction_' . $id . '.pdf');
    }

    // Menampilkan form untuk laporan
    public function reportForm()
    {
        return view('transactions.report');
    }

    // Menampilkan hasil laporan berdasarkan bulan
    public function generateReport(Request $request)
    {
        $request->validate([
            'month' => 'required|date_format:Y-m',
        ]);

        // Mengambil transaksi berdasarkan bulan yang dipilih
        $month = $request->input('month');
        $transactions = Transaction::whereYear('created_at', Carbon::parse($month)->year)
            ->whereMonth('created_at', Carbon::parse($month)->month)
            ->with('products')
            ->get();

        return view('transactions.report_result', compact('transactions', 'month'));
    }

    // Ekspor laporan ke PDF berdasarkan bulan yang dipilih
    public function exportReportPdf(Request $request)
    {
        $request->validate([
            'month' => 'required|date_format:Y-m',
        ]);

        // Mengambil transaksi berdasarkan bulan yang dipilih
        $month = $request->input('month');
        $transactions = Transaction::whereYear('created_at', Carbon::parse($month)->year)
            ->whereMonth('created_at', Carbon::parse($month)->month)
            ->with('products')
            ->get();

        // Generate PDF menggunakan view
        $pdf = PDF::loadView('transactions.report_pdf', compact('transactions', 'month'));

        return $pdf->download('report_' . $month . '.pdf');
    }
}
