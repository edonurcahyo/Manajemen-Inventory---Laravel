<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AuthController,
    DashboardController,
    CategoryController,
    ProductController,
    PurchaseController,
    SaleController,
    ReportController,
    UserController
};

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| Ini adalah file route utama untuk aplikasi web Anda.
| Semua route yang memerlukan autentikasi dikelompokkan dengan middleware 'auth'.
|--------------------------------------------------------------------------
*/

// ============================
// Route Auth (Guest Access)
// ============================

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Redirect root ke login (jika belum login)
Route::get('/', function () {
    return redirect()->route('login');
});

// ============================
// Protected Routes (Require Auth)
// ============================
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Category Management
    Route::resource('categories', CategoryController::class);

    // Product Management
    Route::resource('products', ProductController::class);

    // Purchase Transactions
    Route::resource('purchases', PurchaseController::class);

    // Sales Transactions
    Route::resource('sales', SaleController::class);

    // Reports
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('index');
        Route::get('/sales', [ReportController::class, 'sales'])->name('sales');
        Route::get('/purchases', [ReportController::class, 'purchases'])->name('purchases');
        Route::get('/inventory', [ReportController::class, 'inventory'])->name('inventory');
    });

    // User Management (tanpa show)
    Route::resource('users', UserController::class)->except(['show']);

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
