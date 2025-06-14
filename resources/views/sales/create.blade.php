@extends('layouts.app')

@section('title', 'Create New Sale')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Create New Sale</h3>
                    <div class="card-tools">
                        <a href="{{ route('sales.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to Sales
                        </a>
                    </div>
                </div>
                <form action="{{ route('sales.store') }}" method="POST" id="saleForm">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <!-- Customer Information -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="customer_id">Customer <span class="text-muted">(Optional)</span></label>
                                    <select class="form-control select2" id="customer_id" name="customer_id">
                                        <option value="">Select Customer (Optional)</option>
                                        @foreach($customers as $customer)
                                            <option value="{{ $customer->id }}">{{ $customer->name }} - {{ $customer->phone }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            <!-- Sale Date -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="sale_date">Sale Date <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="sale_date" name="sale_date" value="{{ date('Y-m-d') }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Invoice Number -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="invoice_number">Invoice Number <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="invoice_number" name="invoice_number" value="{{ $invoiceNumber }}" readonly>
                                </div>
                            </div>
                            
                            <!-- Status -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status">Status <span class="text-danger">*</span></label>
                                    <select class="form-control" id="status" name="status" required>
                                        <option value="pending">Pending</option>
                                        <option value="completed" selected>Completed</option>
                                        <option value="cancelled">Cancelled</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Products Section -->
                        <div class="row">
                            <div class="col-12">
                                <h5 class="mb-3">Sale Items</h5>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="saleItemsTable">
                                        <thead class="thead-light">
                                            <tr>
                                                <th width="30%">Product <span class="text-danger">*</span></th>
                                                <th width="15%">Available Stock</th>
                                                <th width="15%">Quantity <span class="text-danger">*</span></th>
                                                <th width="15%">Unit Price <span class="text-danger">*</span></th>
                                                <th width="15%">Total</th>
                                                <th width="10%">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="item-row">
                                                <td>
                                                    <select class="form-control product-select" name="items[0][product_id]" required>
                                                        <option value="">Select Product</option>
                                                        @foreach($products as $product)
                                                            <option value="{{ $product->id }}" data-price="{{ $product->selling_price }}" data-stock="{{ $product->stock_quantity }}">{{ $product->name }} ({{ $product->sku }})</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <span class="available-stock">-</span>
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control quantity-input" name="items[0][quantity]" min="1" step="1" required>
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
                                                <td><strong id="subtotal">0.00</strong></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" class="text-right"><strong>Tax (%):</strong></td>
                                                <td>
                                                    <input type="number" class="form-control" id="tax_percentage" name="tax_percentage" min="0" max="100" step="0.01" value="0">
                                                </td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" class="text-right"><strong>Tax Amount:</strong></td>
                                                <td><strong id="tax_amount">0.00</strong></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" class="text-right"><strong>Discount:</strong></td>
                                                <td>
                                                    <input type="number" class="form-control" id="discount" name="discount" min="0" step="0.01" value="0">
                                                </td>
                                                <td></td>
                                            </tr>
                                            <tr class="table-success">
                                                <td colspan="4" class="text-right"><strong>Total Amount:</strong></td>
                                                <td><strong id="total_amount">0.00</strong></td>
                                                <td></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                <button type="button" class="btn btn-success btn-sm" id="addItem">
                                    <i class="fas fa-plus"></i> Add Item
                                </button>
                            </div>
                        </div>

                        <!-- Notes -->
                        <div class="row mt-3">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="notes">Notes</label>
                                    <textarea class="form-control" id="notes" name="notes" rows="3" placeholder="Additional notes for this sale..."></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Hidden fields for totals -->
                        <input type="hidden" id="subtotal_amount" name="subtotal_amount" value="0">
                        <input type="hidden" id="tax_amount_hidden" name="tax_amount" value="0">
                        <input type="hidden" id="total_amount_hidden" name="total_amount" value="0">
                    </div>
                    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Create Sale
                        </button>
                        <a href="{{ route('sales.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

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
                        <option value="">Select Product</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" data-price="{{ $product->selling_price }}" data-stock="{{ $product->stock_quantity }}">{{ $product->name }} ({{ $product->sku }})</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <span class="available-stock">-</span>
                </td>
                <td>
                    <input type="number" class="form-control quantity-input" name="items[${itemIndex}][quantity]" min="1" step="1" required>
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
    });
    
    // Remove item row
    $(document).on('click', '.remove-item', function() {
        $(this).closest('tr').remove();
        updateRemoveButtons();
        calculateTotals();
    });
    
    // Update remove buttons state
    function updateRemoveButtons() {
        const rowCount = $('#saleItemsTable tbody tr').length;
        $('.remove-item').prop('disabled', rowCount <= 1);
    }
    
    // Product selection change
    $(document).on('change', '.product-select', function() {
        const selectedOption = $(this).find('option:selected');
        const price = selectedOption.data('price') || 0;
        const stock = selectedOption.data('stock') || 0;
        const row = $(this).closest('tr');
        
        row.find('.price-input').val(price);
        row.find('.available-stock').text(stock);
        row.find('.quantity-input').attr('max', stock);
        
        calculateRowTotal(row);
    });
    
    // Quantity or price change
    $(document).on('input', '.quantity-input, .price-input', function() {
        const row = $(this).closest('tr');
        calculateRowTotal(row);
    });
    
    // Tax and discount change
    $('#tax_percentage, #discount').on('input', function() {
        calculateTotals();
    });
    
    // Calculate row total
    function calculateRowTotal(row) {
        const quantity = parseFloat(row.find('.quantity-input').val()) || 0;
        const price = parseFloat(row.find('.price-input').val()) || 0;
        const total = quantity * price;
        
        row.find('.item-total').text(total.toFixed(2));
        calculateTotals();
    }
    
    // Calculate all totals
    function calculateTotals() {
        let subtotal = 0;
        
        $('.item-total').each(function() {
            subtotal += parseFloat($(this).text()) || 0;
        });
        
        const taxPercentage = parseFloat($('#tax_percentage').val()) || 0;
        const discount = parseFloat($('#discount').val()) || 0;
        
        const taxAmount = (subtotal * taxPercentage) / 100;
        const totalAmount = subtotal + taxAmount - discount;
        
        $('#subtotal').text(subtotal.toFixed(2));
        $('#tax_amount').text(taxAmount.toFixed(2));
        $('#total_amount').text(totalAmount.toFixed(2));
        
        // Update hidden fields
        $('#subtotal_amount').val(subtotal.toFixed(2));
        $('#tax_amount_hidden').val(taxAmount.toFixed(2));
        $('#total_amount_hidden').val(totalAmount.toFixed(2));
    }
    
    // Form validation
    $('#saleForm').on('submit', function(e) {
        let isValid = true;
        let errorMessage = '';
        
        // Check if at least one item is added
        if ($('#saleItemsTable tbody tr').length === 0) {
            isValid = false;
            errorMessage += 'Please add at least one item to the sale.\n';
        }
        
        // Check stock availability
        $('.item-row').each(function() {
            const quantity = parseFloat($(this).find('.quantity-input').val()) || 0;
            const availableStock = parseFloat($(this).find('.available-stock').text()) || 0;
            const productName = $(this).find('.product-select option:selected').text();
            
            if (quantity > availableStock) {
                isValid = false;
                errorMessage += `Insufficient stock for ${productName}. Available: ${availableStock}, Requested: ${quantity}\n`;
            }
        });
        
        if (!isValid) {
            e.preventDefault();
            alert(errorMessage);
        }
    });
    
    // Initialize calculations
    calculateTotals();
});
</script>
@endpush
@endsection