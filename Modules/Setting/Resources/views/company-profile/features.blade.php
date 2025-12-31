@extends('setting::layouts.master')

@section('title', 'Features')

@section('content')
<div class="content-wrapper">

    <!-- Page Header -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Features</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Features</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Table + Create Button -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title float-right">
                                <a class="btn btn-info text-white" data-toggle="modal" data-target="#createFeatureModal">
                                    <i class="fa fa-plus"></i> Create
                                </a>
                            </h3>
                        </div>

                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>S.N</th>
                                        <th>Title</th>
                                        <th>Image</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach($features as $value)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $value->title }}</td>
                                            <td>
                                                <img src="{{ asset('upload/images/features/'.$value->image) }}" height="80px">
                                            </td>
                                            <td class="text-center">

                                                <!-- Edit Button -->
                                                <a class="btn btn-info text-white"
                                                   data-toggle="modal"
                                                   data-target="#editFeatureModal{{ $value->id }}">
                                                    <i class="fa fa-edit"></i> Edit
                                                </a>

                                                <!-- Delete Button -->
                                                <a href="{{ route('features.delete', $value->id) }}"
                                                   onclick="return confirm('Are you sure? You Want To Delete.')"
                                                   class="btn btn-danger text-white">
                                                    <i class="fa fa-trash"></i> Delete
                                                </a>
                                            </td>
                                        </tr>

                                        <!-- Edit Modal -->
                                        <div class="modal fade" id="editFeatureModal{{ $value->id }}">
                                            <div class="modal-dialog">
                                                <div class="modal-content">

                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Edit Feature</h5>
                                                        <button type="button" class="close" data-dismiss="modal">
                                                            <span>&times;</span>
                                                        </button>
                                                    </div>

                                                    <form action="{{ route('features.update', $value->id) }}"
                                                          method="POST"
                                                          enctype="multipart/form-data">
                                                        @csrf
                                                        @method('PUT')

                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <label>Title</label>
                                                                    <input type="text"
                                                                           name="title"
                                                                           value="{{ $value->title }}"
                                                                           class="form-control"
                                                                           required>
                                                                </div>

                                                                <div class="col-md-12 mt-3">
                                                                    <label>Image</label>
                                                                    <input type="file"
                                                                           name="image"
                                                                           class="form-control">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="button"
                                                                    class="btn btn-secondary"
                                                                    data-dismiss="modal">Close</button>
                                                            <button type="submit"
                                                                    class="btn btn-primary">Save changes</button>
                                                        </div>
                                                    </form>

                                                </div>
                                            </div>
                                        </div>

                                    @endforeach
                                </tbody>

                                <tfoot>
                                    <tr>
                                        <th>S.N</th>
                                        <th>Title</th>
                                        <th>Image</th>
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

<!-- Create Modal -->
<div class="modal fade" id="createFeatureModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Create Feature</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <form action="{{ route('features.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="modal-body">
                    <div class="row">

                        <div class="col-md-12">
                            <label>Title</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>

                        <div class="col-md-12 mt-3">
                            <label>Image</label>
                            <input type="file" name="image" class="form-control">
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button"
                            class="btn btn-secondary"
                            data-dismiss="modal">Close</button>
                    <button type="submit"
                            class="btn btn-primary">Save changes</button>
                </div>

            </form>

        </div>
    </div>
</div>

@endsection
