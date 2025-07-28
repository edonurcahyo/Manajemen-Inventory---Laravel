@extends('layouts.app')

@section('title', 'Buat Pembelian Baru')
@section('page-title', 'Buat Pembelian Baru')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('purchases.store') }}" id="purchaseForm">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="supplier_id" class="form-label">Pemasok *</label>
                                <select class="form-select @error('supplier_id') is-invalid @enderror" id="supplier_id" name="supplier_id">
                                    <option value="">Pilih Pemasok</option>
                                    @foreach($suppliers ?? [] as $supplier)
                                        <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                            {{ $supplier->nama_supplier }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('supplier_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="tanggal" class="form-label">Tanggal Pembelian *</label>
                                <input type="date" class="form-control @error('tanggal') is-invalid @enderror"
                                    id="tanggal" name="tanggal"
                                    value="{{ old('tanggal', date('Y-m-d')) }}" required>
                                @error('tanggal')   
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="notes" class="form-label">Catatan</label>
                        <textarea class="form-control" id="notes" name="notes" rows="2">{{ old('notes') }}</textarea>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5>Item Pembelian</h5>
                        <button type="button" class="btn btn-success" id="addItem">
                            <i class="fas fa-plus"></i> Tambah Item
                        </button>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered" id="itemsTable">
                            <thead>
                                <tr>
                                    <th width="30%">Produk</th>
                                    <th width="15%">Kuantitas</th>
                                    <th width="20%">Harga Satuan</th>
                                    <th width="20%">Subtotal</th>
                                    <th width="10%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="itemsBody">
                                <!-- Items will be added here -->
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="3" class="text-end">Total:</th>
                                    <th>
                                        <span id="totalAmount">Rp 0</span>
                                        <input type="hidden" name="total_amount" id="totalAmountInput" value="0">
                                    </th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('purchases.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Simpan Pembelian
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
let itemIndex = 0;
const products = @json($products);
function addItem() {
    const tbody = document.getElementById('itemsBody');
    const row = document.createElement('tr');
    row.innerHTML = `
        <td>
            <select class="form-select product-select" name="items[${itemIndex}][product_id]" required>
                <option value="">Pilih Produk</option>
                ${products.map(product => `
                    <option value="${product.id}" data-price="${product.harga_beli}">${product.nama_produk}</option>
                `).join('')}
            </select>
        </td>
        <td>
            <input type="number" class="form-control quantity-input" name="items[${itemIndex}][quantity]" min="1" value="1" required>
        </td>
        <td>
            <input type="number" class="form-control price-input" name="items[${itemIndex}][unit_price]" step="0.01" required>
        </td>
        <td>
            <span class="subtotal">Rp 0</span>
        </td>
        <td>
            <button type="button" class="btn btn-danger btn-sm remove-item">
                <i class="fas fa-trash"></i>
            </button>
        </td>
    `;
    tbody.appendChild(row);
    itemIndex++;
    
    // Add event listeners
    const productSelect = row.querySelector('.product-select');
    const quantityInput = row.querySelector('.quantity-input');
    const priceInput = row.querySelector('.price-input');
    const removeBtn = row.querySelector('.remove-item');
    
    productSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        if (selectedOption.value) {
            priceInput.value = selectedOption.dataset.price || 0;
            calculateSubtotal(row);
        }
    });
    
    quantityInput.addEventListener('input', () => calculateSubtotal(row));
    priceInput.addEventListener('input', () => calculateSubtotal(row));
    
    removeBtn.addEventListener('click', function() {
        row.remove();
        calculateTotal();
    });
}

function calculateSubtotal(row) {
    const quantity = parseFloat(row.querySelector('.quantity-input').value) || 0;
    const price = parseFloat(row.querySelector('.price-input').value) || 0;
    const subtotal = quantity * price;
    
    row.querySelector('.subtotal').textContent = 'Rp ' + subtotal.toLocaleString('id-ID');
    calculateTotal();
}

function calculateTotal() {
    let total = 0;
    document.querySelectorAll('#itemsBody tr').forEach(row => {
        const quantity = parseFloat(row.querySelector('.quantity-input').value) || 0;
        const price = parseFloat(row.querySelector('.price-input').value) || 0;
        total += quantity * price;
    });
    
    document.getElementById('totalAmount').textContent = 'Rp ' + total.toLocaleString('id-ID');
    document.getElementById('totalAmountInput').value = total;
}

// Event listeners
document.getElementById('addItem').addEventListener('click', addItem);

// Form validation
document.getElementById('purchaseForm').addEventListener('submit', function(e) {
    const itemsCount = document.querySelectorAll('#itemsBody tr').length;
    if (itemsCount === 0) {
        e.preventDefault();
        alert('Please add at least one item to the purchase order.');
        return false;
    }
    
    // Validate all items have required fields
    let isValid = true;
    document.querySelectorAll('#itemsBody tr').forEach(row => {
        const productSelect = row.querySelector('.product-select');
        const quantityInput = row.querySelector('.quantity-input');
        const priceInput = row.querySelector('.price-input');
        
        if (!productSelect.value || !quantityInput.value || !priceInput.value) {
            isValid = false;
        }
    });
    
    if (!isValid) {
        e.preventDefault();
        alert('Please fill in all required fields for each item.');
        return false;
    }
});

// Add first item on page load
document.addEventListener('DOMContentLoaded', function() {
    addItem();
});
</script>
@endsection