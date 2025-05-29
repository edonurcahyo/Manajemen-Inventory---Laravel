<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|unique:products,kode_produk',
            'name' => 'required',
            'category_id' => 'required|exists:categories,id',
            'unit' => 'required',
            'purchase_price' => 'required|numeric',
            'selling_price' => 'required|numeric',
            'stock_quantity' => 'required|numeric',
        ]);

        $product = new Product();
        $product->kode_produk = $validated['code'];
        $product->nama_produk = $validated['name'];
        $product->categories_id = $validated['category_id'];
        $product->satuan = $validated['unit'];
        $product->harga_beli = $validated['purchase_price'];
        $product->harga_jual = $validated['selling_price'];
        $product->stok = $validated['stock_quantity'];
        $product->save();

        return redirect()->route('products.index')
            ->with('success', 'Product created successfully.');
    }

    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        // Validate and update product
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index');
    }
}