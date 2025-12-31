@extends('setting::layouts.master')

@section('title', 'Videos Management')

@section('content')
<div class="content-wrapper">
    
    <!-- Page Header -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Videos List</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Videos</li>
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
                        <!-- Button trigger modal -->
                        <button class="btn btn-primary" data-toggle="modal" data-target="#createVideoModal">
                            <i class="fa fa-plus"></i> Add New Video
                        </button>
                    </h3>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Thumbnail</th>
                                <th>Title</th>
                                <th>YouTube URL</th>
                                <th>Featured</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse($videos as $video)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    @if($video->thumbnail)
                                        <img src="{{ $video->thumbnail }}" width="80" height="50" style="object-fit: cover;">
                                    @endif
                                </td>
                                <td>{{ $video->title }}</td>
                                <td><a href="{{ $video->youtube_url }}" target="_blank">{{ $video->youtube_url }}</a></td>
                                <td>{{ $video->is_featured ? 'Yes' : 'No' }}</td>
                                <td class="text-center">
                                    <!-- Edit button (optional) -->
                                    <!-- Delete -->
                                    <form action="{{ route('company-profile.videos.delete', $video->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button onclick="return confirm('Are you sure?')" class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No videos found.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>

                    {{ $videos->links() }} {{-- Pagination --}}
                </div>
            </div>

        </div>
    </section>
</div>

<!-- Create Video Modal -->
<div class="modal fade" id="createVideoModal" tabindex="-1" role="dialog" aria-labelledby="createVideoModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('company-profile.videos.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="createVideoModalLabel">Add New Video</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Video Title</label>
                        <input type="text" name="title" class="form-control" placeholder="Enter video title" required>
                    </div>
                    <div class="form-group">
                        <label>YouTube URL</label>
                        <input type="url" name="youtube_url" class="form-control" placeholder="Enter YouTube link" required>
                    </div>
                    <div class="form-check mt-2">
                        <input type="checkbox" name="is_featured" class="form-check-input" id="is_featured">
                        <label class="form-check-label" for="is_featured">Featured / Suggested</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Save Video</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
