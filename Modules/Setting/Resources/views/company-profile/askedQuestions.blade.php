@extends('setting::layouts.master')

@section('title', 'Asked Questions')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Asked Questions</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
              <li class="breadcrumb-item active">Asked Questions</li>
            </ol>
          </div>
        </div>
      </div>
    </section>

    <!-- Table Section -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title float-right">
                  <a class="btn btn-info text-white" type="button" data-toggle="modal" data-target="#createQuestionModal">
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
                      <th>Subtitle</th>
                      <th class="text-center">Status</th>
                      <th class="text-center">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($askedQuestions as $key => $question)
                    <tr>
                      <td>{{ $loop->iteration }}</td>
                      <td>{{ $question->title }}</td>
                      <td>{{ $question->subtitle }}</td>
                      <td class="text-center">
                        @if ($question->status == 'on')
                          <a href="#" class="btn btn-success">On</a>
                        @else
                          <a href="#" class="btn btn-danger">Off</a>
                        @endif
                      </td>
                      <td class="text-center">
                        <a class="btn btn-info text-white" type="button" data-toggle="modal" data-target="#editQuestionModal{{ $question->id }}">
                          <i class="fa fa-edit"></i> Edit
                        </a>

                        <!-- Edit Modal -->
                        <div class="modal fade" id="editQuestionModal{{ $question->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title">Edit Asked Question</h5>
                                <button type="button" class="close" data-dismiss="modal">
                                  <span>&times;</span>
                                </button>
                              </div>
                              <form action="{{ route('askedQuestions.update', $question->id) }}" method="post">
                                @method('put')
                                @csrf
                                <div class="modal-body">
                                  <div class="form-group">
                                    <label for="title">Title</label>
                                    <input type="text" name="title" class="form-control" value="{{ $question->title }}" required>
                                  </div>
                                  <div class="form-group">
                                    <label for="subtitle">Subtitle</label>
                                    <input type="text" name="subtitle" class="form-control" value="{{ $question->subtitle }}" required>
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

                        <a href="{{ route('askedQuestions.delete', $question->id) }}" onclick="return confirm('Are you sure?')" class="btn btn-danger text-white">
                          <i class="fa fa-trash"></i> Delete
                        </a>
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                  <tfoot>
                    <tr>
                      <th>S.N</th>
                      <th>Title</th>
                      <th>Subtitle</th>
                      <th class="text-center">Status</th>
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
<div class="modal fade" id="createQuestionModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Create Asked Question</h5>
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
      </div>
      <form action="{{ route('askedQuestions.store') }}" method="post">
        @csrf
        <div class="modal-body">
          <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" class="form-control" required>
          </div>
          <div class="form-group">
            <label for="subtitle">Subtitle</label>
            <input type="text" name="subtitle" class="form-control" required>
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
