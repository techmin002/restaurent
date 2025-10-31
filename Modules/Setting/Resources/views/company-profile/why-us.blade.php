@extends('setting::layouts.master')

@section('title', 'Why Us')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
            <section class="content-header">
              <div class="container-fluid">
                <div class="row mb-2">
                  <div class="col-sm-6">
                    <h1>Why Us</h1>
                  </div>
                  <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                      <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                      <li class="breadcrumb-item active">Why Us</li>
                    </ol>
                  </div>
                </div>
              </div><!-- /.container-fluid -->
            </section>
        <section class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title float-right"><a class="btn btn-info text-white" type="button" data-toggle="modal" data-target="#exampleModal"
                                        ><i class="fa fa-plus"></i> Create</a> </h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>S.N</th>
                                            <th>Title</th>
                                            <th>Icon</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($whyus as $key => $value)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $value->name }}</td>
                                                <td><img src="{{ asset('upload/images/whyus/'.$value->icon) }}" height="80px" alt=""></td>
                                                <td class="text-center">
                                                    @if ($value->status == 'on')
                                                        <a href="{{ route('faq.status', $value->id) }}"
                                                            class="btn btn-success">On</a>
                                                    @else
                                                        <a href="{{ route('faq.status', $value->id) }}"
                                                            class="btn btn-danger">Off</a>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a class="btn btn-info text-white" type="button" data-toggle="modal" data-target="#editModal{{ $value->id }}"
                                        ><i class="fa fa-edit"></i> Edit</a>
                                        <div class="modal fade" id="editModal{{ $value->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                              <div class="modal-content">
                                                <div class="modal-header">
                                                  <h5 class="modal-title" id="exampleModalLabel">Edit Why Us</h5>
                                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                  </button>
                                                </div>
                                                <form action="{{ route('whyus.update',$value->id) }}" method="post" enctype="multipart/form-data">
                                                  @method('put')
                                                    @csrf
                                                <div class="modal-body">
                                                    
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <label for="title">Title</label>
                                                                <input type="text" name="title" value="{{ $value->name }}" id="title" required class="form-control" placeholder="Enter Title">
                                                            </div>
                                                            <div class="col-md-12">
                                                                <label for="icon">Icon</label>
                                                                <input type="file" name="icon" id="icon" class="form-control">
                                                            </div>
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
                                                    {{-- <a href="{{ route('whyus.show',$value->id) }}" class="btn btn-success btn-sm"><i class="fa fa-eye"></i></a> --}}
                                                    <a href="{{ route('whyus.delete',$value->id) }}" onclick="return confirm('Are you sure? You Want To Delete.')" class="btn btn-danger text-white"><i class="fa fa-trash"></i> Delete</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>S.N</th>
                                            <th>Title</th>
                                            <th>Icon</th>
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
    {{-- create whys us modal  --}}
  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Create Why Us</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ route('whyus.store') }}" method="post" enctype="multipart/form-data">
            @csrf
        <div class="modal-body">
            
                <div class="row">
                    <div class="col-md-12">
                        <label for="title">Title</label>
                        <input type="text" name="title" id="title" required class="form-control" placeholder="Enter Title">
                    </div>
                    <div class="col-md-12">
                        <label for="icon">Icon</label>
                        <input type="file" name="icon" id="icon" class="form-control">
                    </div>
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

  
@endsection