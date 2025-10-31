@extends('setting::layouts.master')

@section('title', 'Create Role')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('roles.index') }}">Roles</a></li>
        <li class="breadcrumb-item active">Create</li>
    </ol>
@endsection

@section('style')
    <style>
        .custom-control-label {
            cursor: pointer;
        }
    </style>
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <form action="{{ route('roles.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Create Role <i class="bi bi-check"></i>
                                </button>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="name">Role Name <span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" name="name" required>
                                    </div>

                                    <hr>

                                    <div class="form-group">
                                        <label for="permissions">Permissions <span class="text-danger">*</span></label>
                                    </div>

                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="select-all">
                                            <label class="custom-control-label" for="select-all">Give All
                                                Permissions</label>
                                        </div>
                                    </div>

                                    <div class="row">

                                        <!-- User Management Permission -->
                                        <div class="col-lg-4 col-md-6 mb-3">
                                            <div class="card h-100 border-0 shadow">
                                                <div class="card-header">
                                                    User Mangement
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="access_user_management" name="permissions[]"
                                                                    value="access_user_management"
                                                                    {{ old('access_user_management') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="access_user_management">Access</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="edit_own_profile" name="permissions[]"
                                                                    value="edit_own_profile"
                                                                    {{ old('edit_own_profile') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="edit_own_profile">Own Profile</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- subscriber -->
                                        {{-- <div class="col-lg-4 col-md-6 mb-3">
                                    <div class="card h-100 border-0 shadow">
                                        <div class="card-header">
                                            Subscriber
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="custom-control custom-switch">
                                                        <input type="checkbox" class="custom-control-input"
                                                               id="access_subscriber" name="permissions[]"
                                                               value="access_subscriber" {{ old('access_subscriber') ? 'checked' : '' }}>
                                                        <label class="custom-control-label" for="access_subscriber">Access</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}

                                        <!-- Settings -->
                                        <div class="col-lg-4 col-md-6 mb-3">
                                            <div class="card h-100 border-0 shadow">
                                                <div class="card-header">
                                                    Settings
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="access_settings" name="permissions[]"
                                                                    value="access_settings"
                                                                    {{ old('access_settings') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="access_settings">Access</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Sliders Permission -->
                                        <div class="col-lg-4 col-md-6 mb-3">
                                            <div class="card h-100 border-0 shadow">
                                                <div class="card-header">
                                                    Sliders
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="access_sliders" name="permissions[]"
                                                                    value="access_sliders"
                                                                    {{ old('access_sliders') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="access_sliders">Access</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="show_sliders" name="permissions[]"
                                                                    value="show_sliders"
                                                                    {{ old('show_sliders') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="show_sliders">View</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="create_sliders" name="permissions[]"
                                                                    value="create_sliders"
                                                                    {{ old('create_sliders') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="create_sliders">Create</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="edit_sliders" name="permissions[]"
                                                                    value="edit_sliders"
                                                                    {{ old('edit_sliders') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="edit_sliders">Edit</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="delete_sliders" name="permissions[]"
                                                                    value="delete_sliders"
                                                                    {{ old('delete_sliders') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="delete_sliders">Delete</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Blogs Permission -->
                                        <div class="col-lg-4 col-md-6 mb-3">
                                            <div class="card h-100 border-0 shadow">
                                                <div class="card-header">
                                                    Blogs
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="access_blogs" name="permissions[]"
                                                                    value="access_blogs"
                                                                    {{ old('access_blogs') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="access_blogs">Access</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="show_blogs" name="permissions[]"
                                                                    value="show_blogs"
                                                                    {{ old('show_blogs') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="show_blogs">View</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="create_blogs" name="permissions[]"
                                                                    value="create_blogs"
                                                                    {{ old('create_blogs') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="create_blogs">Create</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="edit_blogs" name="permissions[]"
                                                                    value="edit_blogs"
                                                                    {{ old('edit_blogs') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="edit_blogs">Edit</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="delete_blogs" name="permissions[]"
                                                                    value="delete_blogs"
                                                                    {{ old('delete_blogs') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="delete_blogs">Delete</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Advertisements Permission -->
                                        <div class="col-lg-4 col-md-6 mb-3">
                                            <div class="card h-100 border-0 shadow">
                                                <div class="card-header">
                                                    Advertisements
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="access_advertisements" name="permissions[]"
                                                                    value="access_advertisements"
                                                                    {{ old('access_advertisements') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="access_advertisements">Access</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="show_advertisements" name="permissions[]"
                                                                    value="show_advertisements"
                                                                    {{ old('show_advertisements') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="show_advertisements">View</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="create_advertisements" name="permissions[]"
                                                                    value="create_advertisements"
                                                                    {{ old('create_advertisements') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="create_advertisements">Create</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="edit_advertisements" name="permissions[]"
                                                                    value="edit_advertisements"
                                                                    {{ old('edit_advertisements') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="edit_advertisements">Edit</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="delete_advertisements" name="permissions[]"
                                                                    value="delete_advertisements"
                                                                    {{ old('delete_advertisements') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="delete_advertisements">Delete</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Teams Permission -->
                                        <div class="col-lg-4 col-md-6 mb-3">
                                            <div class="card h-100 border-0 shadow">
                                                <div class="card-header">
                                                    Teams
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="access_teams" name="permissions[]"
                                                                    value="access_teams"
                                                                    {{ old('access_teams') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="access_teams">Access</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="show_teams" name="permissions[]"
                                                                    value="show_teams"
                                                                    {{ old('show_teams') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="show_teams">View</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="create_teams" name="permissions[]"
                                                                    value="create_teams"
                                                                    {{ old('create_teams') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="create_teams">Create</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="edit_teams" name="permissions[]"
                                                                    value="edit_teams"
                                                                    {{ old('edit_teams') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="edit_teams">Edit</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="delete_teams" name="permissions[]"
                                                                    value="delete_teams"
                                                                    {{ old('delete_teams') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="delete_teams">Delete</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Faqs Permission -->
                                        <div class="col-lg-4 col-md-6 mb-3">
                                            <div class="card h-100 border-0 shadow">
                                                <div class="card-header">
                                                    Faqs
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="access_faqs" name="permissions[]"
                                                                    value="access_faqs"
                                                                    {{ old('access_faqs') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="access_faqs">Access</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="show_faqs" name="permissions[]" value="show_faqs"
                                                                    {{ old('show_faqs') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="show_faqs">View</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="create_faqs" name="permissions[]"
                                                                    value="create_faqs"
                                                                    {{ old('create_faqs') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="create_faqs">Create</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="edit_faqs" name="permissions[]" value="edit_faqs"
                                                                    {{ old('edit_faqs') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="edit_faqs">Edit</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="delete_faqs" name="permissions[]"
                                                                    value="delete_faqs"
                                                                    {{ old('delete_faqs') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="delete_faqs">Delete</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Testimonials Permission -->
                                        <div class="col-lg-4 col-md-6 mb-3">
                                            <div class="card h-100 border-0 shadow">
                                                <div class="card-header">
                                                    Testimonials
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="access_testimonials" name="permissions[]"
                                                                    value="access_testimonials"
                                                                    {{ old('access_testimonials') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="access_testimonials">Access</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="show_testimonials" name="permissions[]"
                                                                    value="show_testimonials"
                                                                    {{ old('show_testimonials') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="show_testimonials">View</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="create_testimonials" name="permissions[]"
                                                                    value="create_testimonials"
                                                                    {{ old('create_testimonials') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="create_testimonials">Create</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="edit_testimonials" name="permissions[]"
                                                                    value="edit_testimonials"
                                                                    {{ old('edit_testimonials') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="edit_testimonials">Edit</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="delete_testimonials" name="permissions[]"
                                                                    value="delete_testimonials"
                                                                    {{ old('delete_testimonials') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="delete_testimonials">Delete</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Vacancies Permission -->
                                        <div class="col-lg-4 col-md-6 mb-3">
                                            <div class="card h-100 border-0 shadow">
                                                <div class="card-header">
                                                    Vacancy
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="access_vacancies" name="permissions[]"
                                                                    value="access_vacancies"
                                                                    {{ old('access_vacancies') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="access_vacancies">Access</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="show_vacancies" name="permissions[]"
                                                                    value="show_vacancies"
                                                                    {{ old('show_vacancies') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="show_vacancies">View</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="create_vacancies" name="permissions[]"
                                                                    value="create_vacancies"
                                                                    {{ old('create_vacancies') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="create_vacancies">Create</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="edit_vacancies" name="permissions[]"
                                                                    value="edit_vacancies"
                                                                    {{ old('edit_vacancies') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="edit_vacancies">Edit</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="delete_vacancies" name="permissions[]"
                                                                    value="delete_vacancies"
                                                                    {{ old('delete_vacancies') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="delete_vacancies">Delete</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- Service permissions --}}
                                        <div class="col-lg-4 col-md-6 mb-3">
                                            <div class="card h-100 border-0 shadow">
                                                <div class="card-header">
                                                    Services
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="access_services" name="permissions[]"
                                                                    value="access_services"
                                                                    {{ old('access_services') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="access_services">Access</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="show_services" name="permissions[]"
                                                                    value="show_services"
                                                                    {{ old('show_services') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="show_services">View</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="create_services" name="permissions[]"
                                                                    value="create_services"
                                                                    {{ old('create_services') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="create_services">Create</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="edit_services" name="permissions[]"
                                                                    value="edit_services"
                                                                    {{ old('edit_services') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="edit_services">Edit</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="delete_services" name="permissions[]"
                                                                    value="delete_services"
                                                                    {{ old('delete_services') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="delete_services">Delete</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- service category permission --}}
                                        <div class="col-lg-4 col-md-6 mb-3">
                                            <div class="card h-100 border-0 shadow">
                                                <div class="card-header">
                                                    Service Category
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="access_service_category" name="permissions[]"
                                                                    value="access_service_category"
                                                                    {{ old('access_service_category') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="access_service_category">Access</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="show_service_category" name="permissions[]"
                                                                    value="show_service_category"
                                                                    {{ old('show_service_category') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="show_service_category">View</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="create_service_category" name="permissions[]"
                                                                    value="create_service_category"
                                                                    {{ old('create_service_category') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="create_service_category">Create</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="edit_service_category" name="permissions[]"
                                                                    value="edit_service_category"
                                                                    {{ old('edit_service_category') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="edit_service_category">Edit</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="delete_service_category" name="permissions[]"
                                                                    value="delete_service_category"
                                                                    {{ old('delete_service_category') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="delete_service_category">Delete</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- Branch permission --}}
                                        <div class="col-lg-4 col-md-6 mb-3">
                                            <div class="card h-100 border-0 shadow">
                                                <div class="card-header">
                                                    Branch Category
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="access_branch" name="permissions[]"
                                                                    value="access_branch"
                                                                    {{ old('access_branch') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="access_branch">Access</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="show_branch" name="permissions[]"
                                                                    value="show_branch"
                                                                    {{ old('show_branch') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="show_branch">View</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="create_branch" name="permissions[]"
                                                                    value="create_branch"
                                                                    {{ old('create_branch') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="create_branch">Create</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="edit_branch" name="permissions[]"
                                                                    value="edit_branch"
                                                                    {{ old('edit_branch') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="edit_branch">Edit</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="delete_branch" name="permissions[]"
                                                                    value="delete_branch"
                                                                    {{ old('delete_branch') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="delete_branch">Delete</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- Expense permission --}}
                                        <div class="col-lg-4 col-md-6 mb-3">
                                            <div class="card h-100 border-0 shadow">
                                                <div class="card-header">
                                                    Expense
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="access_expense" name="permissions[]"
                                                                    value="access_expense"
                                                                    {{ old('access_expense') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="access_expense">Access</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="show_expense" name="permissions[]"
                                                                    value="show_expense"
                                                                    {{ old('show_expense') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="show_expense">View</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="create_expense" name="permissions[]"
                                                                    value="create_expense"
                                                                    {{ old('create_expense') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="create_expense">Create</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="edit_expense" name="permissions[]"
                                                                    value="edit_expense"
                                                                    {{ old('edit_expense') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="edit_expense">Edit</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="delete_expense" name="permissions[]"
                                                                    value="delete_expense"
                                                                    {{ old('delete_expense') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="delete_expense">Delete</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- Petty Cash permission --}}
                                        <div class="col-lg-4 col-md-6 mb-3">
                                            <div class="card h-100 border-0 shadow">
                                                <div class="card-header">
                                                    Petty Cash
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="access_pettycash" name="permissions[]"
                                                                    value="access_pettycash"
                                                                    {{ old('access_pettycash') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="access_pettycash">Access</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="show_pettycash" name="permissions[]"
                                                                    value="show_pettycash"
                                                                    {{ old('show_pettycash') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="show_pettycash">View</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="create_pettycash" name="permissions[]"
                                                                    value="create_pettycash"
                                                                    {{ old('create_pettycash') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="create_pettycash">Create</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="edit_pettycash" name="permissions[]"
                                                                    value="edit_pettycash"
                                                                    {{ old('edit_pettycash') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="edit_pettycash">Edit</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="delete_pettycash" name="permissions[]"
                                                                    value="delete_pettycash"
                                                                    {{ old('delete_pettycash') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="delete_pettycash">Delete</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- Vehicle MGNT permission --}}
                                        <div class="col-lg-4 col-md-6 mb-3">
                                            <div class="card h-100 border-0 shadow">
                                                <div class="card-header">
                                                    Vehicle MGNT
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="access_vehicle" name="permissions[]"
                                                                    value="access_vehicle"
                                                                    {{ old('access_vehicle') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="access_vehicle">Access</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="show_vehicle" name="permissions[]"
                                                                    value="show_vehicle"
                                                                    {{ old('show_vehicle') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="show_vehicle">View</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="create_vehicle" name="permissions[]"
                                                                    value="create_vehicle"
                                                                    {{ old('create_vehicle') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="create_vehicle">Create</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="edit_vehicle" name="permissions[]"
                                                                    value="edit_vehicle"
                                                                    {{ old('edit_vehicle') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="edit_vehicle">Edit</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="delete_vehicle" name="permissions[]"
                                                                    value="delete_vehicle"
                                                                    {{ old('delete_vehicle') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="delete_vehicle">Delete</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- Finance permission --}}
                                        <div class="col-lg-4 col-md-6 mb-3">
                                            <div class="card h-100 border-0 shadow">
                                                <div class="card-header">
                                                    Finance
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="access_finance" name="permissions[]"
                                                                    value="access_finance"
                                                                    {{ old('access_finance') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="access_finance">Access</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="show_finance" name="permissions[]"
                                                                    value="show_finance"
                                                                    {{ old('show_finance') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="show_finance">View</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="create_finance" name="permissions[]"
                                                                    value="create_finance"
                                                                    {{ old('create_finance') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="create_finance">Create</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="edit_finance" name="permissions[]"
                                                                    value="edit_finance"
                                                                    {{ old('edit_finance') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="edit_finance">Edit</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="delete_finance" name="permissions[]"
                                                                    value="delete_finance"
                                                                    {{ old('delete_finance') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="delete_finance">Delete</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- Support Dashboard permission --}}
                                        <div class="col-lg-4 col-md-6 mb-3">
                                            <div class="card h-100 border-0 shadow">
                                                <div class="card-header">
                                                    Support Dashboard
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="access_ticket" name="permissions[]"
                                                                    value="access_ticket"
                                                                    {{ old('access_ticket') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="access_ticket">Access</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="show_ticket" name="permissions[]"
                                                                    value="show_ticket"
                                                                    {{ old('show_ticket') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="show_ticket">View</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="create_ticket" name="permissions[]"
                                                                    value="create_ticket"
                                                                    {{ old('create_ticket') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="create_ticket">Create</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="edit_ticket" name="permissions[]"
                                                                    value="edit_ticket"
                                                                    {{ old('edit_ticket') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="edit_ticket">Edit</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="delete_ticket" name="permissions[]"
                                                                    value="delete_ticket"
                                                                    {{ old('delete_ticket') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="delete_ticket">Delete</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- Product permission --}}
                                        <div class="col-lg-4 col-md-6 mb-3">
                                            <div class="card h-100 border-0 shadow">
                                                <div class="card-header">
                                                    Product
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="access_product" name="permissions[]"
                                                                    value="access_product"
                                                                    {{ old('access_product') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="access_product">Access</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="show_product" name="permissions[]"
                                                                    value="show_product"
                                                                    {{ old('show_product') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="show_product">View</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="create_product" name="permissions[]"
                                                                    value="create_product"
                                                                    {{ old('create_product') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="create_product">Create</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="edit_product" name="permissions[]"
                                                                    value="edit_product"
                                                                    {{ old('edit_product') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="edit_product">Edit</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="delete_product" name="permissions[]"
                                                                    value="delete_product"
                                                                    {{ old('delete_product') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="delete_product">Delete</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- Inventory permission --}}
                                        <div class="col-lg-4 col-md-6 mb-3">
                                            <div class="card h-100 border-0 shadow">
                                                <div class="card-header">
                                                    Inventory
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="access_inventory" name="permissions[]"
                                                                    value="access_inventory"
                                                                    {{ old('access_inventory') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="access_inventory">Access</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="show_inventory" name="permissions[]"
                                                                    value="show_inventory"
                                                                    {{ old('show_inventory') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="show_inventory">View</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="create_inventory" name="permissions[]"
                                                                    value="create_inventory"
                                                                    {{ old('create_inventory') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="create_inventory">Create</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="edit_inventory" name="permissions[]"
                                                                    value="edit_inventory"
                                                                    {{ old('edit_inventory') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="edit_inventory">Edit</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="delete_inventory" name="permissions[]"
                                                                    value="delete_inventory"
                                                                    {{ old('delete_inventory') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="delete_inventory">Delete</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- Gallery permission --}}
                                        <div class="col-lg-4 col-md-6 mb-3">
                                            <div class="card h-100 border-0 shadow">
                                                <div class="card-header">
                                                    Gallery
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="access_gallery" name="permissions[]"
                                                                    value="access_gallery"
                                                                    {{ old('access_gallery') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="access_gallery">Access</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="show_gallery" name="permissions[]"
                                                                    value="show_gallery"
                                                                    {{ old('show_gallery') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="show_gallery">View</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="create_gallery" name="permissions[]"
                                                                    value="create_gallery"
                                                                    {{ old('create_gallery') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="create_gallery">Create</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="edit_gallery" name="permissions[]"
                                                                    value="edit_gallery"
                                                                    {{ old('edit_gallery') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="edit_gallery">Edit</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="delete_gallery" name="permissions[]"
                                                                    value="delete_gallery"
                                                                    {{ old('delete_gallery') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="delete_gallery">Delete</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- Leaves permission --}}
                                        <div class="col-lg-4 col-md-6 mb-3">
                                            <div class="card h-100 border-0 shadow">
                                                <div class="card-header">
                                                    Leaves
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="access_leaves" name="permissions[]"
                                                                    value="access_leaves"
                                                                    {{ old('access_leaves') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="access_leaves">Access</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="show_leaves" name="permissions[]"
                                                                    value="show_leaves"
                                                                    {{ old('show_leaves') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="show_leaves">View</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="create_leaves" name="permissions[]"
                                                                    value="create_leaves"
                                                                    {{ old('create_leaves') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="create_leaves">Create</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="edit_leaves" name="permissions[]"
                                                                    value="edit_leaves"
                                                                    {{ old('edit_leaves') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="edit_leaves">Edit</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="delete_leaves" name="permissions[]"
                                                                    value="delete_leaves"
                                                                    {{ old('delete_leaves') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="delete_leaves">Delete</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- Inquiries permission --}}
                                        <div class="col-lg-4 col-md-6 mb-3">
                                            <div class="card h-100 border-0 shadow">
                                                <div class="card-header">
                                                    Inquiries
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="access_inquiries" name="permissions[]"
                                                                    value="access_inquiries"
                                                                    {{ old('access_inquiries') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="access_inquiries">Access</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="show_inquiries" name="permissions[]"
                                                                    value="show_inquiries"
                                                                    {{ old('show_inquiries') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="show_inquiries">View</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="create_inquiries" name="permissions[]"
                                                                    value="create_inquiries"
                                                                    {{ old('create_inquiries') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="create_inquiries">Create</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="edit_inquiries" name="permissions[]"
                                                                    value="edit_inquiries"
                                                                    {{ old('edit_inquiries') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="edit_inquiries">Edit</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="delete_inquiries" name="permissions[]"
                                                                    value="delete_inquiries"
                                                                    {{ old('delete_inquiries') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="delete_inquiries">Delete</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- PayRoll permission --}}
                                        <div class="col-lg-4 col-md-6 mb-3">
                                            <div class="card h-100 border-0 shadow">
                                                <div class="card-header">
                                                    PayRoll
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="access_payroll" name="permissions[]"
                                                                    value="access_payroll"
                                                                    {{ old('access_payroll') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="access_payroll">Access</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="show_payroll" name="permissions[]"
                                                                    value="show_payroll"
                                                                    {{ old('show_payroll') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="show_payroll">View</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="create_payroll" name="permissions[]"
                                                                    value="create_payroll"
                                                                    {{ old('create_payroll') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="create_payroll">Create</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="edit_payroll" name="permissions[]"
                                                                    value="edit_payroll"
                                                                    {{ old('edit_payroll') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="edit_payroll">Edit</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="delete_payroll" name="permissions[]"
                                                                    value="delete_payroll"
                                                                    {{ old('delete_payroll') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="delete_payroll">Delete</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- Attandance permission --}}
                                        <div class="col-lg-4 col-md-6 mb-3">
                                            <div class="card h-100 border-0 shadow">
                                                <div class="card-header">
                                                    Attandance
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="access_attandance" name="permissions[]"
                                                                    value="access_attandance"
                                                                    {{ old('access_attandance') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="access_attandance">Access</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="show_attandance" name="permissions[]"
                                                                    value="show_attandance"
                                                                    {{ old('show_attandance') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="show_attandance">View</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="create_attandance" name="permissions[]"
                                                                    value="create_attandance"
                                                                    {{ old('create_attandance') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="create_attandance">Create</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="edit_attandance" name="permissions[]"
                                                                    value="edit_attandance"
                                                                    {{ old('edit_attandance') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="edit_attandance">Edit</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="delete_attandance" name="permissions[]"
                                                                    value="delete_attandance"
                                                                    {{ old('delete_attandance') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="delete_attandance">Delete</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('#select-all').click(function() {
                var checked = this.checked;
                $('input[type="checkbox"]').each(function() {
                    this.checked = checked;
                });
            })
        });
    </script>
@endsection
