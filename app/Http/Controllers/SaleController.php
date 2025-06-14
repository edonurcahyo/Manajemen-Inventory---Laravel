<?php

namespace App\Http\Controllers;

use App\Models\Customer; // Add this line
use App\Models\Sale;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function index()
    {
        $sales = Sale::paginate(10); // or any number per page
        return view('sales.index', compact('sales'));
    }

    public function create()
    {
        $customers = Customer::all(); // Or any other query to get customers
        return view('sales.create', compact('customers'));
    }

    public function store(Request $request)
    {
        // Validate and store sale
    }

    public function show(Sale $sale)
    {
        return view('sales.show', compact('sale'));
    }

    public function edit(Sale $sale)
    {
        return view('sales.edit', compact('sale'));
    }

    public function update(Request $request, Sale $sale)
    {
        // Validate and update sale
    }

    public function destroy(Sale $sale)
    {
        $sale->delete();
        return redirect()->route('sales.index');
    }
}