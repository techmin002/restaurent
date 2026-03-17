@extends('setting::layouts.master')

@section('title', 'Expense Details')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>Expense Details</h1>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">

            <!-- Expense Info -->
            <div class="card mb-3">
                <div class="card-body">
                    <strong>Expense:</strong> {{ $expense->title }} <br>
                    <strong>Date:</strong> {{ $expense->date }} <br>
                    <strong>Status:</strong>
                    <span class="badge bg-info">{{ ucfirst($expense->status ?? 'pending') }}</span>
                </div>
            </div>

            <!-- Expense Products Table -->
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Expense Products</h3>
                    <!-- Use Bootstrap 4 syntax -->
                    <button class="btn btn-info text-white" data-toggle="modal" data-target="#createExpenseProductModal">
                        <i class="fa fa-plus"></i> Add Products
                    </button>
                </div>

                <div class="card-body">
                    <table class="table table-bordered table-striped text-center">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Product Name</th>
                                <th>Qty</th>
                                <th>Price</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($expense->expenseProducts as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->product_name }}</td>
                                    <td>{{ $item->product_qty }}</td>
                                    <td>{{ number_format($item->product_price, 2) }}</td>
                                    <td>{{ number_format($item->total_price, 2) }}</td>
                                    <td><span class="badge bg-success">{{ ucfirst($item->status) }}</span></td>
                                    <td>
                                        <form action="{{ route('expense-products.destroy', $item->id) }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted">
                                        No expense products found. Click "Add Products" to add items.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>

                        <tfoot>
                            <tr class="text-end">
                                <th colspan="4">Grand Total</th>
                                <th>{{ number_format($expense->expenseProducts->sum('total_price'), 2) }}</th>
                                <th colspan="2"></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <!-- Back Button -->
            <a href="{{ route('expenses.index') }}" class="btn btn-secondary mt-3">← Back to Expenses</a>

        </div>
    </section>
</div>

<!-- Create Expense Product Modal - Bootstrap 4 Syntax -->
<div class="modal fade" id="createExpenseProductModal" tabindex="-1" role="dialog" aria-labelledby="createExpenseProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border-radius:8px;">
            <div class="modal-header bg-info text-white justify-content-center">
                <h5 class="modal-title" id="createExpenseProductModalLabel">Add Expense Products</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('expense-products.store') }}" method="POST" id="expenseProductsForm">
                @csrf
                <input type="hidden" name="expense_id" value="{{ $expense->id }}">
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-bordered text-center" id="productsTable">
                            <thead class="thead-light">
                                <tr>
                                    <th width="35%">Product Name</th>
                                    <th width="15%">Qty</th>
                                    <th width="20%">Price (₹)</th>
                                    <th width="20%">Total (₹)</th>
                                    <th width="10%">Action</th>
                                </tr>
                            </thead>
                            <tbody id="productsBody">
                                <tr class="product-row">
                                    <td>
                                        <input type="text" name="products[0][product_name]" class="form-control product-name" placeholder="Enter product name" required>
                                    </td>
                                    <td>
                                        <input type="number" name="products[0][product_qty]" class="form-control qty" min="1" value="1" required>
                                    </td>
                                    <td>
                                        <input type="number" name="products[0][product_price]" class="form-control price" min="0" step="0.01" placeholder="0.00" required>
                                    </td>
                                    <td>
                                        <input type="text" name="products[0][total_price]" class="form-control total" readonly value="0.00">
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-danger btn-sm remove-row" disabled>
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="5" class="text-right">
                                        <button type="button" class="btn btn-success btn-sm" id="addMoreBtn">
                                            <i class="fa fa-plus"></i> Add More Row
                                        </button>
                                    </td>
                                </tr>
                                <tr class="bg-light">
                                    <td colspan="3" class="text-right"><strong>Grand Total:</strong></td>
                                    <td>
                                        <input type="text" class="form-control bg-light font-weight-bold text-success" id="grandTotal" readonly value="0.00">
                                    </td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <div class="form-group mt-3">
                        <label>Status for all products</label>
                        <select name="status" class="form-control" required>
                            <option value="active" selected>Active</option>
                            <option value="pending">Pending</option>
                            <option value="completed">Completed</option>
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Save All Products</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .product-row input.form-control {
        text-align: center;
        border: 1px solid #ced4da;
    }
    .product-row input.total {
        font-weight: bold;
        background-color: #f8f9fa;
        color: #28a745;
    }
    #grandTotal {
        font-weight: bold;
        font-size: 1.1em;
        color: #28a745;
    }
    .remove-row:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }
    .thead-light th {
        background-color: #f8f9fa;
        font-weight: 600;
    }
    .modal-content {
        box-shadow: 0 5px 15px rgba(0,0,0,0.3);
    }
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    let rowCount = 1; // Start from 1 since we already have one row
    
    // Function to calculate total for a row
    function calculateRowTotal(row) {
        const qty = parseFloat(row.find('.qty').val()) || 0;
        const price = parseFloat(row.find('.price').val()) || 0;
        const total = qty * price;
        row.find('.total').val(total.toFixed(2));
        calculateGrandTotal();
    }
    
    // Function to calculate grand total
    function calculateGrandTotal() {
        let grandTotal = 0;
        $('.product-row').each(function() {
            const total = parseFloat($(this).find('.total').val()) || 0;
            grandTotal += total;
        });
        $('#grandTotal').val(grandTotal.toFixed(2));
    }
    
    // Calculate totals when quantity or price changes
    $(document).on('input', '.qty, .price', function() {
        const row = $(this).closest('.product-row');
        calculateRowTotal(row);
    });
    
    // Add more rows
    $('#addMoreBtn').click(function() {
        const newRow = `
            <tr class="product-row">
                <td>
                    <input type="text" name="products[${rowCount}][product_name]" class="form-control product-name" placeholder="Enter product name" required>
                </td>
                <td>
                    <input type="number" name="products[${rowCount}][product_qty]" class="form-control qty" min="1" value="1" required>
                </td>
                <td>
                    <input type="number" name="products[${rowCount}][product_price]" class="form-control price" min="0" step="0.01" placeholder="0.00" required>
                </td>
                <td>
                    <input type="text" name="products[${rowCount}][total_price]" class="form-control total" readonly value="0.00">
                </td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm remove-row">
                        <i class="fa fa-times"></i>
                    </button>
                </td>
            </tr>
        `;
        $('#productsBody').append(newRow);
        rowCount++;
        
        // Enable remove button for first row if there are more than 1 rows
        updateRemoveButtons();
    });
    
    // Update remove buttons state
    function updateRemoveButtons() {
        const rowCount = $('.product-row').length;
        if (rowCount > 1) {
            $('.remove-row').prop('disabled', false);
        } else {
            $('.remove-row').prop('disabled', true);
        }
    }
    
    // Remove row
    $(document).on('click', '.remove-row', function() {
        if ($('.product-row').length > 1) {
            $(this).closest('.product-row').remove();
            calculateGrandTotal();
            updateRemoveButtons();
        }
    });
    
    // Clear form when modal is hidden
    $('#createExpenseProductModal').on('hidden.bs.modal', function() {
        // Reset to single row
        $('#productsBody').html(`
            <tr class="product-row">
                <td>
                    <input type="text" name="products[0][product_name]" class="form-control product-name" placeholder="Enter product name" required>
                </td>
                <td>
                    <input type="number" name="products[0][product_qty]" class="form-control qty" min="1" value="1" required>
                </td>
                <td>
                    <input type="number" name="products[0][product_price]" class="form-control price" min="0" step="0.01" placeholder="0.00" required>
                </td>
                <td>
                    <input type="text" name="products[0][total_price]" class="form-control total" readonly value="0.00">
                </td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm remove-row" disabled>
                        <i class="fa fa-times"></i>
                    </button>
                </td>
            </tr>
        `);
        rowCount = 1;
        $('#grandTotal').val('0.00');
    });
    
    // Initialize
    updateRemoveButtons();
    
    // Handle form submission
    $('#expenseProductsForm').submit(function(e) {
        e.preventDefault();
        
        // Validate all rows
        let isValid = true;
        $('.product-row').each(function(index) {
            const productName = $(this).find('.product-name').val().trim();
            const qty = $(this).find('.qty').val();
            const price = $(this).find('.price').val();
            
            if (!productName || !qty || qty <= 0 || !price || price < 0) {
                isValid = false;
                $(this).addClass('table-danger');
                if (!productName) {
                    $(this).find('.product-name').addClass('is-invalid');
                } else {
                    $(this).find('.product-name').removeClass('is-invalid');
                }
                if (!qty || qty <= 0) {
                    $(this).find('.qty').addClass('is-invalid');
                } else {
                    $(this).find('.qty').removeClass('is-invalid');
                }
                if (!price || price < 0) {
                    $(this).find('.price').addClass('is-invalid');
                } else {
                    $(this).find('.price').removeClass('is-invalid');
                }
            } else {
                $(this).removeClass('table-danger');
                $(this).find('.product-name, .qty, .price').removeClass('is-invalid');
            }
        });
        
        if (!isValid) {
            alert('Please fill in all fields with valid values for all products.');
            return;
        }
        
        // Submit form
        const form = $(this);
        const submitBtn = form.find('button[type="submit"]');
        const originalText = submitBtn.text();
        
        submitBtn.prop('disabled', true).text('Saving...');
        
        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: form.serialize(),
            success: function(response) {
                if (response.success) {
                    alert(response.message || 'Products added successfully!');
                    $('#createExpenseProductModal').modal('hide');
                    location.reload();
                } else {
                    alert(response.message || 'Error adding products.');
                }
                submitBtn.prop('disabled', false).text(originalText);
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    let errorMessage = 'Please fix the following errors:\n\n';
                    $.each(errors, function(key, value) {
                        errorMessage += '• ' + value + '\n';
                    });
                    alert(errorMessage);
                } else {
                    alert('Error adding products. Please try again.');
                }
                submitBtn.prop('disabled', false).text(originalText);
            }
        });
    });
});
</script>
@endpush