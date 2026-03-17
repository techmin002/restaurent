@extends('setting::layouts.master')

@section('title', 'Create User')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Users</a></li>
        <li class="breadcrumb-item active">Create</li>
    </ol>
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid mb-4">
                <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <button class="btn btn-primary">Create User <i class="bi bi-check"></i></button>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-body">
                                    <div class="form-row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="name">Name <span class="text-danger">*</span></label>
                                                <input class="form-control" type="text" name="name" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="email">Email <span class="text-danger">*</span></label>
                                                <input class="form-control" type="email" name="email" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row">

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Password</label>
                                                <div class="input-group mb-3" id="show_hide_password">
                                                    <input type="password" class="form-control" placeholder="Password"
                                                        aria-label="password" name="password" required
                                                        aria-describedby="button-addon2">
                                                    <div class="input-group-append">
                                                        <button class="btn btn-outline-secondary" type="button"
                                                            id="button-addon2"><i class="fa fa-eye-slash"
                                                                aria-hidden="true"></i></button>
                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="password_confirmation">Confirm Password <span
                                                        class="text-danger">*</span></label>
                                                <div class="input-group" id="show_hide_confirm_password">
                                                    <input class="form-control" required name="password_confirmation"
                                                        type="password">
                                                    <div class="input-group-append">
                                                        <button class="btn btn-outline-secondary" type="button"
                                                            id="button-addon2"><i class="fa fa-eye-slash"
                                                                aria-hidden="true"></i></button>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="role">Role <span class="text-danger">*</span></label>
                                        <select class="form-control" name="role" id="role" required>
                                            <option value="" selected disabled>Select Role</option>
                                            @foreach (\Spatie\Permission\Models\Role::where('name', '!=', 'Super Admin')->get() as $role)
                                                <option value="{{ $role->name }}">{{ $role->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="status">Status <span class="text-danger">*</span></label>
                                        <select class="form-control" name="status" id="status" required>
                                            <option value="" selected disabled>Select Status</option>
                                            <option value="on">Active</option>
                                            <option value="off">Deactive</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="card">
                                <input type="hidden" name="created_by" value="{{ auth()->user()->id }}">

                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="image">Profile Image <span class="text-danger">*</span></label>

                                        <input type="file" id="file-ip-1" accept="image/*"
                                            class="form-control-file border" value="{{ old('image') }}"
                                            onchange="showPreview1(event);" name="image">
                                        @error('image')
                                            <p style="color: red">{{ $message }}</p>
                                        @enderror
                                        <div class="preview mt-2">
                                            <img src="" id="file-ip-1-preview" width="200px">
                                        </div>
                                    </div>
                                    @if (auth()->user()->role->name === 'Super Admin')
                                        <div class="form-group">
                                            <label for="restaurent_id">Branch <span class="text-danger">*</span></label>
                                            <select class="form-control" name="restaurent_id" id="restaurent_id" required>
                                                <option value="" selected disabled>Select Branch</option>
                                                {{-- @foreach ($branches as $branch) --}}
                                                    {{-- <option value="{{ $branch->id }}">{{ $branch->name }}</option> --}}
                                                {{-- @endforeach --}}

                                            </select>
                                        </div>
                                    @else
                                        <input type="hidden" name="restaurent_id" value="{{ auth()->user()->restaurent_id }}">
                                    @endif
                                    <div class="form-group">
                                        <label for="">Notification User Type</label>
                                        <select name="user_type" id="" class="form-control">
                                            <option value="">Select Notification User Type</option>
                                            <option value="reception">Reception</option>
                                            <option value="kitchen">Kitchen</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $("#show_hide_password button").on('click', function(event) {
                event.preventDefault();
                if ($('#show_hide_password input').attr("type") == "text") {
                    $('#show_hide_password input').attr('type', 'password');
                    $('#show_hide_password i').addClass("fa-eye-slash");
                    $('#show_hide_password i').removeClass("fa-eye");
                } else if ($('#show_hide_password input').attr("type") == "password") {
                    $('#show_hide_password input').attr('type', 'text');
                    $('#show_hide_password i').removeClass("fa-eye-slash");
                    $('#show_hide_password i').addClass("fa-eye");
                }
            });
            $("#show_hide_confirm_password button").on('click', function(event) {
                event.preventDefault();
                if ($('#show_hide_confirm_password input').attr("type") == "text") {
                    $('#show_hide_confirm_password input').attr('type', 'password');
                    $('#show_hide_confirm_password i').addClass("fa-eye-slash");
                    $('#show_hide_confirm_password i').removeClass("fa-eye");
                } else if ($('#show_hide_confirm_password input').attr("type") == "password") {
                    $('#show_hide_confirm_password input').attr('type', 'text');
                    $('#show_hide_confirm_password i').removeClass("fa-eye-slash");
                    $('#show_hide_confirm_password i').addClass("fa-eye");
                }
            });

        });
    </script>
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
    </script>
@endsection
