@extends('setting::layouts.master')

@section('title', 'Technical Tools')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Technical Tools</li>
    </ol>
@endsection

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Technical Tools</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Technical Tools</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">

                        <div class="card">
                            <div class="card-header">
                                {{-- @can('create_product') --}}
                                <div class="card-header">
                                    <h3 class="card-title float-right"><a class="btn btn-primary text-white"
                                            data-toggle="modal" data-target="#createTechnicalToolModal"><i
                                                class="fa fa-plus"></i>
                                            Create</a> </h3>
                                    @include('product::technicaltools.create')
                                </div>
                                {{-- @endcan --}}
                            </div>

                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th class="text-center">S.N</th>
                                            <th class="text-center">Tool Name</th>
                                            <th class="text-center">Model</th>
                                            <th class="text-center">Image</th>
                                            <th class="text-center">Price</th>
                                            <th class="text-center">Stock</th>
                                            <th class="text-center">Description</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Date</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($technicalTools as $key => $tool)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td class="text-center">{{ $tool->tool_name }}</td>
                                                <td class="text-center">{{ $tool->model_name }}</td>
                                                <td class="text-center"><img
                                                        src="{{ asset('upload/images/technicaltools/' . $tool->image) }}"
                                                        width="120px" alt="{{ $tool->name }}"> </td>
                                                <td class="text-center">{{ number_format($tool->price, 2) }}</td>
                                                <td class="text-center">{{ $tool->stock }}</td>
                                                <td class="text-center">{{ $tool->description }}</td>
                                                <td class="text-center">
                                                    @if ($tool->status == 'on')
                                                        <a href="{{ route('technicaltools.status', $tool->id) }}"
                                                            class="btn btn-success">On</a>
                                                    @else
                                                        <a href="{{ route('technicaltools.status', $tool->id) }}"
                                                            class="btn btn-danger">Off</a>
                                                    @endif
                                                </td>
                                                <td class="text-center">{{ $tool->created_at }}</td>
                                                <td class="text-center">
                                                    @can('edit_product')
                                                        <a href="{{ route('technicaltools.edit', $tool->id) }}"
                                                            class="btn btn-primary btn-sm">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                    @endcan
                                                    @can('delete_product')
                                                        <button class="btn btn-danger btn-sm"
                                                            onclick="event.preventDefault(); if (confirm('Are you sure? It will delete the data permanently!')) { document.getElementById('delete-form-{{ $tool->id }}').submit(); }">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                        <form id="delete-form-{{ $tool->id }}"
                                                            action="{{ route('technicaltools.destroy', $tool->id) }}"
                                                            method="POST" class="d-none">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
                                                    @endcan
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th class="text-center">S.N</th>
                                            <th class="text-center">Tool Name</th>
                                            <th class="text-center">Model</th>
                                            <th class="text-center">Image</th>
                                            <th class="text-center">Price</th>
                                            <th class="text-center">Stock</th>
                                            <th class="text-center">Description</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Date</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
