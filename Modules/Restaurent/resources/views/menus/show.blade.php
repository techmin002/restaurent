@extends('setting::layouts.master')

@section('title', 'Item Details')
@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Item Details</li>
    </ol>
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Item Details</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Item Details</li>
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
                                <div class="row">
                                    <div class="col-6">
                                    <h3 class="card-title float-left"><a class="btn btn-secondary text-white">Item:  {{ $menu['name'] }}</a> </h3>

                                    </div>
                                    <div class="col-6">
                                    <h3 class="card-title float-right"><a href="{{ route('menus.index') }}" class="btn btn-info text-white">Go Back</a> </h3>

                                    </div>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th class="text-center">S.N</th>
                                            <th class="text-center">Variation</th>
                                            <th class="text-center">Price</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($menu->variations as $key => $menu)

                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>

                                                 <td class="text-center">{{ $menu->name }}</td>
                                                <td class="text-center">{{ $menu->price }}</td>

                                            </tr>
                                        @endforeach

                                    </tbody>
                                    <tfoot>
                                        <tr>
                                           <th class="text-center">S.N</th>
                                            <th class="text-center">Variation</th>
                                            <th class="text-center">Price</th>
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
