@extends('setting::layouts.master')

@section('title', 'Office Register')
@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Office Register</li>
    </ol>
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Office Register</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Office Register</li>
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
                                        data-target="#exampleModalCenter"><i class="fa fa-plus"></i> Register</a> </h3>
                                @include('restaurent::offices.create')

                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th class="text-center">S.N</th>
                                            <th class="text-center">Name</th>
                                            <th class="text-center">Contact</th>
                                            <th class="text-center">QR Code</th>
                                            <th class="text-center">Location</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Action</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($offices as $key => $office)
                                            @php
                                                $url = route('office.order', [
                                                    'id' => $office->id,
                                                    'resturant_id' => auth()->user()->restaurent_id, // Parameter name with 'e' to match route
                                                ]);
                                            @endphp
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td class="text-center">{{ $office->name }}</td>
                                                <td class="text-center">{{ $office->contact_numbers }}</td>
                                                <td class="text-center">{!! QrCode::size(100)->generate($url) !!}</td>
                                                <td class="text-center">{{ $office->address }}</td>
                                                <td class="text-center">{{ $office->status }}</td>
                                                <td>

                                                    @include('restaurent::offices.edit')
                                                    <a href="{{ route('offices.show', $office->id) }}"
                                                        class="btn btn-success btn-sm"><i class="fa fa-eye"></i></a>
                                                    <button id="delete" class="btn btn-danger btn-sm"
                                                        onclick="event.preventDefault();if (confirm('Are you sure? It will delete the data permanently!')) {document.getElementById('destroy{{ $office->id }}').submit()}">
                                                        <i class="fa fa-trash"></i>
                                                        <form id="destroy{{ $office->id }}" class="d-none"
                                                            action="{{ route('offices.destroy', $office->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('delete')
                                                        </form>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th class="text-center">S.N</th>
                                            <th class="text-center">Name</th>
                                            <th class="text-center">Contact</th>
                                            <th class="text-center">QR Code</th>
                                            <th class="text-center">Location</th>
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
