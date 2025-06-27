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
        $purchases = Purchase::all();
        $suppliers = Supplier::all();
        $products = Product::all();
        return view('purchases.index', compact('purchases', 'suppliers', 'products'));
    }

    public function create()
    {
        $products = Product::all()->map(function($product) {
            return (object) [
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
        // Validate and store purchase
    }

    public function show(Purchase $purchase)
    {
        return view('purchases.show', compact('purchase'));
    }

    public function edit(Purchase $purchase)
    {
        return view('purchases.edit', compact('purchase'));
    }

    public function update(Request $request, Purchase $purchase)
    {
        // Validate and update purchase
    }

    public function destroy(Purchase $purchase)
    {
        $purchase->delete();
        return redirect()->route('purchases.index');
    }
}