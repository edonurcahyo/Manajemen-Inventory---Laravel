@extends('layouts.app')

@section('title', 'Create New Sale')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Buat Penjualan</h3>
                    <div class="card-tools">
                        <a href="{{ route('sales.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Kembali ke Penjualan
                        </a>
                    </div>
                </div>
                <form action="{{ route('sales.store') }}" method="POST" id="saleForm">
                    @csrf
                    <div class="card-body">
                        <!-- Customer and Date Section -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="customer_id">Pelanggan <span class="text-muted">(Opsional)</span></label>
                                    <select class="form-control select2" id="customer_id" name="customer_id">
                                        <option value="">Pilih Pelanggan (Opsional)</option>
                                        @foreach($customers as $customer)
                                            <option value="{{ $customer->id }}">{{ $customer->name }} - {{ $customer->phone }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="sale_date">Tanggal Penjualan <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="sale_date" name="sale_date" value="{{ date('Y-m-d') }}" required>
                                </div>
                            </div>
                        </div>

                        <!-- Invoice and Status Section -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="kode_penjualan">Kode Penjualan <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="kode_penjualan" name="kode_penjualan" value="{{ $kode_penjualan }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status">Status <span class="text-danger">*</span></label>
                                    <select class="form-control" id="status" name="status" required>
                                        <option value="pending">Menunggu</option>
                                        <option value="completed" selected>Lengkap</option>
                                        <option value="cancelled">Dibatalkan</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Products Section -->
                        <div class="row">
                            <div class="col-12">
                                <h5 class="mb-3">Detail Penjualan</h5>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="saleItemsTable">
                                        <thead class="thead-light">
                                            <tr>
                                                <th width="30%">Produk <span class="text-danger">*</span></th>
                                                <th width="15%">Stok Tersedia</th>
                                                <th width="15%">Jumlah <span class="text-danger">*</span></th>
                                                <th width="15%">Harga Unit <span class="text-danger">*</span></th>
                                                <th width="15%">Total</th>
                                                <th width="10%">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="item-row">
                                                <td>
                                                    <select class="form-control product-select" name="items[0][product_id]" required>
                                                        <option value="">Pilih Produk</option>
                                                        @foreach($products as $product)
                                                        <option value="{{ $product->id }}" 
                                                                data-price="{{ $product->harga_jual }}" 
                                                                data-stock="{{ $product->stok }}">
                                                            {{ $product->nama_produk }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <span class="available-stock">-</span>
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control quantity-input" name="items[0][quantity]" min="1" value="1" step="1" required>
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control price-input" name="items[0][unit_price]" min="0" step="0.01" required>
                                                </td>
                                                <td>
                                                    <span class="item-total">0.00</span>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-danger btn-sm remove-item" disabled>
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="4" class="text-right"><strong>Subtotal:</strong></td>
                                                <td><span id="subtotal">0.00</span></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" class="text-right"><strong>Pajak (%):</strong></td>
                                                <td>
                                                    <input type="number" class="form-control tax-input" id="tax_percentage" name="tax_percentage" min="0" max="100" step="0.01" value="0">
                                                </td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" class="text-right"><strong>Jumlah Pajak:</strong></td>
                                                <td><span id="tax_amount">0.00</span></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" class="text-right"><strong>Diskon:</strong></td>
                                                <td>
                                                    <input type="number" class="form-control discount-input" id="discount" name="discount" min="0" step="0.01" value="0">
                                                </td>
                                                <td></td>
                                            </tr>
                                            <tr class="table-success">
                                                <td colspan="4" class="text-right"><strong>Total:</strong></td>
                                                <td><span id="total_amount">0.00</span></td>
                                                <td></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                <button type="button" class="btn btn-success btn-sm mt-2" id="addItem">
                                    <i class="fas fa-plus"></i> Tambah Item
                                </button>
                            </div>
                        </div>

                        <!-- Notes Section -->
                        <div class="row mt-3">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="notes">Catatan</label>
                                    <textarea class="form-control" id="notes" name="notes" rows="3" placeholder="Catatan tambahan untuk penjualan ini..."></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Hidden fields -->
                        <input type="hidden" id="subtotal_hidden" name="subtotal_amount" value="0">
                        <input type="hidden" id="tax_amount_hidden" name="tax_amount" value="0">
                        <input type="hidden" id="total_amount_hidden" name="total_amount" value="0">
                    </div>
                    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan Penjualan
                        </button>
                        <a href="{{ route('sales.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    let itemIndex = 1;
    
    // Initialize Select2
    $('.select2').select2();
    
    // Add new item row
    $('#addItem').click(function() {
        const newRow = `
            <tr class="item-row">
                <td>
                    <select class="form-control product-select" name="items[${itemIndex}][product_id]" required>
                        <option value="">Pilih Produk</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" 
                                    data-price="{{ $product->harga_jual }}" 
                                    data-stock="{{ $product->stok }}">
                                {{ $product->nama_produk }}
                            </option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <span class="available-stock">-</span>
                </td>
                <td>
                    <input type="number" class="form-control quantity-input" name="items[${itemIndex}][quantity]" min="1" value="1" step="1" required>
                </td>
                <td>
                    <input type="number" class="form-control price-input" name="items[${itemIndex}][unit_price]" min="0" step="0.01" required>
                </td>
                <td>
                    <span class="item-total">0.00</span>
                </td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm remove-item">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
        `;
        
        $('#saleItemsTable tbody').append(newRow);
        itemIndex++;
        updateRemoveButtons();
        
        // Initialize Select2 for new row
        $('#saleItemsTable tbody tr:last-child').find('.product-select').select2();
        
        // Initialize events for new row
        initRowEvents($('#saleItemsTable tbody tr:last-child'));
    });
    
    // Initialize events for first row
    initRowEvents($('#saleItemsTable tbody tr:first-child'));
    
    function initRowEvents(row) {
        // Product selection change
        row.find('.product-select').on('change', function() {
            const selectedOption = $(this).find('option:selected');
            const price = parseFloat(selectedOption.data('price')) || 0;
            const stock = parseInt(selectedOption.data('stock')) || 0;
            const row = $(this).closest('tr');

            // Update price and stock display
            row.find('.price-input').val(price.toFixed(2));
            row.find('.available-stock').text(stock);
            
            // Set quantity and validate
            const quantityInput = row.find('.quantity-input');
            quantityInput.attr('max', stock).val(stock > 0 ? 1 : 0);
            
            // Visual feedback for stock
            if (stock <= 0) {
                row.find('.available-stock').addClass('text-danger');
                quantityInput.prop('disabled', true);
            } else {
                row.find('.available-stock').removeClass('text-danger');
                quantityInput.prop('disabled', false);
            }
            
            calculateRowTotal(row);
        });

        // Quantity or price change
        row.find('.quantity-input, .price-input').on('input', function() {
            validateQuantity($(this).closest('tr'));
            calculateRowTotal($(this).closest('tr'));
        });
    }
    
    // Validate quantity against available stock
    function validateQuantity(row) {
        const quantity = parseInt(row.find('.quantity-input').val()) || 0;
        const stock = parseInt(row.find('.available-stock').text()) || 0;
        
        if (quantity > stock) {
            row.find('.quantity-input').addClass('is-invalid');
            row.find('.available-stock').addClass('text-danger');
            return false;
        } else {
            row.find('.quantity-input').removeClass('is-invalid');
            row.find('.available-stock').removeClass('text-danger');
            return true;
        }
    }
    
    // Remove item row
    $(document).on('click', '.remove-item', function() {
        if($('#saleItemsTable tbody tr').length > 1) {
            $(this).closest('tr').remove();
            updateRemoveButtons();
            calculateTotals();
        }
    });
    
    // Update remove buttons state
    function updateRemoveButtons() {
        const rowCount = $('#saleItemsTable tbody tr').length;
        $('.remove-item').prop('disabled', rowCount <= 1);
    }
    
    // Calculate row total
    function calculateRowTotal(row) {
        const quantity = parseFloat(row.find('.quantity-input').val()) || 0;
        const price = parseFloat(row.find('.price-input').val()) || 0;
        const total = quantity * price;

        row.find('.item-total').text(total.toFixed(2)).data('value', total);
        calculateTotals();
    }

    // Calculate all totals
    function calculateTotals() {
        let subtotal = 0;
        let allValid = true;

        $('.item-row').each(function() {
            const total = parseFloat($(this).find('.item-total').data('value')) || 0;
            subtotal += total;
            
            // Check if any row has invalid quantity
            if (!validateQuantity($(this))) {
                allValid = false;
            }
        });

        const taxPercentage = parseFloat($('#tax_percentage').val()) || 0;
        const discount = parseFloat($('#discount').val()) || 0;
        const taxAmount = (subtotal * taxPercentage) / 100;
        const totalAmount = subtotal + taxAmount - discount;

        // Update display with proper formatting
        $('#subtotal').text(subtotal.toLocaleString('id-ID', {minimumFractionDigits: 2}));
        $('#tax_amount').text(taxAmount.toLocaleString('id-ID', {minimumFractionDigits: 2}));
        $('#total_amount').text(totalAmount.toLocaleString('id-ID', {minimumFractionDigits: 2}));

        // Update hidden fields
        $('#subtotal_hidden').val(subtotal.toFixed(2));
        $('#tax_amount_hidden').val(taxAmount.toFixed(2));
        $('#total_amount_hidden').val(totalAmount.toFixed(2));

        // Enable/disable submit button based on validation
        $('#saleForm button[type="submit"]').prop('disabled', !allValid);
    }

    // Tax or discount change
    $(document).on('input', '#tax_percentage, #discount', function() {
        calculateTotals();
    });

    // Form validation
    $('#saleForm').on('submit', function(e) {
        let isValid = true;
        let errorMessages = [];
        
        // Check if at least one item is added
        if ($('#saleItemsTable tbody tr').length === 0) {
            isValid = false;
            errorMessages.push('Harap tambahkan minimal satu item produk');
        }
        
        // Check stock availability
        $('.item-row').each(function() {
            const quantity = parseFloat($(this).find('.quantity-input').val()) || 0;
            const availableStock = parseInt($(this).find('.available-stock').text()) || 0;
            const productName = $(this).find('.product-select option:selected').text();
            
            if (quantity > availableStock) {
                isValid = false;
                errorMessages.push(`Stok tidak mencukupi untuk ${productName} (Stok: ${availableStock}, Jumlah: ${quantity})`);
            }
        });
        
        if (!isValid) {
            e.preventDefault();
            alert('Kesalahan:\n\n' + errorMessages.join('\n'));
        }
    });

    // Initialize calculations on page load
    $('.product-select').first().trigger('change');
});
</script>
@endpush