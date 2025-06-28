<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;

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

        $purchase = new Purchase();
        $purchase->supplier_id = $request->supplier_id;
        $purchase->tanggal = $request->tanggal;
        $purchase->kode_pembelian = 'PB-' . time();
        $purchase->total_harga = $request->total_amount;
        $purchase->user_id = auth()->id();
        $purchase->status = 'pending'; // ✅ Tambahkan default status
        $purchase->save();

        foreach ($request->items as $item) {
            $purchase->purchaseDetails()->create([
                'product_id' => $item['product_id'],
                'jumlah' => $item['quantity'], // ✅ Sesuai kolom di DB
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
        
        // Pastikan relasi sudah dimuat
        $purchase->load('purchaseDetails.product');

        return view('purchases.edit', compact('purchase', 'suppliers', 'products'));
    }

    public function update(Request $request, Purchase $purchase)
    {
        if ($request->has('status')) {
            $purchase->status = $request->status;
            $purchase->save();
        }

        return redirect()->route('purchases.index')->with('success', 'Status pembelian diperbarui.');
    }

    public function destroy(Purchase $purchase)
    {
        $purchase->delete();
        return redirect()->route('purchases.index')->with('success', 'Pembelian berhasil dihapus.');
    }
}
