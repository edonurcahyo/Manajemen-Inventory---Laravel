<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Sale;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProduk = Product::count(); 
        $totalCategories = Category::count();

        // Produk dengan stok di bawah ambang batas, misalnya < 5
        $lowStockItems = Product::where('stok', '<', 5)->count();
        $lowStockProducts = Product::where('stok', '<', 5)->get();

        // Total penjualan hari ini
        $todaySales = Sale::whereDate('tanggal', now())->sum('total_harga');

        $monthlyRevenue = Sale::whereMonth('tanggal', now()->month)
                            ->whereYear('tanggal', now()->year)
                            ->sum('total_harga');

        // Penjualan terbaru
        $recentSales = Sale::with('customer')->latest()->take(5)->get();

        // Data dummy tren penjualan 7 hari terakhir (harusnya pakai grup by tanggal penjualan)
        $chartLabels = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
        $chartData = [12000, 8000, 15000, 7000, 9000, 11000, 13000];

        return view('dashboard.index', compact(
            'totalProduk',
            'totalCategories',
            'lowStockItems',
            'lowStockProducts',
            'todaySales',
            'monthlyRevenue',
            'recentSales',
            'chartLabels',
            'chartData'
        ));
    }
}
