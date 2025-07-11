@extends('layouts.app')

@section('title', 'Buat Penjualan Baru')
@section('page-title', 'Buat Penjualan Baru')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-cart-plus me-2"></i> Buat Penjualan Baru</h4>
                </div>
                
                <div class="card-body">
                    <form method="POST" action="{{ route('sales.store') }}" id="saleForm">
                        @csrf

                        <!-- Header Information -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="kode_penjualan" class="form-label">Kode Penjualan</label>
                                    <input type="text" class="form-control bg-light" id="kode_penjualan" name="kode_penjualan" value="{{ $kode_penjualan }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="sale_date" class="form-label">Tanggal Penjualan <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="sale_date" name="sale_date" value="{{ date('Y-m-d') }}" required>
                                </div>
                            </div>
                        </div>

                        <!-- Customer and Status -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="customer_id" class="form-label">Pelanggan <span class="text-muted">(Opsional)</span></label>
                                    <select class="form-select" id="customer_id" name="customer_id">
                                        <option value="">Pilih Pelanggan</option>
                                        @foreach($customers as $customer)
                                            <option value="{{ $customer->id }}">{{ $customer->name }} - {{ $customer->phone }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                    <select class="form-select" id="status" name="status" required>
                                        <option value="pending">Menunggu</option>
                                        <option value="completed" selected>Lengkap</option>
                                        <option value="cancelled">Dibatalkan</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Notes -->
                        <div class="mb-4">
                            <label for="notes" class="form-label">Catatan</label>
                            <textarea class="form-control" id="notes" name="notes" rows="2"></textarea>
                        </div>

                        <!-- Products Section -->
                        <div class="card mb-4">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Daftar Produk</h5>
                                <button type="button" class="btn btn-sm btn-success" id="addItem">
                                    <i class="fas fa-plus me-1"></i> Tambah Item
                                </button>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-bordered mb-0" id="itemsTable">
                                        <thead class="table-light">
                                            <tr>
                                                <th width="30%">Produk</th>
                                                <th width="10%">Stok</th>
                                                <th width="15%">Jumlah</th>
                                                <th width="20%">Harga Unit</th>
                                                <th width="20%">Subtotal</th>
                                                <th width="5%">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody id="itemsBody">
                                            <!-- Item rows will be added here -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Summary Section -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0">Ringkasan Pembayaran</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-8 offset-md-2">
                                        <table class="table table-borderless">
                                            <tr>
                                                <td class="text-end fw-bold">Subtotal:</td>
                                                <td class="text-end">
                                                    <span id="subtotalAmount">Rp 0</span>
                                                    <input type="hidden" name="subtotal_amount" id="subtotalAmountInput" value="0">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-end fw-bold">Pajak (%):</td>
                                                <td>
                                                    <input type="number" class="form-control form-control-sm text-end" id="tax_percentage" name="tax_percentage" min="0" max="100" step="0.01" value="0">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-end fw-bold">Jumlah Pajak:</td>
                                                <td class="text-end">
                                                    <span id="taxAmount">Rp 0</span>
                                                    <input type="hidden" name="tax_amount" id="taxAmountInput" value="0">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-end fw-bold">Diskon:</td>
                                                <td>
                                                    <input type="number" class="form-control form-control-sm text-end" id="discount" name="discount" min="0" step="0.01" value="0">
                                                </td>
                                            </tr>
                                            <tr class="border-top">
                                                <td class="text-end fw-bold">Total:</td>
                                                <td class="text-end fw-bold fs-5">
                                                    <span id="totalAmount">Rp 0</span>
                                                    <input type="hidden" name="total_amount" id="totalAmountInput" value="0">
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('sales.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-1"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Simpan Penjualan
                            </button>
                        </div>
                    </form>
                </div>
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
                    <option value="${product.id}" data-price="${product.harga_jual}" data-stock="${product.stok}">
                        ${product.nama_produk}
                    </option>
                `).join('')}
            </select>
        </td>
        <td>
            <span class="available-stock">-</span>
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

    // Event listeners
    const productSelect = row.querySelector('.product-select');
    const quantityInput = row.querySelector('.quantity-input');
    const priceInput = row.querySelector('.price-input');
    const removeBtn = row.querySelector('.remove-item');
    const stockSpan = row.querySelector('.available-stock');

    productSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        if (selectedOption.value) {
            priceInput.value = selectedOption.dataset.price || 0;
            stockSpan.textContent = selectedOption.dataset.stock || '-';
            quantityInput.max = selectedOption.dataset.stock || '';
            if (parseInt(selectedOption.dataset.stock) <= 0) {
                quantityInput.value = 0;
                quantityInput.disabled = true;
                stockSpan.classList.add('text-danger');
            } else {
                quantityInput.value = 1;
                quantityInput.disabled = false;
                stockSpan.classList.remove('text-danger');
            }
            calculateSubtotal(row);
        } else {
            priceInput.value = '';
            stockSpan.textContent = '-';
            quantityInput.value = 1;
            quantityInput.disabled = false;
            stockSpan.classList.remove('text-danger');
            calculateSubtotal(row);
        }
    });

    quantityInput.addEventListener('input', () => calculateSubtotal(row));
    priceInput.addEventListener('input', () => calculateSubtotal(row));

    removeBtn.addEventListener('click', function() {
        row.remove();
        calculateAllTotals();
    });
}

function calculateSubtotal(row) {
    const quantity = parseFloat(row.querySelector('.quantity-input').value) || 0;
    const price = parseFloat(row.querySelector('.price-input').value) || 0;
    const subtotal = quantity * price;
    row.querySelector('.subtotal').textContent = 'Rp ' + subtotal.toLocaleString('id-ID');
    calculateAllTotals();
}

function calculateAllTotals() {
    let subtotal = 0;
    document.querySelectorAll('#itemsBody tr').forEach(row => {
        const quantity = parseFloat(row.querySelector('.quantity-input').value) || 0;
        const price = parseFloat(row.querySelector('.price-input').value) || 0;
        subtotal += quantity * price;
    });

    document.getElementById('subtotalAmount').textContent = 'Rp ' + subtotal.toLocaleString('id-ID');
    document.getElementById('subtotalAmountInput').value = subtotal;

    const taxPercentage = parseFloat(document.getElementById('tax_percentage').value) || 0;
    const discount = parseFloat(document.getElementById('discount').value) || 0;
    const taxAmount = subtotal * taxPercentage / 100;
    const total = subtotal + taxAmount - discount;

    document.getElementById('taxAmount').textContent = 'Rp ' + taxAmount.toLocaleString('id-ID');
    document.getElementById('taxAmountInput').value = taxAmount;
    document.getElementById('totalAmount').textContent = 'Rp ' + total.toLocaleString('id-ID');
    document.getElementById('totalAmountInput').value = total;
}

// Event listeners
document.getElementById('addItem').addEventListener('click', addItem);
document.getElementById('tax_percentage').addEventListener('input', calculateAllTotals);
document.getElementById('discount').addEventListener('input', calculateAllTotals);

// Form validation
document.getElementById('saleForm').addEventListener('submit', function(e) {
    const itemsCount = document.querySelectorAll('#itemsBody tr').length;
    if (itemsCount === 0) {
        e.preventDefault();
        alert('Harap tambahkan minimal satu item produk.');
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
        alert('Harap lengkapi semua kolom item produk.');
        return false;
    }
});

// Add first item on page load
document.addEventListener('DOMContentLoaded', function() {
    addItem();
});
</script>
@endsection