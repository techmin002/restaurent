@extends('setting::layouts.master')

@section('title', 'Expenses')
@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Expenses</li>
    </ol>
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Expenses</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Expenses</li>
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
                        <!-- /.card -->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title float-right"><a class="btn btn-info text-white" data-toggle="modal"
                                        data-target="#exampleModalCenter"><i class="fa fa-plus"></i> Create</a> </h3>

                                @include('expenses::expenses.create')
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th class="text-center">S.N</th>
                                            <th class="text-center">Title</th>
                                            <th class="text-center">Amount</th>
                                            <th class="text-center">Date</th>
                                            <th class="text-center">Mode</th>
                                            <th class="text-center">Expense Type</th>
                                            <th class="text-center">Receipt</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($expenses as $expense)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td class="text-center">{{ $expense->title }}</td>
                                                <td class="text-center">{{ $expense->amount }}</td>
                                                <td class="text-center">{{ $expense->date }}</td>
                                                <td class="text-center">{{ $expense->mode }}</td>
                                                <td class="text-center">{{ $expense->category->title ?? 'N/A' }}</td>
                                                <td class="text-center">
                                                    @if ($expense->receipt)
                                                        <a href="{{ asset('upload/images/expenses-receipt/' . $expense->receipt) }}" target="_blank">
                                                            <img class="img-thumbnail" height="100px" width="100px" src="{{ asset('upload/images/expenses-receipt/' . $expense->receipt) }}" alt="">
                                                        </a>
                                                    @else
                                                        N/A
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <!-- Edit icon with route to edit page -->
                                                    <a href="{{ route('expenses.edit', $expense->id) }}" 
                                                       class="btn btn-info btn-sm" 
                                                       title="Edit">
                                                        <i class="fa fa-edit"></i>
                                                    </a>

                                                    <form action="{{ route('expenses.destroy', $expense->id) }}" method="POST" style="display: inline-block;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm"
                                                            onclick="return confirm('Are you sure you want to delete this expense?');"
                                                            title="Delete">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    </form>

                                                    <a href="{{ route('expenses.show', $expense->id) }}" 
                                                       class="btn btn-primary btn-sm" 
                                                       title="View">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8" class="text-center">No Expenses Found</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th class="text-center">S.N</th>
                                            <th class="text-center">Title</th>
                                            <th class="text-center">Amount</th>
                                            <th class="text-center">Date</th>
                                            <th class="text-center">Mode</th>
                                            <th class="text-center">Expense Type</th>
                                            <th class="text-center">Receipt</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </tfoot>
                                </table>
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