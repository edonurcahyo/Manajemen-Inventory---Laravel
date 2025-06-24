@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Laporan & Analisis</h1>
    </div>

    <div class="row">
        <!-- Sales Report Card -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Laporan Penjualan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Statistik Penjualan</div>
                            <div class="text-xs text-gray-600 mt-2">Lihat tren penjualan, produk teratas, dan analisis pendapatan</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-chart-line fa-2x text-gray-300"></i>
                        </div>
                    </div>
                    <a href="#" class="stretched-link" data-toggle="modal" data-target="#salesReportModal"></a>
                </div>
            </div>
        </div>

        <!-- Purchase Report Card -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Laporan Pembelian</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Hasilkan analisis pembelian</div>
                            <div class="text-xs text-gray-600 mt-2">Lacak tren pembelian dan kinerja pemasok</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-shopping-cart fa-2x text-gray-300"></i>
                        </div>
                    </div>
                    <a href="#" class="stretched-link" data-toggle="modal" data-target="#purchaseReportModal"></a>
                </div>
            </div>
        </div>

        <!-- Inventory Report Card -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Laporan Inventaris</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Analisis Stok</div>
                            <div class="text-xs text-gray-600 mt-2">Pantau tingkat stok dan kinerja produk</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-boxes fa-2x text-gray-300"></i>
                        </div>
                    </div>
                    <a href="#" class="stretched-link" data-toggle="modal" data-target="#inventoryReportModal"></a>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Stats Row -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Statistik Cepat</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 text-center">
                            <div class="h4 mb-0 text-primary">{{ $totalSales ?? 0 }}</div>
                            <div class="text-xs text-gray-600">Total Penjualan Bulan Ini</div>
                        </div>
                        <div class="col-md-3 text-center">
                            <div class="h4 mb-0 text-success">{{ $totalPurchases ?? 0 }}</div>
                            <div class="text-xs text-gray-600">Total Pembelian Bulan Ini</div>
                        </div>
                        <div class="col-md-3 text-center">
                            <div class="h4 mb-0 text-info">{{ $lowStockItems ?? 0 }}</div>
                            <div class="text-xs text-gray-600">Produk Stok Rendah</div>
                        </div>
                        <div class="col-md-3 text-center">
                            <div class="h4 mb-0 text-warning">{{ $totalRevenue ?? 0 }}</div>
                            <div class="text-xs text-gray-600">Pendapatan Bulan Ini</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Sales Report Modal -->
<div class="modal fade" id="salesReportModal" tabindex="-1" role="dialog" aria-labelledby="salesReportModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="salesReportModalLabel">Generate Laporan Penjualan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('reports.sales') }}" method="GET" target="_blank">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="sales_start_date">Tanggal Mulai:</label>
                        <input type="date" class="form-control" id="sales_start_date" name="start_date" required>
                    </div>
                    <div class="form-group">
                        <label for="sales_end_date">Tanggal Selesai:</label>
                        <input type="date" class="form-control" id="sales_end_date" name="end_date" required>
                    </div>
                    <div class="form-group">
                        <label for="sales_report_type">Tipe Laporan:</label>
                        <select class="form-control" id="sales_report_type" name="type">
                            <option value="summary">Ringkasan</option>
                            <option value="detailed">Detail</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Generate Report</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Purchase Report Modal -->
<div class="modal fade" id="purchaseReportModal" tabindex="-1" role="dialog" aria-labelledby="purchaseReportModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="purchaseReportModalLabel">Generate Laporan Pembelian</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('reports.purchases') }}" method="GET" target="_blank">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="purchase_start_date">Tanggal Mulai:</label>
                        <input type="date" class="form-control" id="purchase_start_date" name="start_date" required>
                    </div>
                    <div class="form-group">
                        <label for="purchase_end_date">Tanggal Selesai:</label>
                        <input type="date" class="form-control" id="purchase_end_date" name="end_date" required>
                    </div>
                    <div class="form-group">
                        <label for="purchase_report_type">Tipe Laporan:</label>
                        <select class="form-control" id="purchase_report_type" name="type">
                            <option value="summary">Ringkasan</option>
                            <option value="detailed">Detail</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Generate Report</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Inventory Report Modal -->
<div class="modal fade" id="inventoryReportModal" tabindex="-1" role="dialog" aria-labelledby="inventoryReportModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="inventoryReportModalLabel">Generate Inventory Report</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('reports.inventory') }}" method="GET" target="_blank">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="inventory_category">Category (Optional):</label>
                        <select class="form-control" id="inventory_category" name="category_id">
                            <option value="">All Categories</option>
                            <!-- Categories will be populated from controller -->
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="inventory_report_type">Report Type:</label>
                        <select class="form-control" id="inventory_report_type" name="type">
                            <option value="current_stock">Current Stock Levels</option>
                            <option value="low_stock">Low Stock Items</option>
                            <option value="out_of_stock">Out of Stock Items</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-info">Generate Report</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection