@extends('layouts.app')

@section('title', 'Dashboard - CV. Agung')
@section('page-title', 'Dashboard')

@section('content')
<div class="row mb-4">
    <!-- Stats Cards -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stats-card shadow-sm">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">Total Produk</div>
                        <div class="h5 mb-0 font-weight-bold text-primary">{{ $totalProduk ?? 0 }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-box fa-2x text-primary"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stats-card shadow-sm">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">Stok Rendah</div>
                        <div class="h5 mb-0 font-weight-bold text-warning">{{ $lowStockItems ?? 0 }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-exclamation-triangle fa-2x text-warning"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stats-card shadow-sm">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">Penjualan Hari Ini</div>
                        <div class="h5 mb-0 font-weight-bold text-success">Rp {{ number_format($todaySales ?? 0, 0, ',', '.') }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-dollar-sign fa-2x text-success"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stats-card shadow-sm">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">Pendapatan Bulanan</div>
                        <div class="h5 mb-0 font-weight-bold text-info">Rp {{ number_format($monthlyRevenue ?? 0, 0, ',', '.') }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-chart-line fa-2x text-info"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Recent Sales -->
    <div class="col-lg-8 mb-4">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Penjualan Terbaru</h5>
                <a href="{{ route('sales.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Pelanggan</th>
                                <th>Total</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentSales ?? [] as $sale)
                            <tr>
                                <td>{{ $sale->created_at->format('d/m/Y') }}</td>
                                <td>{{ $sale->customer->name ?? 'Pelanggan Langsung' }}</td>
                                <td>Rp {{ number_format($sale->total_harga, 0, ',', '.') }}</td>
                                <td>
                                    <span class="badge bg-{{ $sale->status === 'completed' ? 'success' : ($sale->status === 'pending' ? 'warning' : 'secondary') }}">
                                        {{ ucfirst($sale->status) }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center">Tidak ada penjualan terbaru</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Low Stock Alert -->
    <div class="col-lg-4 mb-4">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Peringatan Stok Rendah</h5>
                <a href="{{ route('products.index') }}" class="btn btn-sm btn-outline-secondary">Lihat Produk</a>
            </div>
            <div class="card-body">
                @forelse($lowStockProducts ?? [] as $product)
                <div class="d-flex align-items-center mb-3">
                    <div class="flex-grow-1">
                        <h6 class="mb-1">{{ $product->nama_produk }}</h6>
                        <small class="text-muted">Stok: {{ $product->stok }}</small>
                    </div>
                    <span class="badge bg-warning">Low</span>
                </div>
                @empty
                <p class="text-muted">Tidak ada produk dengan stok rendah</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Sales Chart -->
<!-- <div class="row mt-4">
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Tren Penjualan (7 Hari Terakhir)</h5>
                <a href="{{ route('reports.index') }}" class="btn btn-sm btn-outline-info">Lihat Laporan</a>
            </div>
            <div class="card-body" style="height: 300px;">
                <canvas id="salesChart"></canvas>
            </div>
        </div>
    </div>
</div> -->
@endsection

@section('scripts')
<!-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('salesChart').getContext('2d');

    const gradient = ctx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'rgba(33, 150, 243, 0.4)');
    gradient.addColorStop(1, 'rgba(33, 150, 243, 0.05)');

    const salesChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($chartLabels ?? ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu']) !!},
            datasets: [{
                label: 'Penjualan (Rp)',
                data: {!! json_encode($chartData ?? [0, 0, 0, 0, 0, 0, 0]) !!},
                fill: true,
                backgroundColor: gradient,
                borderColor: '#2196f3',
                borderWidth: 2,
                tension: 0.3,
                pointRadius: 4,
                pointHoverRadius: 6,
                pointBackgroundColor: '#2196f3'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            animation: {
                duration: 1000,
                easing: 'easeOutQuart'
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function (context) {
                            return 'Rp ' + context.parsed.y.toLocaleString('id-ID');
                        }
                    },
                    backgroundColor: '#fff',
                    titleColor: '#333',
                    bodyColor: '#333',
                    borderColor: '#ddd',
                    borderWidth: 1,
                    padding: 10
                },
                legend: {
                    display: false
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        font: {
                            size: 12
                        }
                    }
                },
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0,0,0,0.05)'
                    },
                    ticks: {
                        font: {
                            size: 12
                        },
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString('id-ID');
                        }
                    }
                }
            }
        }
    });
});
</script> -->
@endsection