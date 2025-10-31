@extends('setting::layouts.master')

@section('title', 'Users')

@section('third_party_stylesheets')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
@endsection

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Users</li>
    </ol>
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title float-right"><a class="btn btn-info text-white"
                                        href="{{ route('users.create') }}"><i class="fa fa-plus"></i> Create</a> </h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>S.N</th>
                                            <th>Name</th>
                                            <th class="text-center">Image</th>
                                            <th>Email</th>
                                            <th>Role</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $key => $value)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $value->name }}</td>
                                                <td class="text-center">
                                                    @if(!$value->image)
                                                    <img src="{{ asset('upload/images/users/profile.webp')}}"
                                                        width="120px" alt="{{ $value->name }}">
                                                    @else
                                                    <img src="{{ asset('upload/images/users/' . $value->image) }}"
                                                        width="120px" alt="{{ $value->name }}">
                                                        @endif
                                                </td>
                                                <td>{{ $value->email }}</td>
                                                <td>{{ $value->role->name ?? 'N/A'}}</td>
                                                <td class="text-center">
                                                    @if ($value->hasRole('Super Admin'))
                                                        <a class="btn btn-success">On</a>
                                                    @else
                                                        @if ($value->status == 'on')
                                                            <a href="{{ route('user.status', $value->id) }}"
                                                                class="btn btn-success">On</a>
                                                        @else
                                                            <a href="{{ route('user.status', $value->id) }}"
                                                                class="btn btn-danger">Off</a>
                                                        @endif
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    @if ($value->hasRole('Super Admin'))
                                                    No Access!!
                                                    @else
                                                    <a href="{{ route('users.edit', $value->id) }}"
                                                        class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
                                                    {{-- <a href="{{ route('users.show',$value->id) }}" class="btn btn-success btn-sm"><i class="fa fa-eye"></i></a> --}}
                                                    <button id="delete" class="btn btn-danger btn-sm"
                                                        onclick="
                                event.preventDefault();
                                if (confirm('Are you sure? It will delete the data permanently!')) {
                                    document.getElementById('destroy{{ $value->id }}').submit()
                                }
                                ">
                                                        <i class="fa fa-trash"></i>
                                                        <form id="destroy{{ $value->id }}" class="d-none"
                                                            action="{{ route('users.destroy', $value->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('delete')
                                                        </form>
                                                    </button>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>S.N</th>
                                            <th>Name</th>
                                            <th class="text-center">Image</th>
                                            <th>Email</th>
                                            <th>Role</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
