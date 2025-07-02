<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SaleController extends Controller
{
    public function index()
    {
        $sales = Sale::with('saleDetails', 'customer')->paginate(10);
        return view('sales.index', compact('sales'));
    }

    public function create()
    {
        $products = Product::all(); // Pastikan model Product memiliki kolom 'stok'
        $customers = Customer::all();
        $products = Product::all(); 

        $lastSale = Sale::latest()->first();
        $nextId = $lastSale ? $lastSale->id + 1 : 1;
        $kode_penjualan = 'PNJ-' . now()->format('Ymd') . '-' . str_pad($nextId, 4, '0', STR_PAD_LEFT);

        return view('sales.create', compact('customers', 'products', 'kode_penjualan'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_penjualan' => 'required|unique:sales,kode_penjualan',
            'customer_id' => 'nullable|exists:customers,id',
            'sale_date' => 'required|date',
            'status' => 'required|in:pending,completed,cancelled',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|numeric|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
            'tax_percentage' => 'nullable|numeric|min:0|max:100',
            'discount' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        // Hitung subtotal dari items
        $subtotal = collect($validated['items'])->sum(function($item) {
            return $item['quantity'] * $item['unit_price'];
        });

        // Buat record penjualan
        $sale = Sale::create([
            'kode_penjualan' => $validated['kode_penjualan'],
            'customer_id' => $validated['customer_id'],
            'tanggal' => $validated['sale_date'],
            'subtotal_amount' => $subtotal,
            'tax_percentage' => $validated['tax_percentage'] ?? 0,
            'tax_amount' => ($validated['tax_percentage'] ?? 0) * $subtotal / 100,
            'discount_amount' => $validated['discount'] ?? 0,
            'total_harga' => $subtotal + (($validated['tax_percentage'] ?? 0) * $subtotal / 100) - ($validated['discount'] ?? 0),
            'user_id' => Auth::id(),
            'status' => $validated['status'],
            'notes' => $validated['notes'] ?? null,
        ]);

        // Simpan detail penjualan dan update stok
        foreach ($validated['items'] as $item) {
            $sale->saleDetails()->create([
                'product_id' => $item['product_id'],
                'jumlah' => $item['quantity'],
                'harga_jual' => $item['unit_price'],
                'subtotal' => $item['quantity'] * $item['unit_price'],
            ]);

            // Update stok produk
            $product = Product::find($item['product_id']);
            $product->stok -= $item['quantity'];
            $product->save();
        }

        return redirect()->route('sales.index')->with('success', 'Penjualan berhasil dibuat!');
    }

    public function show($id)
    {
        $sale = Sale::with(['customer', 'saleDetails.product'])->findOrFail($id);
        return view('sales.show', compact('sale'));
    }

    public function edit($id)
    {
        $sale = Sale::with(['customer', 'saleDetails'])->findOrFail($id);
        $customers = Customer::all();
        return view('sales.edit', compact('sale', 'customers'));
    }

    public function update(Request $request, $id)
    {
        $sale = Sale::findOrFail($id);

        $request->validate([
            'customer_id' => 'nullable|exists:customers,id',
            'tanggal' => 'required|date',
            'status' => 'required|string|in:pending,completed,cancelled',
        ]);

        $sale->update([
            'customer_id' => $request->customer_id,
            'tanggal' => $request->tanggal,
            'status' => $request->status,
        ]);

        return redirect()->route('sales.index')->with('success', 'Penjualan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $sale = Sale::findOrFail($id);
        $sale->delete();
        return redirect()->route('sales.index')->with('success', 'Penjualan berhasil dihapus!');
    }
}
