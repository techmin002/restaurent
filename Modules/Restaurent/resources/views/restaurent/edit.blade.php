<!-- Trigger button for the modal -->
<a data-toggle="modal" data-target="#editModal{{ $res->id }}" class="btn btn-primary btn-sm">
    <i class="fa fa-edit"></i>
</a>

<!-- Modal Structure -->
<div class="modal fade" data-backdrop="static" id="editModal{{ $res->id }}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel{{ $res->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border-radius: 8px;">
            <div class="modal-header justify-content-center" style="background-color: #007bff; color: #ffff;">
                <h4 class="modal-title" id="editModalLabel{{ $res->id }}">Edit Restaurent</h4>
                <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('restaurent.update', $res->id) }}" class="needs-validation" novalidate id="branchEditForm{{ $res->id }}" method="post">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="container">
                        <div class="row bg-secondary">
                            <div class="col-md-12">
                                <h5>Restaurent Details</h5>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-lg-6">
                                <label class="form-label" for="name">Restaurent Name <span class="text-danger">*</span></label>
                                <input class="form-control" placeholder="Enter Restaurent name" type="text" name="name" id="name{{ $res->id }}" value="{{ $res->name }}" required>
                                <div class="invalid-feedback">
                                    Please enter the Restaurent name.
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label" for="phone">Contact Number <span class="text-danger">*</span></label>
                                <input class="form-control" placeholder="Enter contact number" type="text" minlength="10" maxlength="10" name="phone" id="phone{{ $res->id }}" value="{{ $res->phone }}" required>
                                <div class="invalid-feedback">
                                    Please enter the Restaurent contact number.
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-lg-6">
                                <label class="form-label" for="address">Address <span class="text-danger">*</span></label>
                                <input class="form-control" placeholder="Enter address" type="text" name="address" id="address{{ $res->id }}" value="{{ $res->address }}" required>
                                <div class="invalid-feedback">
                                    Please enter the Restaurent address.
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label" for="email">Email <small>(Optional)</small></label>
                                <input class="form-control" placeholder="Enter Restaurent email" type="email" name="email" id="email{{ $res->id }}" value="{{ $res->email }}">
                            </div>
                        </div>

                        <div class="row mt-2 bg-secondary">
                            <div class="col-md-12">
                                <h5>Admin Details</h5>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-6">
                                <label class="form-label" for="admin_name">Admin Name <span class="text-danger">*</span></label>
                                <input class="form-control" placeholder="Enter admin name" type="text" name="admin_name" id="admin_name{{ $res->user->id }}" value="{{ $res->user->name }}" required>
                                <div class="invalid-feedback">
                                    Please enter the admin name.
                                </div>
                            </div>
                            @php($employee = Modules\Restaurent\Models\Employee::where('user_id',$res->user->id)->first())
                            <div class="col-md-6">
                                <label class="form-label" for="admin_phone">Admin Phone <span class="text-danger">*</span></label>
                                <input class="form-control" placeholder="Enter admin phone" type="text" maxlength="10" minlength="10" name="admin_phone" id="admin_phone{{ $res->user->id }}" value="{{ $employee->phone }}" required>
                                <div class="invalid-feedback">
                                    Please enter the admin phone number.
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="admin_email">Admin Email <span class="text-danger">*</span></label>
                                <input class="form-control" placeholder="Enter admin email" type="email" name="admin_email" id="admin_email{{ $res->user->id }}" value="{{ $res->user->email }}" required>
                                <div class="invalid-feedback">
                                    Please enter the admin email.
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="admin_address">Admin Address <span class="text-danger">*</span></label>
                                <input class="form-control" placeholder="Enter admin address" type="text" name="admin_address" id="admin_address{{ $res->user->id }}" value="{{ $employee->address }}" required>
                                <div class="invalid-feedback">
                                    Please enter the admin address.
                                </div>
                            </div>

                        </div>
                        <input type="hidden" name="userId" value="{{ $res->user->id }}">
                        <input type="hidden" name="employee_id" value="{{ $employee->id }}">
                        <div class="row mt-2">
                            <div class="col-lg-12">
                                <div class="card card-secondary">
                                    <div class="card-header">
                                        <h3 class="card-title">Publish</h3>
                                    </div>
                                    <div class="card-body">
                                        <input type="checkbox" name="status" {{ $res->status ? 'checked' : '' }} data-bootstrap-switch data-off-color="danger" data-on-color="success">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-start d-flex">
                    <button type="submit" name="submit" class="btn btn-primary w-25">Save Changes</button>
                    <button type="reset" class="btn btn-danger w-25">Reset Branch</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#show_hide_password{{ $res->id }} button").on('click', function(event) {
            event.preventDefault();
            var input = $('#show_hide_password{{ $res->id }} input');
            var icon = $('#show_hide_password{{ $res->id }} i');
            if (input.attr("type") == "text") {
                input.attr('type', 'password');
                icon.addClass("fa-eye-slash");
                icon.removeClass("fa-eye");
            } else if (input.attr("type") == "password") {
                input.attr('type', 'text');
                icon.removeClass("fa-eye-slash");
                icon.addClass("fa-eye");
            }
        });

        $("#show_hide_confirm_password{{ $res->id }} button").on('click', function(event) {
            event.preventDefault();
            var input = $('#show_hide_confirm_password{{ $res->id }} input');
            var icon = $('#show_hide_confirm_password{{ $res->id }} i');
            if (input.attr("type") == "text") {
                input.attr('type', 'password');
                icon.addClass("fa-eye-slash");
                icon.removeClass("fa-eye");
            } else if (input.attr("type") == "password") {
                input.attr('type', 'text');
                icon.removeClass("fa-eye-slash");
                icon.addClass("fa-eye");
            }
        });
    });

    // Bootstrap validation
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            var forms = document.getElementsByClassName('needs-validation');
            Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();
</script>
