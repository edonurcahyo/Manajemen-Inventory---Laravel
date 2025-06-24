@extends('layouts.app')

@section('title', 'Purchases - CV. Agung')
@section('page-title', 'Manajemen Pembelian')

@section('content')
<div class="row mb-3">
    <div class="col-md-6">
        <div class="input-group">
            <input type="text" class="form-control" id="searchInput" placeholder="Search purchases...">
            <button class="btn btn-outline-secondary" type="button" id="searchBtn">
                <i class="fas fa-search"></i>
            </button>
        </div>
    </div>
    <div class="col-md-6 text-end">
        <a href="{{ route('purchases.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> Buat Pembelian Baru
        </a>
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <label for="supplierFilter" class="form-label">Filter by Pemasok</label>
                        <select class="form-select" id="supplierFilter">
                            <option value="">Semua Pemasok</option>
                            @foreach($suppliers as $supplier)
                                <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="statusFilter" class="form-label">Filter by Status</label>
                        <select class="form-select" id="statusFilter">
                            <option value="">Semua Status</option>
                            <option value="pending">Menunggu</option>
                            <option value="completed">Selesai</option>
                            <option value="cancelled">Dibatalkan</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="dateFrom" class="form-label">Tanggal Dari</label>
                        <input type="date" class="form-control" id="dateFrom">
                    </div>
                    <div class="col-md-3">
                        <label for="dateTo" class="form-label">Tanggal Sampai</label>
                        <input type="date" class="form-control" id="dateTo">
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-12 text-end">
                        <button type="button" class="btn btn-secondary" id="resetFilter">
                            <i class="fas fa-undo me-1"></i> Reset
                        </button>
                        <button type="button" class="btn btn-primary" id="applyFilter">
                            <i class="fas fa-filter me-1"></i> Terapkan Filter
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class.card-body>
        @if($purchases->count() > 0)
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Pembelian #</th>
                            <th>Tanggal</th>
                            <th>Pemasok</th>
                            <th>Item</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="purchaseTableBody">
                        @foreach($purchases as $purchase)
                        <tr>
                            <td>
                                <strong>{{ $purchase->purchase_number }}</strong>
                            </td>
                            <td>{{ $purchase->purchase_date->format('d M Y') }}</td>
                            <td>
                                <div>
                                    <strong>{{ $purchase->supplier->name }}</strong><br>
                                    <small class="text-muted">{{ $purchase->supplier->phone }}</small>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-info">{{ $purchase->purchaseDetails->count() }} item</span>
                            </td>
                            <td>
                                <strong>Rp {{ number_format($purchase->total_amount, 0, ',', '.') }}</strong>
                            </td>
                            <td>
                                @if($purchase->status == 'pending')
                                    <span class="badge bg-warning">Menunggu</span>
                                @elseif($purchase->status == 'completed')
                                    <span class="badge bg-success">Selesai</span>
                                @else
                                    <span class="badge bg-danger">Dibatalkan</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('purchases.show', $purchase->id) }}" 
                                       class="btn btn-sm btn-outline-info" title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('purchases.edit', $purchase->id) }}" 
                                       class="btn btn-sm btn-outline-primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @if($purchase->status == 'menunggu')
                                    <button type="button" class="btn btn-sm btn-outline-success" 
                                            onclick="updateStatus({{ $purchase->id }}, 'completed')" title="Mark as Completed">
                                        <i class="fas fa-check"></i>
                                    </button>
                                    @endif
                                    <button type="button" class="btn btn-sm btn-outline-danger" 
                                            onclick="deletePurchase({{ $purchase->id }})" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div>
                    <small class="text-muted">
                        Showing {{ $purchases->firstItem() }} to {{ $purchases->lastItem() }} of {{ $purchases->total() }} results
                    </small>
                </div>
                <div>
                    {{ $purchases->links() }}
                </div>
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">Tidak ada pembelian ditemukan</h5>
                <p class="text-muted">Mulai dengan membuat transaksi pembelian pertama Anda.</p>
                <a href="{{ route('purchases.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i> Buat Pembelian Pertama
                </a>
            </div>
        @endif
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
                <p>Apakah Anda yakin ingin menghapus pembelian ini? Tindakan ini tidak dapat dibatalkan.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger" id="confirmDelete">Hapus</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
let deleteId = null;

// Search functionality
$('#searchInput').on('keyup', function() {
    const searchTerm = $(this).val().toLowerCase();
    $('#purchaseTableBody tr').each(function() {
        const text = $(this).text().toLowerCase();
        $(this).toggle(text.includes(searchTerm));
    });
});

// Filter functionality
$('#applyFilter').on('click', function() {
    const supplier = $('#supplierFilter').val();
    const status = $('#statusFilter').val();
    const dateFrom = $('#dateFrom').val();
    const dateTo = $('#dateTo').val();
    
    // Build query string
    const params = new URLSearchParams();
    if (supplier) params.append('supplier', supplier);
    if (status) params.append('status', status);
    if (dateFrom) params.append('date_from', dateFrom);
    if (dateTo) params.append('date_to', dateTo);
    
    // Redirect with filters
    window.location.href = '{{ route("purchases.index") }}?' + params.toString();
});

// Reset filters
$('#resetFilter').on('click', function() {
    $('#supplierFilter').val('');
    $('#statusFilter').val('');
    $('#dateFrom').val('');
    $('#dateTo').val('');
    window.location.href = '{{ route("purchases.index") }}';
});

// Delete purchase
function deletePurchase(id) {
    deleteId = id;
    $('#deleteModal').modal('show');
}

$('#confirmDelete').on('click', function() {
    if (deleteId) {
        // Create form and submit
        const form = $('<form>', {
            method: 'POST',
            action: '{{ route("purchases.destroy", ":id") }}'.replace(':id', deleteId)
        });
        
        form.append('@csrf');
        form.append('@method("DELETE")');
        form.appendTo('body').submit();
    }
});

// Update status
function updateStatus(id, status) {
    if (confirm('Are you sure you want to mark this purchase as ' + status + '?')) {
        // Create form and submit
        const form = $('<form>', {
            method: 'POST',
            action: '{{ route("purchases.update", ":id") }}'.replace(':id', id)
        });
        
        form.append('@csrf');
        form.append('@method("PUT")');
        form.append($('<input>', {
            type: 'hidden',
            name: 'status',
            value: status
        }));
        
        form.appendTo('body').submit();
    }
}

// Auto-apply date filters when changed
$('#dateFrom, #dateTo').on('change', function() {
    if ($('#dateFrom').val() && $('#dateTo').val()) {
        $('#applyFilter').click();
    }
});
</script>
@endsection