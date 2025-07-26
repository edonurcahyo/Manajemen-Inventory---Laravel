<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $products = Product::with('category')
            ->when($search, function ($query, $search) {
                return $query->where('nama_produk', 'like', "%$search%");
            })
            ->orderBy('created_at', 'desc')
            ->get();

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
            'nama_produk' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'satuan' => 'required|string|max:50',
            'harga_beli' => 'required|numeric|min:0',
            'harga_jual' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            // 'deskripsi' => 'nullable|string|max:1000',
        ]);

        $product = new Product();
        $product->kode_produk = $this->generateProductCode();
        $product->nama_produk = $validated['nama_produk'];
        $product->category_id = $validated['category_id'];
        $product->satuan = $validated['satuan'];
        $product->harga_beli = $validated['harga_beli'];
        $product->harga_jual = $validated['harga_jual'];
        $product->stok = $validated['stok'];
        // $product->deskripsi = $validated['deskripsi'] ?? null;

        $product->save();

        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    private function generateProductCode()
    {
        $lastProduct = Product::orderBy('id', 'desc')->first();
        $nextNumber = $lastProduct ? ($lastProduct->id + 1) : 1;
        return 'PRD-' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
    }
}
