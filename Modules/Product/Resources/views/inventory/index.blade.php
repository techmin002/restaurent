@extends('setting::layouts.master')

@section('title', 'Inventories')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Inventories</li>
    </ol>
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Inventories</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Inventories</li>
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
                                @can('create_inventory')
                                    <h3 class="card-title float-right">
                                        <a class="btn btn-info text-white" href="{{ route('inventories.create') }}"><i
                                                class="fa fa-plus"></i> Add Inventory</a>
                                    </h3>
                                    </h3>
                                @endcan
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>S.N</th>
                                            <th>Name</th>
                                            <th class="text-center">Image</th>
                                            <th class="text-center">Price</th>
                                            <th class="text-center">Brand</th>
                                            <th class="text-center">Category</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($inventories as $key => $value)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $value->name }}</td>
                                                <td class="text-center"><img
                                                        src="{{ asset('upload/images/machinery/' . $value->image) }}"
                                                        width="120px" alt="{{ $value->name }}"> </td>
                                                <td>{{ $value->sales_price }}</td>
                                                <td>
                                                    @php
                                                        $brand = Modules\Product\Entities\Brand::find($value->brand_id);
                                                        $category = Modules\Product\Entities\ProductCategory::find(
                                                            $value->category_id,
                                                        );
                                                    @endphp
                                                    {{ $brand->name }}
                                                </td>
                                                <td>{{ $category->name }}</td>
                                                <td class="text-center">
                                                    @if ($value->status == 'on')
                                                        <a href="{{ route('product-machinery.status', $value->id) }}"
                                                            class="btn btn-success">On</a>
                                                    @else
                                                        <a href="{{ route('product-machinery.status', $value->id) }}"
                                                            class="btn btn-danger">Off</a>
                                                    @endif
                                                </td>
                                                <td>
                                                    @can('edit_inventory')
                                                        <a href="{{ route('products-machineries.edit', $value->id) }}"
                                                            class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
                                                    @endcan
                                                    @can('delete_inventory')
                                                        <button id="delete" class="btn btn-danger btn-sm"
                                                            onclick="
                                event.preventDefault();
                                if (confirm('Are you sure? It will delete the data permanently!')) {
                                    document.getElementById('destroy{{ $value->id }}').submit()
                                }
                                ">
                                                            <i class="fa fa-trash"></i>
                                                            <form id="destroy{{ $value->id }}" class="d-none"
                                                                action="{{ route('products-machineries.destroy', $value->id) }}"
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
                                            <th>S.N</th>
                                            <th>Name</th>
                                            <th class="text-center">Image</th>
                                            <th class="text-center">Price</th>
                                            <th class="text-center">Brand</th>
                                            <th class="text-center">Category</th>
                                            <th class="text-center">Status</th>
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
