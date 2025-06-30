<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller
{
    public function index()
    {
        $purchases = Purchase::with('supplier', 'purchaseDetails')->latest()->paginate(10);
        $suppliers = Supplier::all();

        return view('purchases.index', compact('purchases', 'suppliers'));
    }

    public function create()
    {
        $products = Product::all()->map(function ($product) {
            return (object)[
                'id' => $product->id,
                'nama_produk' => $product->nama_produk,
                'harga_beli' => $product->harga_beli
            ];
        });

        $suppliers = Supplier::all();

        return view('purchases.create', compact('products', 'suppliers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'tanggal' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|numeric|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);

        // Hitung total_harga dari item
        $total = 0;
        foreach ($request->items as $item) {
            $total += $item['quantity'] * $item['unit_price'];
        }

        $purchase = new Purchase();
        $purchase->supplier_id = $request->supplier_id;
        $purchase->tanggal = $request->tanggal;
        $purchase->kode_pembelian = 'PB-' . time(); // Kode unik
        $purchase->total_harga = $total;
        $purchase->user_id = Auth::id();
        $purchase->status = 'pending'; // Status default
        $purchase->save();

        // Simpan detail pembelian
        foreach ($request->items as $item) {
            $purchase->purchaseDetails()->create([
                'product_id' => $item['product_id'],
                'jumlah' => $item['quantity'],
                'harga_beli' => $item['unit_price'],
                'subtotal' => $item['quantity'] * $item['unit_price'],
            ]);
        }

        return redirect()->route('purchases.index')->with('success', 'Pembelian berhasil disimpan.');
    }

    public function show(Purchase $purchase)
    {
        return view('purchases.show', compact('purchase'));
    }

    public function edit(Purchase $purchase)
    {
        $suppliers = Supplier::all();
        $products = Product::all();

        $purchase->load('purchaseDetails.product');

        return view('purchases.edit', compact('purchase', 'suppliers', 'products'));
    }

    public function update(Request $request, Purchase $purchase)
    {
        // Update status jika dikirim
        if ($request->has('status')) {
            $purchase->status = $request->status;
            $purchase->save();

            return redirect()->route('purchases.index')->with('success', 'Status pembelian diperbarui.');
        }

        // Tambahkan logika update isi pembelian di sini jika dibutuhkan

        return redirect()->route('purchases.index')->with('info', 'Tidak ada perubahan yang dilakukan.');
    }

    public function destroy(Purchase $purchase)
    {
        $purchase->delete();

        return redirect()->route('purchases.index')->with('success', 'Pembelian berhasil dihapus.');
    }
}
