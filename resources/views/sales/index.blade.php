@extends('layouts.app')

@section('title', 'Sales - CV. Agung')
@section('page-title', 'Manajemen Penjualan')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">List Penjualan</h5>
                <a href="{{ route('sales.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i> Penjualan Baru
                </a>
            </div>
            <div class="card-body">
                <!-- Search and Filter -->
                <div class="row mb-3">
                    <div class="col-md-4">
                        <input type="text" class="form-control" id="searchSales" placeholder="Cari penjualan...">
                    </div>
                    <div class="col-md-3">
                        <select class="form-select" id="filterStatus">
                            <option value="">Semua Status</option>
                            <option value="pending">Menunggu</option>
                            <option value="completed">Selesai</option>
                            <option value="cancelled">Dibatalkan</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <input type="date" class="form-control" id="filterDate">
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-outline-secondary" id="clearFilter">
                            <i class="fas fa-times"></i> Hapus
                        </button>
                    </div>
                </div>

                <!-- Sales Table -->
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>ID Penjualan</th>
                                <th>Tanggal</th>
                                <th>Pelanggan</th>
                                <th>Item</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($sales ?? [] as $sale)
                            <tr>
                                <td>
                                    <strong>#{{ str_pad($sale->id, 6, '0', STR_PAD_LEFT) }}</strong>
                                </td>
                                <td>{{ $sale->sale_date ? $sale->sale_date->format('d M Y') : '-' }}</td>
                                <td>
                                    @if($sale->customer)
                                        <div>
                                            <strong>{{ $sale->customer->name }}</strong><br>
                                            <small class="text-muted">{{ $sale->customer->phone }}</small>
                                        </div>
                                    @else
                                        <span class="text-muted">Walk-in Customer</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-info">{{ $sale->saleDetails->count() }} items</span>
                                </td>
                                <td>
                                    <strong>Rp {{ number_format($sale->total_amount, 0, ',', '.') }}</strong>
                                </td>
                                <td>
                                    @switch($sale->status)
                                        @case('pending')
                                            <span class="badge bg-warning">Menunggu</span>
                                            @break
                                        @case('completed')
                                            <span class="badge bg-success">Selesai</span>
                                            @break
                                        @case('cancelled')
                                            <span class="badge bg-danger">Dibatalkan</span>
                                            @break
                                        @default
                                            <span class="badge bg-secondary">{{ ucfirst($sale->status) }}</span>
                                    @endswitch
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('sales.show', $sale->id) }}" class="btn btn-sm btn-outline-info" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('sales.edit', $sale->id) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-outline-danger" title="Hapus" onclick="deleteSale({{ $sale->id }})">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        @if($sale->status === 'pending')
                                        <button type="button" class="btn btn-sm btn-outline-success" title="Complete Sale" onclick="completeSale({{ $sale->id }})">
                                            <i class="fas fa-check"></i>
                                        </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="fas fa-shopping-cart fa-3x mb-3"></i>
                                        <p>Tidak ada penjualan</p>
                                        <a href="{{ route('sales.create') }}" class="btn btn-primary">
                                            <i class="fas fa-plus me-1"></i> Buat Penjualan Pertama
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if(isset($sales) && $sales->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $sales->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin menghapus penjualan ini? Tindakan ini tidak dapat dibatalkan.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function deleteSale(saleId) {
    const deleteForm = document.getElementById('deleteForm');
    deleteForm.action = `/sales/${saleId}`;
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    deleteModal.show();
}

function completeSale(saleId) {
    if (confirm('Tandai penjualan ini sebagai selesai?')) {
        // Create a form to submit the status update
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/sales/${saleId}`;
        
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        
        const methodField = document.createElement('input');
        methodField.type = 'hidden';
        methodField.name = '_method';
        methodField.value = 'PATCH';
        
        const statusField = document.createElement('input');
        statusField.type = 'hidden';
        statusField.name = 'status';
        statusField.value = 'completed';
        
        form.appendChild(csrfToken);
        form.appendChild(methodField);
        form.appendChild(statusField);
        
        document.body.appendChild(form);
        form.submit();
    }
}

// Search and filter functionality
document.getElementById('searchSales').addEventListener('input', function() {
    // Implement search functionality
});

document.getElementById('filterStatus').addEventListener('change', function() {
    // Implement status filter
});

document.getElementById('filterDate').addEventListener('change', function() {
    // Implement date filter
});

document.getElementById('clearFilter').addEventListener('click', function() {
    document.getElementById('searchSales').value = '';
    document.getElementById('filterStatus').value = '';
    document.getElementById('filterDate').value = '';
    // Reload or reset the table
});
</script>
@endsection