@extends('setting::layouts.master')

@section('title', 'Categories')
@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Categories</li>
    </ol>
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Flash Messages -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle mr-2"></i> {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="text-primary"><i class="fas fa-tags mr-2"></i>Categories</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Categories</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-list mr-1"></i>
                                    Category List
                                </h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-success btn-sm" data-toggle="modal"
                                        data-target="#createCategoryModal">
                                        <i class="fas fa-plus-circle mr-1"></i> Create Category
                                    </button>
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="example1" class="table table-bordered table-hover table-striped">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th class="text-center">S.N</th>
                                                <th class="text-center">Category Name</th>
                                                <th class="text-center">Image</th>
                                                <th class="text-center">Description</th>
                                                <th class="text-center">Status</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($categories as $key => $category)
                                                <tr>
                                                    <td class="text-center align-middle">{{ $key + 1 }}</td>
                                                    <td class="text-center align-middle font-weight-bold">{{ $category->name }}</td>
                                                    <td class="text-center align-middle">
                                                        @if ($category->image)
                                                            <img src="{{ asset('upload/images/menu/' . $category->image) }}"
                                                                alt="Category Image" class="img-thumbnail" width="60" height="60">
                                                        @else
                                                            <span class="badge badge-secondary">No Image</span>
                                                        @endif
                                                    </td>
                                                    <td class="text-center align-middle">
                                                        {{ Str::limit($category->description, 50) }}
                                                    </td>
                                                    <td class="text-center align-middle">
                                                        @if ($category->status)
                                                            <span class="badge badge-success badge-pill">Active</span>
                                                        @else
                                                            <span class="badge badge-danger badge-pill">Inactive</span>
                                                        @endif
                                                    </td>
                                                    <td class="text-center align-middle">
                                                        <div class="btn-group" role="group">
                                                            <button type="button" class="btn btn-outline-primary btn-sm"
                                                                data-toggle="modal"
                                                                data-target="#editCategoryModal{{ $category->id }}">
                                                                <i class="fas fa-edit"></i>
                                                            </button>
                                                            <form action="{{ route('categories.destroy', $category->id) }}"
                                                                method="POST" class="d-inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-outline-danger btn-sm"
                                                                    onclick="return confirm('Are you sure you want to delete this category?')">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot class="thead-dark">
                                            <tr>
                                                <th class="text-center">S.N</th>
                                                <th class="text-center">Category Name</th>
                                                <th class="text-center">Image</th>
                                                <th class="text-center">Description</th>
                                                <th class="text-center">Status</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Create Category Modal -->
    <div class="modal fade" id="createCategoryModal" tabindex="-1" role="dialog"
        aria-labelledby="createCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="createCategoryModalLabel">
                        <i class="fas fa-plus-circle mr-2"></i>Create New Category
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="{{ route('categories.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="category-name" class="font-weight-bold">Category Name *</label>
                                    <input type="text" name="name" id="category-name"
                                        class="form-control @error('name') is-invalid @enderror" 
                                        value="{{ old('name') }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="category-status" class="font-weight-bold">Status *</label>
                                    <select name="status" id="category-status" 
                                        class="form-control @error('status') is-invalid @enderror" required>
                                        <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="category-image" class="font-weight-bold">Category Image</label>
                            <div class="custom-file">
                                <input type="file" name="image" id="category-image"
                                    class="custom-file-input @error('image') is-invalid @enderror">
                                <label class="custom-file-label" for="category-image">Choose file</label>
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <small class="form-text text-muted">Recommended size: 300x300 pixels</small>
                        </div>

                        <div class="form-group">
                            <label for="category-description" class="font-weight-bold">Description</label>
                            <textarea name="description" id="category-description" class="form-control @error('description') is-invalid @enderror" 
                                rows="4" placeholder="Optional description">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            <i class="fas fa-times mr-1"></i> Cancel
                        </button>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save mr-1"></i> Save Category
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Modals -->
    @foreach ($categories as $category)
        <div class="modal fade" id="editCategoryModal{{ $category->id }}" tabindex="-1" role="dialog"
            aria-labelledby="editCategoryModalLabel{{ $category->id }}" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="editCategoryModalLabel{{ $category->id }}">
                            <i class="fas fa-edit mr-2"></i>Edit Category
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="POST" action="{{ route('categories.update', $category->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="category-name-{{ $category->id }}" class="font-weight-bold">Category Name *</label>
                                        <input type="text" name="name" id="category-name-{{ $category->id }}"
                                            class="form-control @error('name') is-invalid @enderror" 
                                            value="{{ old('name', $category->name) }}" required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="category-status-{{ $category->id }}" class="font-weight-bold">Status *</label>
                                        <select name="status" id="category-status-{{ $category->id }}" 
                                            class="form-control @error('status') is-invalid @enderror" required>
                                            <option value="1" {{ old('status', $category->status) == '1' ? 'selected' : '' }}>Active</option>
                                            <option value="0" {{ old('status', $category->status) == '0' ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                        @error('status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="category-image-{{ $category->id }}" class="font-weight-bold">Category Image</label>
                                <div class="custom-file">
                                    <input type="file" name="image" id="category-image-{{ $category->id }}"
                                        class="custom-file-input @error('image') is-invalid @enderror">
                                    <label class="custom-file-label" for="category-image-{{ $category->id }}">Choose file</label>
                                    @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                @if ($category->image)
                                    <div class="mt-2">
                                        <p class="mb-1">Current Image:</p>
                                        <img src="{{ asset('upload/images/menu/' . $category->image) }}" 
                                            alt="Current Category Image" class="img-thumbnail" width="80" height="80">
                                    </div>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="category-description-{{ $category->id }}" class="font-weight-bold">Description</label>
                                <textarea name="description" id="category-description-{{ $category->id }}" 
                                    class="form-control @error('description') is-invalid @enderror" rows="4">{{ old('description', $category->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                <i class="fas fa-times mr-1"></i> Cancel
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save mr-1"></i> Update Category
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Initialize DataTable
            $('#categoriesTable').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "language": {
                    "emptyTable": "No categories found",
                    "zeroRecords": "No matching categories found"
                }
            });

            // Custom file input
            $('.custom-file-input').on('change', function() {
                let fileName = $(this).val().split('\\').pop();
                $(this).next('.custom-file-label').addClass("selected").html(fileName);
            });

            // Auto-dismiss alerts after 5 seconds
            setTimeout(function() {
                $('.alert').alert('close');
            }, 5000);
        });
    </script>
@endpush

@push('styles')
    <style>
        .card-primary.card-outline {
            border-top: 3px solid #007bff;
        }
        .table th {
            border-top: none;
        }
        .img-thumbnail {
            border-radius: 8px;
            object-fit: cover;
        }
        .badge-pill {
            padding: 0.5em 0.8em;
        }
        .btn-group .btn {
            border-radius: 4px;
            margin: 0 2px;
        }
    </style>
@endpush