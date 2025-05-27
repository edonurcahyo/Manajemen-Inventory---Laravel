<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class DashboardController extends Controller
{
    public function index()
    {
        $totalCategories = Category::count();
        // Logic for stock overview and alerts
        return view('dashboard.index', compact('totalCategories'));
    }
}