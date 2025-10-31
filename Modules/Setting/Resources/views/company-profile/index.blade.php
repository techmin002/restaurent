@extends('setting::layouts.master')

@section('title', 'Company Profile')
@section('style')
    <link rel="stylesheet" href="https://unpkg.com/@yaireo/tagify/dist/tagify.css">
    <script src="https://unpkg.com/@yaireo/tagify"></script>
@endsection
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Company Profile</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('blogs.index') }}">Home</a></li>
                            <li class="breadcrumb-item active">Edit</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <form id="product-form" action="{{ route('company.update', $profile->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">

                        <!-- left column -->
                        <div class="col-md-12">
                            <!-- general form elements -->
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">General Information</h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->

                                <div class="card-body">
                                    <div class="form-row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="name">Company Name</label>
                                                <input type="text" name="company_name" class="form-control"
                                                    placeholder="Enter Company Name " value="{{ $profile->company_name }}"
                                                    required>
                                                @error('company_name')
                                                    <p style="color: red">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="company_email">Company Email</label>
                                                <input type="text" name="company_email" class="form-control"
                                                    placeholder="Enter Company Email "
                                                    value="{{ $profile->company_email }}">
                                                @error('company_email')
                                                    <p style="color: red">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="company_phone">Company Phone</label>
                                                <input type="text" name="company_phone" class="form-control"
                                                    placeholder="Enter Company Phone "
                                                    value="{{ $profile->company_phone }}">
                                                @error('company_phone')
                                                    <p style="color: red">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="company_address">Company Address</label>
                                                <input type="text" name="company_address" class="form-control"
                                                    placeholder="Enter Company Address "
                                                    value="{{ $profile->company_address }}">
                                                @error('company_address')
                                                    <p style="color: red">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="logo">Logo </label>

                                                <input type="file" id="file-ip-1" accept="image/*"
                                                    class="form-control-file border" value="{{ old('logo') }}"
                                                    onchange="showPreview1(event);" name="logo">
                                                <img src="{{ asset('upload/images/settings/' . $profile->logo) }}"
                                                    alt="Logo" width="200px">
                                                @error('logo')
                                                    <p style="color: red">{{ $message }}</p>
                                                @enderror
                                                <div class="preview mt-2">
                                                    <img src="" id="file-ip-1-preview" width="200px">
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="footer_logo">Footer Logo </label>

                                                <input type="file" id="file-ip-2" accept="image/*"
                                                    class="form-control-file border" value="{{ old('footer_logo') }}"
                                                    onchange="showPreview2(event);" name="footer_logo">
                                                <img src="{{ asset('upload/images/settings/' . $profile->footer_logo) }}"
                                                    alt="Footer Logo" width="200px">
                                                @error('footer_logo')
                                                    <p style="color: red">{{ $message }}</p>
                                                @enderror
                                                <div class="preview mt-2">
                                                    <img src="" id="file-ip-2-preview" width="200px">
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="favicon">Favicon </label>

                                                <input type="file" id="file-ip-3" accept="image/*"
                                                    class="form-control-file border" value="{{ old('favicon') }}"
                                                    onchange="showPreview3(event);" name="favicon">
                                                <img src="{{ asset('upload/images/settings/' . $profile->favicon) }}"
                                                    alt="favicon" width="200px">
                                                @error('favicon')
                                                    <p style="color: red">{{ $message }}</p>
                                                @enderror
                                                <div class="preview mt-2">
                                                    <img src="" id="file-ip-3-preview" width="200px">
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="image">Image </label>

                                                <input type="file" id="file-ip-4" accept="image/*"
                                                    class="form-control-file border" value="{{ old('image') }}"
                                                    onchange="showPreview4(event);" name="image">
                                                <img src="{{ asset('upload/images/settings/' . $profile->image) }}"
                                                    alt="image" width="200px">
                                                @error('image')
                                                    <p style="color: red">{{ $message }}</p>
                                                @enderror
                                                <div class="preview mt-2">
                                                    <img src="" id="file-ip-4-preview" width="200px">
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="introduction">Introduction</label>
                                                <textarea type="text" name="introduction" class="summernote" placeholder="Enter Introduction">{{ $profile->introduction }}</textarea>
                                                @error('introduction')
                                                    <p style="color: red">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="mission">Mission</label>
                                                <textarea type="text" name="mission" class="summernote" placeholder="Enter Mission">{{ $profile->mission }}</textarea>
                                                @error('mission')
                                                    <p style="color: red">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="vision">Vision</label>
                                                <textarea type="text" name="vision" class="summernote" placeholder="Enter Vision">{{ $profile->vision }}</textarea>
                                                @error('vision')
                                                    <p style="color: red">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="footer_text">Footer Text</label>
                                                <textarea type="text" name="footer_text" class="summernote" placeholder="Enter Footer Text">{{ $profile->footer_text }}</textarea>
                                                @error('footer_text')
                                                    <p style="color: red">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                        <!--/.col (left) -->
                        <div class="col-md-6">
                            <!-- general form elements -->
                            <div class="card card-info">
                                <div class="card-header">
                                    <h3 class="card-title">Social Information</h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <div class="card-body">
                                    <div class="form-row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="map">Map</label>
                                                <input type="text" name="map" class="form-control"
                                                    placeholder="Enter Map " value="{{ $profile->map }}">
                                                @error('map')
                                                    <p style="color: red">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="facebook">Facebook</label>
                                                <input type="text" name="facebook" class="form-control"
                                                    placeholder="Enter Facebook Link" value="{{ $profile->facebook }}">
                                                @error('facebook')
                                                    <p style="color: red">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="instagram">Instagram</label>
                                                <input type="text" name="instagram" class="form-control"
                                                    placeholder="Enter Instagram Link "
                                                    value="{{ $profile->instagram }}">
                                                @error('instagram')
                                                    <p style="color: red">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="twitter">Twitter</label>
                                                <input type="text" name="twitter" class="form-control"
                                                    placeholder="Enter Twitter Link " value="{{ $profile->twitter }}">
                                                @error('twitter')
                                                    <p style="color: red">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="youtube">Youtube</label>
                                                <input type="text" name="youtube" class="form-control"
                                                    placeholder="Enter Youtube Link " value="{{ $profile->youtube }}">
                                                @error('youtube')
                                                    <p style="color: red">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>

                        <div class="col-md-6">
                            <!-- general form elements -->
                            <div class="card card-success">
                                <div class="card-header">
                                    <h3 class="card-title">SEO - Social Engine Optimization</h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <div class="card-body">
                                    <div class="form-row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="meta_title">Meta Title</label>
                                                <input type="text" name="meta_title" class="form-control"
                                                    placeholder="Enter Meta Title " value="{{ $profile->meta_title }}">
                                                @error('meta_title')
                                                    <p style="color: red">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="meta_description">Meta Description</label>
                                                <textarea name="meta_description" class="form-control" placeholder="Enter Meta Description " value="">{{ $profile->meta_description }}</textarea>
                                                @error('meta_description')
                                                    <p style="color: red">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="meta_keywords">Meta Keywords</label>
                                                <textarea name='meta_keywords' placeholder='Keywords'>{{ $profile->meta_keywords }}</textarea>
                                                @error('meta_keywords')
                                                    <p style="color: red">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                            </div>

                            <!-- /.card -->
                        </div>

                    </div>

                    <!-- /.row -->
                    <div class="card-footer text-center">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection
@section('script')

    <!-- image preview -->
    <script type="text/javascript">
        function showPreview1(event) {
            if (event.target.files.length > 0) {
                var src = URL.createObjectURL(event.target.files[0]);
                var preview = document.getElementById("file-ip-1-preview");
                preview.src = src;
                preview.style.display = "block";
            }
        }

        function showPreview2(event) {
            if (event.target.files.length > 0) {
                var src = URL.createObjectURL(event.target.files[0]);
                var preview = document.getElementById("file-ip-2-preview");
                preview.src = src;
                preview.style.display = "block";
            }
        }

        function showPreview3(event) {
            if (event.target.files.length > 0) {
                var src = URL.createObjectURL(event.target.files[0]);
                var preview = document.getElementById("file-ip-3-preview");
                preview.src = src;
                preview.style.display = "block";
            }
        }

        function showPreview4(event) {
            if (event.target.files.length > 0) {
                var src = URL.createObjectURL(event.target.files[0]);
                var preview = document.getElementById("file-ip-4-preview");
                preview.src = src;
                preview.style.display = "block";
            }
        }
    </script>
    <script>
        $('textarea.summernote').summernote({
            placeholder: 'Enter Here',
            tabsize: 2,
            height: 250,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear']],
                ['fontname', ['fontname']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'hr']],
                ['view', ['fullscreen', 'codeview']],
                ['help', ['help']]
            ],
        });
    </script>
    <script>
        $('.extra-fields-customer').click(function() {
            $('.customer_records').clone().appendTo('.customer_records_dynamic');
            $('.customer_records_dynamic .customer_records').addClass('single remove');
            $('.single .extra-fields-customer').remove();
            $('.single').append(
                '<a href="#" class="remove-field btn-remove-customer badge badge-danger">Remove Product</a>');
            $('.customer_records_dynamic > .single').attr("class", "remove");

            $('.customer_records_dynamic input').each(function() {
                var count = 0;
                var fieldname = $(this).attr("name");
                $(this).attr('name', fieldname + count);
                count++;
            });

        });

        $(document).on('click', '.remove-field', function(e) {
            $(this).parent('.remove').remove();
            e.preventDefault();
        });
    </script>
    <script>
        var input1 = document.querySelector('input[name=tags]'),
            input2 = document.querySelector('textarea[name=meta_keywords]'),
            // init Tagify script on the above inputs
            tagify2 = new Tagify(input2, {
                enforeWhitelist: true,
                // whitelist: ["hello"
                // ]
            });

        // toggle Tagify on/off
        document.querySelector('input[type=checkbox]').addEventListener('change', function() {
            document.body.classList[this.checked ? 'add' : 'remove']('disabled');
        })
    </script>
@endsection
