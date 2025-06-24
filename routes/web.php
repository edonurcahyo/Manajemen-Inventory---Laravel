<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Category Management
Route::resource('categories', CategoryController::class);

// Product Management
Route::resource('products', ProductController::class);

// Purchase Transactions
Route::resource('purchases', PurchaseController::class);

// Sales Transactions
Route::resource('sales', SaleController::class);

// Reports
Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
Route::get('reports/sales', [ReportController::class, 'sales'])->name('reports.sales');
Route::get('reports/purchases', [ReportController::class, 'purchases'])->name('reports.purchases');
Route::get('reports/inventory', [ReportController::class, 'inventory'])->name('reports.inventory');

// User Management
Route::resource('users', UserController::class);
Route::resource('users', UserController::class)->except(['show']);