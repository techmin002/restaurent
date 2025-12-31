@extends('frontend.layouts.master')

@section('content')

{{-- Banner Section --}}
<section class="banner-bg py-4">
    <div class="container">
        <p class="mb-0 fw-bold custom-clr-dark">
            Home <span class="font-monospace">&gt;</span> Blogs/Videos
        </p>
    </div>
</section>

{{-- Video Section --}}
<section class="blog-section p-0 py-5">
    <div class="container">
        <div class="row">

            {{-- LEFT COLUMN – Main Videos --}}
            <div class="col-xl-8">
                <div class="row" id="videos-container">
                    @foreach($videos as $video)
                        <div class="col-lg-6 pb-4">
                            <div class="blog-shadow rounded-16">
                                <div class="text-center blog-image mb-3">
                                    <a href="{{ $video->youtube_url }}" target="_blank">
                                        <img src="{{ $video->thumbnail ? asset($video->thumbnail) : asset('frontend/images/default-video.png') }}" 
                                             alt="video-thumbnail" class="landing-blog-img">
                                    </a>
                                </div>
                                <div class="p-3 pt-0">
                                    <div class="d-flex align-items-center mb-2">
                                        <img src="assets/web/images/icons/clock.svg" alt="">
                                        <p class="ms-1 mb-0">{{ \Carbon\Carbon::parse($video->created_at)->format('d M, Y') }}</p>
                                    </div>
                                    <h6 class="h6-line-clamp">{{ $video->title }}</h6>
                                    @if($video->description)
                                        <p>{{ Str::limit($video->description, 120) }}</p>
                                    @endif
                                    <a href="{{ $video->youtube_url }}" target="_blank" class="custom-clr-primary">
                                        Watch Video <span class="font-monospace">></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="blogs-pagination mt-4">
                    {{ $videos->links() }}
                </div>
            </div>

            {{-- RIGHT COLUMN – Featured Videos --}}
            <div class="col-xl-4">
                <h4 class="fw-bold custom-clr-dark mb-3">Featured Blogs/Videos</h4>
                @foreach($featuredVideos as $fv)
                    <div class="blog-shadow rounded-16 mb-4">
                        <div class="d-flex align-items-center p-3">
                            <img src="{{ $fv->thumbnail ? asset($fv->thumbnail) : asset('frontend/images/default-video.png') }}" 
                                 class="blog-sm-img" alt="...">
                            <div class="mx-3">
                                <p class="small-clr fw-bold mb-1">{{ \Carbon\Carbon::parse($fv->created_at)->format('d M, Y') }}</p>
                                <p class="p-2nd-line-clamp mb-1"><strong>{{ $fv->title }}</strong></p>
                                <a href="{{ $fv->youtube_url }}" target="_blank" class="custom-clr-primary">
                                    Watch Video <span class="font-monospace">></span>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
                        <form method="GET" action="{{ route('company-profile.videos') }}" class="mb-4">
    <div class="input-group">
        <input type="text" name="search" class="form-control" placeholder="Search videos by name" 
               value="{{ request('search') }}">
        <button type="submit" class="btn btn-primary">Search</button>
    </div>
</form>
            </div>
    


        </div>
    </div>
</section>

@endsection

@push('styles')
<style>
    /* General */
    .custom-clr-dark { color: #212529; }
    .small-clr { color: #6c757d; font-size: 0.875rem; }

    /* Banner */
    .banner-bg { background-color: #f8f9fa; }

    /* Video Cards */
    .blog-shadow { 
        box-shadow: 0 4px 15px rgba(0,0,0,0.08); 
        transition: transform 0.3s ease, box-shadow 0.3s ease; 
    }
    .blog-shadow:hover { 
        transform: translateY(-5px); 
        box-shadow: 0 8px 20px rgba(0,0,0,0.15); 
    }
    .rounded-16 { border-radius: 16px; }
    .landing-blog-img { width: 100%; height: 200px; object-fit: cover; }

    .h6-line-clamp {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;  
        overflow: hidden;
    }
    .p-2nd-line-clamp {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;  
        overflow: hidden;
    }

    /* Pagination */
    .blogs-pagination .pagination { justify-content: center; }

    /* Colors */
    .custom-clr-primary { color: #ff5722; font-weight: 500; }
</style>
@endpush
