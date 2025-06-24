<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SaleController extends Controller
{
    public function index()
    {
        $sales = Sale::paginate(10); // or any number per page
        return view('sales.index', compact('sales'));
    }
    
    public function create()
    {
        $customers = Customer::all();
        $products = Product::all();

        // Generate kode penjualan unik
        $lastSale = Sale::latest()->first();
        $nextId = $lastSale ? $lastSale->id + 1 : 1;
        $kode_penjualan = 'PNJ-' . now()->format('Ymd') . '-' . str_pad($nextId, 4, '0', STR_PAD_LEFT);

        return view('sales.create', compact('customers', 'products', 'kode_penjualan'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'kode_penjualan' => 'required|unique:sales,kode_penjualan',
            'sale_date' => 'required|date',
            'status' => 'required|string',
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|numeric|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);

        // Hitung total
        $subtotal = 0;
        foreach ($request->items as $item) {
            $subtotal += $item['quantity'] * $item['unit_price'];
        }

        $tax = ($request->tax_percentage ?? 0) * $subtotal / 100;
        $discount = $request->discount ?? 0;
        $total = $subtotal + $tax - $discount;

        // Simpan ke tabel sales
        $sale = Sale::create([
            'kode_penjualan' => $request->kode_penjualan,
            'customer_id' => $request->customer_id,
            'tanggal' => $request->sale_date,
            'total_harga' => $total,
            'user_id' => Auth::id(),
        ]);

        // (Opsional) Simpan detail item jika punya tabel sale_details
        // foreach ($request->items as $item) {
        //     SaleDetail::create([
        //         'sale_id' => $sale->id,
        //         'product_id' => $item['product_id'],
        //         'quantity' => $item['quantity'],
        //         'unit_price' => $item['unit_price'],
        //     ]);
        // }

        return redirect()->route('sales.index')->with('success', 'Penjualan berhasil disimpan!');
    }
}
