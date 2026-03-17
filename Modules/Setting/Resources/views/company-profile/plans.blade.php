@extends('setting::layouts.master')

@section('title', 'Plans')

@section('content')
<div class="content-wrapper">

    <!-- Page Header -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Plans</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Plans</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Table + Create Button -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    <!-- Card -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title float-right">
                                <button class="btn btn-info text-white" data-toggle="modal" data-target="#createPlanModal">
                                    <i class="fa fa-plus"></i> Create
                                </button>
                            </h3>
                        </div>

                        <div class="card-body">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Title</th>
                                        <th>Big Title</th>
                                        <th>Days</th>
                                        <th>Image</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach($plans as $plan)
                                    <tr>
                                        <td>{{ $plan->id }}</td>
                                        <td>{{ $plan->title }}</td>
                                        <td>{{ $plan->bigtitle }}</td>
                                        <td>{{ $plan->days }}</td>
                                        <td>
                                            @if($plan->image)
                                                <img src="{{ asset('upload/images/plans/'.$plan->image) }}" width="50" alt="Plan Image">
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <!-- Edit Button -->
                                            <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editPlanModal{{ $plan->id }}">
                                                Edit
                                            </button>

                                            <!-- Delete Form -->
                                            <form action="{{ route('plans.delete', $plan->id) }}" method="POST" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>

                                    <!-- Edit Modal -->
                                    <div class="modal fade" id="editPlanModal{{ $plan->id }}" tabindex="-1" aria-labelledby="editPlanModalLabel{{ $plan->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <form action="{{ route('plans.update', $plan->id) }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editPlanModalLabel{{ $plan->id }}">Edit Plan</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-6 mb-3">
                                                                <label>Title</label>
                                                                <input type="text" name="title" class="form-control" value="{{ $plan->title }}">
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label>Big Title</label>
                                                                <input type="text" name="bigtitle" class="form-control" value="{{ $plan->bigtitle }}">
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label>Days</label>
                                                                <input type="text" name="days" class="form-control" value="{{ $plan->days }}">
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label>Image</label>
                                                                <input type="file" name="image" class="form-control">
                                                            </div>

                                                            <!-- Optional Data Fields -->
                                                            @for($i=1; $i<=10; $i++)
                                                            <div class="col-md-6 mb-3">
                                                                <label>Data {{ $i }}</label>
                                                                <input type="text" name="data{{ $i }}" class="form-control" value="{{ $plan->{'data'.$i} }}">
                                                            </div>
                                                            @endfor
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-success">Update Plan</button>
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    @endforeach
                                </tbody>

                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
</div>

<!-- Create Modal -->
<div class="modal fade" id="createPlanModal" tabindex="-1" aria-labelledby="createPlanModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('plans.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createPlanModalLabel">Create Plan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Title</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Big Title</label>
                            <input type="text" name="bigtitle" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Days</label>
                            <input type="text" name="days" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Image</label>
                            <input type="file" name="image" class="form-control">
                        </div>

                        @for($i=1; $i<=10; $i++)
                        <div class="col-md-6 mb-3">
                            <label>Data {{ $i }}</label>
                            <input type="text" name="data{{ $i }}" class="form-control">
                        </div>
                        @endfor
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save Plan</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection
