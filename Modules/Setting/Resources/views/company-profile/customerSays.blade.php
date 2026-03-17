@extends('setting::layouts.master')

@section('title', 'Customer Says')

@section('content')
<div class="content-wrapper">

    <!-- Page Header -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Customer Says</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Customer Says</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Table Section -->
    <section class="content">
        <div class="container-fluid">

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title float-right">
                        <a class="btn btn-info text-white" data-toggle="modal" data-target="#createModal">
                            <i class="fa fa-plus"></i> Create
                        </a>
                    </h3>
                </div>

                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>S.N</th>
                            <th>Name</th>
                            <th>Working</th>
                            <th>Description</th>
                            <th>Image</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach ($customerSays as $value)
                            <tr>
                                <td>{{ $loop->iteration }}</td>

                                <td>{{ $value->name }}</td>
                                <td>{{ $value->working }}</td>
                                <td style="max-width: 250px;">{{ $value->description }}</td>

                                <td>
                                    <img src="{{ asset('upload/customer_says/'.$value->image) }}"
                                         height="80" width="80"
                                         style="object-fit: cover;"
                                         class="rounded">
                                </td>

                                <td class="text-center">
                                    @if ($value->status == 'on')
                                        <a href="#"
                                           class="btn btn-success">On</a>
                                    @else
                                        <a href="#"
                                           class="btn btn-danger">Off</a>
                                    @endif
                                </td>

                                <td class="text-center">

                                    <!-- Edit Button -->
                                    <a class="btn btn-info text-white"
                                       data-toggle="modal"
                                       data-target="#editModal{{ $value->id }}">
                                        <i class="fa fa-edit"></i> Edit
                                    </a>

                                    <!-- Edit Modal -->
                                    <div class="modal fade" id="editModal{{ $value->id }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">

                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Customer Says</h5>
                                                    <button type="button" class="close" data-dismiss="modal">
                                                        <span>&times;</span>
                                                    </button>
                                                </div>

                                                <form action="{{ route('customerSays.update', $value->id) }}"
                                                      method="post" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('put')
                                                    <div class="modal-body">

                                                        <div class="form-group">
                                                            <label>Name</label>
                                                            <input type="text" name="name" class="form-control"
                                                                   value="{{ $value->name }}" required>
                                                        </div>

                                                        <div class="form-group">
                                                            <label>Working</label>
                                                            <input type="text" name="working" class="form-control"
                                                                   value="{{ $value->working }}" required>
                                                        </div>

                                                        <div class="form-group">
                                                            <label>Description</label>
                                                            <textarea name="description" rows="3" required class="form-control">{{ $value->description }}</textarea>
                                                        </div>

                                                        <div class="form-group">
                                                            <label>Image</label>
                                                            <input type="file" name="image" class="form-control">
                                                            <img src="{{ asset('upload/customer_says/'.$value->image) }}"
                                                                 height="80" class="mt-2 rounded">
                                                        </div>

                                                    </div>

                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Save changes</button>
                                                    </div>
                                                </form>

                                            </div>
                                        </div>
                                    </div>

                                    <!-- Delete -->
                                    <a href="{{ route('customerSays.delete', $value->id) }}"
                                       onclick="return confirm('Are you sure?')"
                                       class="btn btn-danger text-white">
                                        <i class="fa fa-trash"></i> Delete
                                    </a>

                                </td>

                            </tr>
                        @endforeach
                        </tbody>

                    </table>
                </div>
            </div>

        </div>
    </section>
</div>

<!-- Create Modal -->
<div class="modal fade" id="createModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Create Customer Says</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>

            <form action="{{ route('customerSays.store') }}" method="post" enctype="multipart/form-data">
                @csrf

                <div class="modal-body">

                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="name" required class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Working</label>
                        <input type="text" name="working" required class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="description" rows="3" required class="form-control"></textarea>
                    </div>

                    <div class="form-group">
                        <label>Image</label>
                        <input type="file" name="image" required class="form-control">
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary">Save</button>
                </div>

            </form>

        </div>
    </div>
</div>

@endsection
