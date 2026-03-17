@extends('setting::layouts.master')
<meta name="csrf-token" content="{{ csrf_token() }}">
@section('title', 'Products')
@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('suppliers.index') }}">Suppliers</a></li>
        <li class="breadcrumb-item active">Products</li>
    </ol>
@endsection

@section('content')
<div class="content-wrapper">
    <!-- Content Header -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Products</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('suppliers.index') }}">Suppliers</a></li>
                        <li class="breadcrumb-item active">Products</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <!-- Card Header -->
                        <div class="card-header">
                            <h3 class="card-title float-right">
                                <a class="btn btn-info text-white" data-toggle="modal" data-target="#addProductModal">
                                    <i class="fa fa-plus"></i> Add Product
                                </a>
                            </h3>
                        </div>
                        <!-- Card Body -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center">S.N</th>
                                        <th class="text-center">Product Name</th>
                                        
                                        <th class="text-center">Price</th>
                                        <th class="text-center">Quantity</th>
                                        <th class="text-center">Description</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                {{-- <tbody>
                                    @forelse($products as $product)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td class="text-center">{{ $product->name }}</td>
                                        <td class="text-center">{{ $product->supplier->company_name ?? 'N/A' }}</td>
                                        <td class="text-center">{{ number_format($product->price, 2) }}</td>
                                        <td class="text-center">{{ $product->stock_quantity }}</td>
                                        <td class="text-center">{{ \Illuminate\Support\Str::limit($product->description, 30) }}</td>
                                        <td class="text-center">
                                            @if($product->status == 'active')
                                                <span class="badge badge-success">Active</span>
                                            @else
                                                <span class="badge badge-danger">Inactive</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <!-- Edit Button with Modal -->
                                            <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editProductModal{{ $product->id }}">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            
                                            <!-- View Button -->
                                            <a href="{{ route('products.show', $product->id) }}" class="btn btn-success btn-sm">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            
                                            <!-- Delete Button -->
                                            <button class="btn btn-danger btn-sm" onclick="confirmDelete({{ $product->id }})">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                            <form id="delete-form-{{ $product->id }}" action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-none">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </td>
                                    </tr>
                                    
                                    <!-- Edit Modal for each product -->
                                    <div class="modal fade" id="editProductModal{{ $product->id }}" tabindex="-1" role="dialog">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <form method="POST" action="{{ route('products.update', $product->id) }}">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-content">
                                                    <div class="modal-header bg-primary text-white">
                                                        <h5 class="modal-title">Edit Product</h5>
                                                        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-6 mb-3">
                                                                <label>Product Name</label>
                                                                <input type="text" name="name" class="form-control" value="{{ $product->name }}" required>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label>Price</label>
                                                                <input type="number" min="0" step="0.01" name="price" class="form-control" value="{{ $product->price }}" required>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label>Quantity</label>
                                                                <input type="number" min="0" name="stock_quantity" class="form-control" value="{{ $product->stock_quantity }}" required>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label>Supplier</label>
                                                                <select name="supplier_id" class="form-control" required>
                                                                    <option value="">Select Supplier</option>
                                                                    @foreach($suppliers as $supplier)
                                                                    <option value="{{ $supplier->id }}" {{ $product->supplier_id == $supplier->id ? 'selected' : '' }}>
                                                                        {{ $supplier->company_name }}
                                                                    </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-md-12 mb-3">
                                                                <label>Description</label>
                                                                <textarea name="description" class="form-control" rows="3">{{ $product->description }}</textarea>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label>Status</label>
                                                                <select name="status" class="form-control">
                                                                    <option value="active" {{ $product->status == 'active' ? 'selected' : '' }}>Active</option>
                                                                    <option value="inactive" {{ $product->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-primary">Update Product</button>
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    @empty
                                    <tr>
                                        <td colspan="8" class="text-center">No products found.</td>
                                    </tr>
                                    @endforelse
                                </tbody> --}}
                                <tfoot>
                                    <tr>
                                        <th class="text-center">S.N</th>
                                        <th class="text-center">Product Name</th>
                                        
                                        <th class="text-center">Price</th>
                                        <th class="text-center">Quantity</th>
                                        <th class="text-center">Description</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </tfoot>
                            </table>

                            <!-- Pagination -->
                            {{-- @if($products->hasPages())
                            <div class="d-flex justify-content-center mt-3">
                                {{ $products->links() }}
                            </div>
                            @endif --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Add Product Modal -->
<!-- Add Product Modal -->
<div class="modal fade" id="addProductModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <form id="addProductForm">
            @csrf
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title">Add Products</h5>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">

                    <!-- Dynamic Product Rows Container -->
                    <div id="productRowsContainer">
                        <div class="product-row row align-items-end mb-2" data-index="0">
                            <div class="col-md-4 mb-2">
                                <label>Product Name *</label>
                                <input type="text" name="products[0][name]" class="form-control" placeholder="Product Name" required>
                            </div>
                            <div class="col-md-2 mb-2">
                                <label>Price *</label>
                                <input type="number" min="0" step="0.01" name="products[0][price]" class="form-control" placeholder="Price" required>
                            </div>
                            <div class="col-md-2 mb-2">
                                <label>Quantity *</label>
                                <input type="number" min="0" name="products[0][stock_quantity]" class="form-control" placeholder="Quantity" required>
                            </div>
                            {{-- <div class="col-md-3 mb-2">
                                <label>Supplier *</label>
                                <select name="products[0][supplier_id]" class="form-control" required>
                                    <option value="">Select Supplier</option>
                                    @foreach($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}">{{ $supplier->company_name }}</option>
                                    @endforeach
                                </select>
                            </div> --}}
                            <div class="col-md-1 text-right mb-2">
                                <button type="button" class="btn btn-success btn-sm addRow" title="Add Product"><i class="fas fa-plus"></i></button>
                            </div>
                        </div>
                    </div>

                    <!-- Summary -->
                    <div class="mt-3 p-2 border rounded bg-light">
                        <strong>Total Products:</strong> <span id="totalProductsCount">1</span> |
                        <strong>Total Value:</strong> $<span id="totalProductsValue">0.00</span>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-info">
                        <i class="fas fa-save mr-1"></i> Save Products
                    </button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function(){
    let productIndex = 1;

    // Add new row dynamically
    $(document).on('click', '.addRow', function(){
        const container = $('#productRowsContainer');
        const newRow = container.find('.product-row').first().clone();

        newRow.attr('data-index', productIndex);
        newRow.find('input, select').each(function(){
            const name = $(this).attr('name');
            const newName = name.replace(/\d+/, productIndex);
            $(this).attr('name', newName).val('');
        });

        // Change add button to remove button
        newRow.find('.addRow')
              .removeClass('btn-success addRow')
              .addClass('btn-danger removeRow')
              .html('<i class="fas fa-trash"></i>')
              .attr('title','Remove Product');

        container.append(newRow);
        productIndex++;
        updateSummary();
    });

    // Remove row
    $(document).on('click', '.removeRow', function(){
        $(this).closest('.product-row').remove();
        updateSummary();
    });

    // Update summary on input
    $(document).on('input','[name*="[price]"],[name*="[stock_quantity]"]',updateSummary);

    function updateSummary(){
        const totalRows = $('.product-row').length;
        $('#totalProductsCount').text(totalRows);

        let totalValue = 0;
        $('.product-row').each(function(){
            const price = parseFloat($(this).find('[name*="[price]"]').val()) || 0;
            const qty = parseFloat($(this).find('[name*="[stock_quantity]"]').val()) || 0;
            totalValue += price * qty;
        });
        $('#totalProductsValue').text(totalValue.toFixed(2));
    }

    // Form submission
    $('#addProductForm').submit(function(e){
        e.preventDefault();
        const formData = $(this).serialize();
        const submitBtn = $(this).find('button[type="submit"]');
        const originalText = submitBtn.html();

        submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Saving...');

        $.ajax({
            url:'{{ route("products.store") }}',
            method:'POST',
            data:formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success:function(response){
                submitBtn.prop('disabled', false).html(originalText);
                if(response.success){
                    alert('Products saved successfully!');
                    $('#addProductModal').modal('hide');
                    location.reload();
                }else{
                    alert(response.message || 'Error saving products');
                }
            },
            error:function(xhr){
                submitBtn.prop('disabled', false).html(originalText);
                alert(xhr.responseJSON?.message || 'An unexpected error occurred.');
            }
        });
    });

    // Reset modal on close
    $('#addProductModal').on('hidden.bs.modal',function(){
        $('#addProductForm')[0].reset();
        const firstRow = $('#productRowsContainer .product-row').first().clone();
        $('#productRowsContainer').html(firstRow);
        $('#productRowsContainer .product-row .addRow')
            .removeClass('btn-danger removeRow')
            .addClass('btn-success addRow')
            .html('<i class="fas fa-plus"></i>');
        productIndex = 1;
        updateSummary();
    });
});
</script>
@endpush

@push('styles')
<style>
.product-row{
    border-left:4px solid #17a2b8;
    padding:10px;
    border-radius:4px;
    transition:all 0.3s;
    margin-bottom:10px;
    background-color:#f9f9f9;
}
.product-row:hover{
    border-left-color:#28a745;
    box-shadow:0 4px 12px rgba(0,0,0,0.1);
}
.modal-header.bg-info {
    background-color: #17a2b8 !important;
    color:white;
}
#productRowsContainer .btn{
    width:100%;
}
</style>
@endpush


@endsection

@push('scripts')
<script>
$(document).ready(function(){
    // Delete confirmation
    window.confirmDelete = function(id) {
        if (confirm('Are you sure? This will delete the product permanently!')) {
            document.getElementById('delete-form-' + id).submit();
        }
    };

    let productIndex = 1;

    // Add new product row dynamically
    $(document).on('click', '.addRow', function(){
        const container = $('#productRowsContainer');
        const newRow = container.find('.product-row').first().clone();

        newRow.attr('data-index', productIndex);
        newRow.find('input').each(function(){
            const name = $(this).attr('name');
            const newName = name.replace(/\d+/, productIndex);
            $(this).attr('name', newName).val('');
            
            // Update checkbox ID
            if($(this).attr('type') === 'checkbox') {
                const newId = 'status' + productIndex;
                $(this).attr('id', newId);
                $(this).next('label').attr('for', newId);
            }
        });

        // Change add button to remove button
        newRow.find('.addRow')
              .removeClass('btn-success addRow')
              .addClass('btn-danger removeRow')
              .html('<i class="fas fa-trash"></i>')
              .attr('title','Remove Product');

        container.append(newRow);
        productIndex++;
        updateSummary();
    });

    // Remove product row
    $(document).on('click', '.removeRow', function(){
        $(this).closest('.product-row').remove();
        updateSummary();
    });

    // Update summary on input
    $(document).on('input','[name*="[price]"],[name*="[stock_quantity]"]',updateSummary);

    function updateSummary(){
        const totalRows = $('.product-row').length;
        $('#totalProductsCount').text(totalRows);

        let totalValue = 0;
        $('.product-row').each(function(){
            const price = parseFloat($(this).find('[name*="[price]"]').val()) || 0;
            const qty = parseFloat($(this).find('[name*="[stock_quantity]"]').val()) || 0;
            totalValue += price * qty;
        });
        $('#totalProductsValue').text(totalValue.toFixed(2));
    }

    // Form submission
    $('#addProductForm').submit(function(e){
        e.preventDefault();
        const formData = $(this).serialize();
        const submitBtn = $(this).find('button[type="submit"]');
        const originalText = submitBtn.html();
        
        submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Saving...');

        $.ajax({
            url:'{{ route("products.store") }}',
            method:'POST',
            data:formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success:function(response){
                submitBtn.prop('disabled', false).html(originalText);
                if(response.success){
                    alert('Products saved successfully!');
                    $('#addProductModal').modal('hide');
                    location.reload();
                }else{
                    alert(response.message || 'Error saving products');
                }
            },
            error:function(xhr){
                submitBtn.prop('disabled', false).html(originalText);
                alert(xhr.responseJSON?.message || 'An unexpected error occurred.');
            }
        });
    });

    // Reset modal
    $('#addProductModal').on('hidden.bs.modal',function(){
        $('#addProductForm')[0].reset();
        $('#productRowsContainer').html($('#productRowsContainer .product-row').first().clone());
        $('#productRowsContainer .product-row').attr('data-index',0);
        $('#productRowsContainer .product-row .addRow')
            .removeClass('btn-danger removeRow')
            .addClass('btn-success addRow')
            .html('<i class="fas fa-plus"></i>');
        productIndex = 1;
        updateSummary();
    });

    // Initialize DataTable
    $(function() {
        $('#example1').DataTable({
            "paging": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            "dom": '<"row"<"col-sm-12"tr>>',
        });
    });
});
</script>
@endpush

@push('styles')
<style>
.product-row{
    border-left:4px solid #007bff;
    padding:8px;
    transition:all 0.3s;
    margin-bottom:8px;
}
.product-row:hover{
    border-left-color:#28a745;
    box-shadow:0 2px 8px rgba(0,0,0,0.1);
}
.modal-header.bg-info {
    background-color: #17a2b8 !important;
}
.modal-header.bg-primary {
    background-color: #007bff !important;
}
.table th {
    background-color: #f8f9fa;
}
.btn-sm {
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
}
.badge {
    font-size: 0.85em;
    padding: 0.4em 0.6em;
}
</style>
@endpush