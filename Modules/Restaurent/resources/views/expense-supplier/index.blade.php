@extends('setting::layouts.master')
<meta name="csrf-token" content="{{ csrf_token() }}">
@section('title', 'Suppliers')
@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Suppliers</li>
    </ol>
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Suppliers</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Suppliers</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title float-right">
                                    <a class="btn btn-info text-white" data-toggle="modal" data-target="#supplierModal">
                                        <i class="fa fa-plus"></i> Add New Supplier
                                    </a>
                                </h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">

                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th class="text-center">S.N</th>
                                            <th class="text-center">Company Name</th>
                                            <th class="text-center">Supplier Name</th>
                                            <th class="text-center">Contact</th>
                                            <th class="text-center">Address</th>
                                            <th class="text-center">PAN/VAT</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($suppliers as $index => $supplier)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td class="text-center">{{ $supplier->company_name }}</td>
                                                <td class="text-center">{{ $supplier->supplier_name }}</td>
                                                <td class="text-center">{{ $supplier->contact }}</td>
                                                <td class="text-center">{{ Str::limit($supplier->address, 30) }}</td>
                                                <td class="text-center">{{ $supplier->pan_vat }}</td>
                                                <td class="text-center">
                                                    @if ($supplier->status === 'active')
                                                        <span class="badge badge-success">Active</span>
                                                    @else
                                                        <span class="badge badge-secondary">Inactive</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <!-- Edit Button with Modal -->
                                                    <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" 
                                                       data-target="#editSupplierModal{{ $supplier->id }}">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    
                                                    <!-- View Button -->
                                                    {{-- <a href="{{ route('suppliers.show', $supplier->id) }}" 
                                                       class="btn btn-success btn-sm">
                                                        <i class="fa fa-eye"></i>
                                                    </a> --}}
                                                    
                                                    <!-- Delete Button -->
                                                    <button id="delete" class="btn btn-danger btn-sm"
                                                        onclick="event.preventDefault();if (confirm('Are you sure? It will delete the data permanently!')) {document.getElementById('destroy{{ $supplier->id }}').submit()}">
                                                        <i class="fa fa-trash"></i>
                                                        <form id="destroy{{ $supplier->id }}" class="d-none"
                                                            action="{{ route('suppliers.delete', $supplier->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
                                                    </button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8" class="text-center">No suppliers found.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th class="text-center">S.N</th>
                                            <th class="text-center">Company Name</th>
                                            <th class="text-center">Supplier Name</th>
                                            <th class="text-center">Contact</th>
                                            <th class="text-center">Address</th>
                                            <th class="text-center">PAN/VAT</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </tfoot>
                                </table>

                                <!-- Pagination -->
                                {{-- @if ($suppliers->hasPages())
                                    <div class="d-flex justify-content-center mt-3">
                                        {{ $suppliers->withQueryString()->links() }}
                                    </div>
                                @endif --}}
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>

    <!-- Add Supplier Modal -->
    <div class="modal fade" id="supplierModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <form method="POST" action="{{ route('suppliers.store') }}">
                @csrf
                <div class="modal-content">
                    <div class="modal-header bg-info text-white">
                        <h5 class="modal-title">Add New Supplier</h5>
                        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Company Name</label>
                                <input type="text" name="company_name" class="form-control" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Supplier Name</label>
                                <input type="text" name="supplier_name" class="form-control" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Contact</label>
                                <input type="text" name="contact" class="form-control">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>PAN / VAT</label>
                                <input type="text" name="pan_vat" class="form-control">
                            </div>

                            <div class="col-md-12 mb-3">
                                <label>Address</label>
                                <textarea name="address" class="form-control" rows="3"></textarea>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Status</label>
                                <select name="status" class="form-control">
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-info">Save Supplier</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Supplier Modals -->
    @foreach($suppliers as $supplier)
    <div class="modal fade" id="editSupplierModal{{ $supplier->id }}" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <form method="POST" action="{{ route('suppliers.update', $supplier->id) }}">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">Edit Supplier</h5>
                        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Company Name</label>
                                <input type="text" name="company_name" class="form-control" 
                                       value="{{ $supplier->company_name }}" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Supplier Name</label>
                                <input type="text" name="supplier_name" class="form-control"
                                       value="{{ $supplier->supplier_name }}" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Contact</label>
                                <input type="text" name="contact" class="form-control"
                                       value="{{ $supplier->contact }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>PAN / VAT</label>
                                <input type="text" name="pan_vat" class="form-control"
                                       value="{{ $supplier->pan_vat }}">
                            </div>

                            <div class="col-md-12 mb-3">
                                <label>Address</label>
                                <textarea name="address" class="form-control" rows="3">{{ $supplier->address }}</textarea>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Status</label>
                                <select name="status" class="form-control">
                                    <option value="active" {{ $supplier->status == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ $supplier->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update Supplier</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @endforeach
@endsection

@push('scripts')
    <script>
        // Enable enter key for search
        document.getElementById('searchInput').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                document.getElementById('searchForm').submit();
            }
        });

        // Auto submit when status filter changes
        document.getElementById('statusFilter').addEventListener('change', function() {
            document.getElementById('searchForm').submit();
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
    </script>
@endpush

@push('styles')
    <style>
        .card {
            box-shadow: 0 0 1px rgba(0, 0, 0, .125), 0 1px 3px rgba(0, 0, 0, .2);
            margin-bottom: 1rem;
        }

        .badge {
            font-size: 0.85em;
            padding: 0.4em 0.6em;
        }

        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
            line-height: 1.5;
            border-radius: 0.2rem;
        }

        .table th {
            background-color: #f8f9fa;
        }

        /* Pagination Styles */
        .pagination {
            margin-bottom: 0;
        }
        
        .page-item.active .page-link {
            background-color: #17a2b8;
            border-color: #17a2b8;
        }
        
        .page-link {
            color: #17a2b8;
        }
        
        .page-link:hover {
            color: #117a8b;
        }
    </style>
@endpush