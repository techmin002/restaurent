<!-- expenses::expenses.edit.blade.php -->
@extends('setting::layouts.master')

@section('title', 'Edit Expense')
@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('expenses.index') }}">Expenses</a></li>
        <li class="breadcrumb-item active">Edit Expense</li>
    </ol>
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Edit Expense</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('expenses.index') }}">Expenses</a></li>
                            <li class="breadcrumb-item active">Edit Expense</li>
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
                                <h3 class="card-title">Edit Expense Details</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <form action="{{ route('expenses.update', $expense->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="title">Title <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="title" name="title" 
                                                       value="{{ old('title', $expense->title) }}" required>
                                                @error('title')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="amount">Amount (INR) <span class="text-danger">*</span></label>
                                                <input type="number" step="0.01" class="form-control" id="amount" name="amount" 
                                                       value="{{ old('amount', $expense->amount) }}" required>
                                                @error('amount')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="date">Date <span class="text-danger">*</span></label>
                                                <input type="date" class="form-control" id="date" name="date" 
                                                       value="{{ old('date', $expense->date) }}" required>
                                                @error('date')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="mode">Mode of Payment <span class="text-danger">*</span></label>
                                                <select class="form-control" id="mode" name="mode" required>
                                                    <option value="">Select Payment Mode</option>
                                                    <option value="petty cash" {{ old('mode', $expense->mode) == 'petty cash' ? 'selected' : '' }}>Petty Cash</option>
                                                    <option value="online" {{ old('mode', $expense->mode) == 'online' ? 'selected' : '' }}>Online</option>
                                                    <option value="cheque" {{ old('mode', $expense->mode) == 'cheque' ? 'selected' : '' }}>Cheque</option>
                                                </select>
                                                @error('mode')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="categoryId">Expense Type <span class="text-danger">*</span></label>
                                                <select class="form-control" id="categoryId" name="categoryId" required>
                                                    <option value="">Select Category</option>
                                                    @foreach ($categories as $cat)
                                                        <option value="{{ $cat->id }}" {{ old('categoryId', $expense->expense_category_id ?? $expense->category_id) == $cat->id ? 'selected' : '' }}>
                                                            {{ $cat->title }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('categoryId')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="branchId">Supplier <span class="text-danger">*</span></label>
                                                <select class="form-control" id="branchId" name="branchId" required>
                                                    <option value="">Select Supplier</option>
                                                    @foreach ($branches as $branch)
                                                        <option value="{{ $branch->id }}" {{ old('branchId', $expense->branch_id) == $branch->id ? 'selected' : '' }}>
                                                            {{ $branch->company_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('branchId')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="receipt">Receipt (Optional)</label>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="receipt" name="receipt" accept="image/*,.pdf">
                                                    <label class="custom-file-label" for="receipt">
                                                        @if($expense->receipt)
                                                            {{ $expense->receipt }} (Current file)
                                                        @else
                                                            Choose file
                                                        @endif
                                                    </label>
                                                </div>
                                                @if($expense->receipt)
                                                    <small class="form-text text-muted">
                                                        Current file: 
                                                        <a href="{{ asset('upload/images/expenses-receipt/' . $expense->receipt) }}" target="_blank">
                                                            View receipt
                                                        </a>
                                                    </small>
                                                @endif
                                                @error('receipt')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="description">Description (Optional)</label>
                                                <textarea class="form-control" id="description" name="description" rows="3">{{ old('description', $expense->description) }}</textarea>
                                                @error('description')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Update Expense</button>
                                        <a href="{{ route('expenses.index') }}" class="btn btn-secondary">Cancel</a>
                                    </div>
                                </form>
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
@endsection

@push('scripts')
<script>
    // Initialize file input
    $(document).ready(function() {
        bsCustomFileInput.init();
    });
</script>
@endpush