@extends('setting::layouts.master')

@section('title', 'Interfaces')

@section('content')
<div class="content-wrapper">

    <!-- Page Header -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Interfaces</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Interfaces</li>
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
                                <th>Image</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($Interfaces as $value)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>

                                    <td>
                                        <img src="{{ asset('upload/images/interfaces/'.$value->image) }}"
                                             height="80" width="80"
                                             style="object-fit: cover;" class="rounded">
                                    </td>

                                    <td class="text-center">

                                        <!-- Edit Button -->
                                        <a class="btn btn-info text-white"
                                           data-toggle="modal"
                                           data-target="#editModal{{ $value->id }}">
                                            <i class="fa fa-edit"></i> Edit
                                        </a>

                                        <!-- Delete Button -->
                                        <a href="{{ route('interfaces.delete', $value->id) }}"
                                           onclick="return confirm('Are you sure you want to delete?')"
                                           class="btn btn-danger text-white">
                                            <i class="fa fa-trash"></i> Delete
                                        </a>

                                    </td>
                                </tr>

                                <!-- Edit Modal -->
                                <div class="modal fade" id="editModal{{ $value->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">

                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit Interface Image</h5>
                                                <button type="button" class="close" data-dismiss="modal">
                                                    <span>&times;</span>
                                                </button>
                                            </div>

                                            <form action="{{ route('interfaces.update', $value->id) }}"
                                                  method="POST" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')

                                                <div class="modal-body">

                                                    <div class="form-group">
                                                        <label>Change Image</label>
                                                        <input type="file" name="image"
                                                               class="form-control">
                                                    </div>

                                                    <img src="{{ asset('upload/images/interfaces/'.$value->image) }}"
                                                         height="100" class="mt-2 rounded">

                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                                </div>

                                            </form>

                                        </div>
                                    </div>
                                </div>

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
                <h5 class="modal-title">Create Interface</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <form action="{{ route('interfaces.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="modal-body">

                    <div class="form-group">
                        <label>Select Image</label>
                        <input type="file" name="image" required class="form-control">
                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary">Save</button>
                </div>

            </form>

        </div>
    </div>
</div>

@endsection
