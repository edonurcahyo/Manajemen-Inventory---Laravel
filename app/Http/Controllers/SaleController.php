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
        $customers = Customer::all();
        $products = Product::all(); // Tanpa map juga sudah cukup

        $lastSale = Sale::latest()->first();
        $nextId = $lastSale ? $lastSale->id + 1 : 1;
        $kode_penjualan = 'PNJ-' . now()->format('Ymd') . '-' . str_pad($nextId, 4, '0', STR_PAD_LEFT);

        return view('sales.create', compact('customers', 'products', 'kode_penjualan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_penjualan' => 'required|unique:sales,kode_penjualan',
            'sale_date' => 'required|date',
            'status' => 'required|string',
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|numeric|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);

        $subtotal = 0;
        foreach ($request->items as $item) {
            $subtotal += $item['quantity'] * $item['unit_price'];
        }

        $tax = ($request->tax_percentage ?? 0) * $subtotal / 100;
        $discount = $request->discount ?? 0;
        $total = $subtotal + $tax - $discount;

        $sale = Sale::create([
            'kode_penjualan' => $request->kode_penjualan,
            'customer_id' => $request->customer_id,
            'tanggal' => $request->sale_date,
            'total_harga' => $total,
            'user_id' => Auth::id(),
            'status' => $request->status,
        ]);

        foreach ($request->items as $item) {
            SaleDetail::create([
                'sale_id' => $sale->id,
                'product_id' => $item['product_id'],
                'jumlah' => $item['quantity'],
                'harga_jual' => $item['unit_price'],
                'subtotal' => $item['quantity'] * $item['unit_price'],
            ]);

            $product = Product::find($item['product_id']);
            $product->stok -= $item['quantity'];
            $product->save();
        }

        return redirect()->route('sales.index')->with('success', 'Penjualan berhasil disimpan!');
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
