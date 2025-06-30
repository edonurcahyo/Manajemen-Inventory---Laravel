<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Purchase;
use App\Models\Product;
use App\Models\PurchaseDetail;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index()
    {
        $totalSales = Sale::whereMonth('created_at', now()->month)
                        ->whereYear('created_at', now()->year)
                        ->sum('total_harga');

        $totalPurchases = PurchaseDetail::whereMonth('created_at', now()->month)
                                        ->whereYear('created_at', now()->year)
                                        ->sum('subtotal');

        $lowStockItems = Product::where('stok', '<', 5)->count();

        $totalRevenue = $totalSales - $totalPurchases;

        return view('reports.index', compact('totalSales', 'totalPurchases', 'lowStockItems', 'totalRevenue'));
    }

}
