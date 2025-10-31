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
                                @can('create_expense')
                                    <h3 class="card-title float-right"><a class="btn btn-primary text-white" data-toggle="modal"
                                            data-target="#exampleModalCenter"><i class="fa fa-plus"></i> Create</a> </h3>
                                @endcan
                                @include('expenses::category.create')
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th class="text-center">S.N</th>
                                            <th class="text-center">Title</th>
                                            <th class="text-center">Branch</th>
                                            <th class="text-center">Icon</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($expenses as $key => $exp)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td class="text-center">{{ $exp->title }}</td>
                                                <td class="text-center">{{ $exp->branch->name }}</td>
                                                <td class="text-center">
                                                    <img src="{{ asset('upload/images/expenses-category/' . $exp->image) }}"
                                                        alt="" height="100px">
                                                </td>
                                                <td class="text-center">
                                                    @if ($exp->status == 'on')
                                                        <a href="{{ route('expenseCategory.status', $exp->id) }}"
                                                            class="btn btn-success">On</a>
                                                    @else
                                                        <a href="{{ route('expenseCategory.status', $exp->id) }}"
                                                            class="btn btn-danger">Off</a>
                                                    @endif
                                                </td>
                                                <td>
                                                    @can('edit_expense')
                                                        <a data-toggle="modal" data-target="#editCategory{{ $exp->id }}"
                                                            class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
                                                    @endcan
                                                    @include('expenses::category.edit')
                                                    @can('delete_expense')
                                                    <button id="delete" class="btn btn-danger btn-sm"
                                                        onclick="
        event.preventDefault();
        if (confirm('Are you sure? It will delete the data permanently!')) {
            document.getElementById('destroy{{ $exp->id }}').submit()
        }
        ">
                                                        <i class="fa fa-trash"></i>
                                                        <form id="destroy{{ $exp->id }}" class="d-none"
                                                            action="{{ route('expenses-categories.destroy', $exp->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('delete')
                                                        </form>
                                                    </button>
                                                    @endcan
                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th class="text-center">S.N</th>
                                            <th class="text-center">Title</th>
                                            <th class="text-center">Branch</th>
                                            <th class="text-center">Icon</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Status</th>
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
