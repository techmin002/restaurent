<!-- Trigger button for the modal -->
<a data-toggle="modal" data-target="#editModal{{ $customer->id }}" class="btn btn-primary btn-sm">
    <i class="fa fa-edit"></i>
</a>

<!-- Modal Structure -->
<div class="modal fade" data-backdrop="static" id="editModal{{ $customer->id }}" tabindex="-1" role="dialog"
    aria-labelledby="editModalLabel{{ $customer->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="border-radius: 8px;">
            <div class="modal-header justify-content-center" style="background-color: #007bff; color: #ffff;">
                <h4 class="modal-title" id="editModalLabel{{ $customer->id }}">Edit Section</h4>
                <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('customers.update', $customer->id) }}" class="needs-validation" novalidate
                id="branchEditForm{{ $customer->id }}" method="post">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="container">

                        <div class="row mt-2">
                            <div class="col-lg-12" data-select2-id="select2-data-5-a5wr">
                                <label class="form-label12" for="Name_no">Name <span
                                        class="text-danger">*</span></label>
                                <input class="form-control" value="{{ $customer['name'] }}" placeholder="Enter Name"
                                    type="text" name="name" id="Name_no" required>
                                <div class="invalid-feedback">
                                    Please Enter Name first!

                                </div>
                            </div>
                            <div class="col-lg-12" data-select2-id="select2-data-5-a5wr">
                                <label class="form-label12" for="contact"> Phone<span
                                        class="text-danger">*</span></label>
                                <input class="form-control" placeholder="Enter Contact Numbers"
                                    value="{{ $customer['phone'] }}" type="text" name="phone" id="contact"
                                    required>
                                <div class="invalid-feedback">
                                    Please Enter Contact Numbers first!

                                </div>
                            </div>

                            <div class="col-lg-12" data-select2-id="select2-data-5-a5wr">
                                <label class="form-label12" for="email">Email<small>(optional)</small></label>
                               <input class="form-control" placeholder="Enter Email"
                                    value="{{ $customer['email'] }}" type="email" name="email" id="email" >

                            </div>

                            <div class="col-lg-12" data-select2-id="select2-data-5-a5wr">
                                <label class="form-label12" for="status">Status<span
                                        class="text-danger">*</span></label>
                                <select name="status" class="form-control" id="status" required>
                                    <option value="" selected disabled>Select Status</option>
                                    <option value="active" @if ($customer['status'] == 'active') selected @endif>Active
                                    </option>
                                    <option value="inactive" @if ($customer['status'] == 'inactive') selected @endif>Inactive
                                    </option>
                                </select>
                                <div class="invalid-feedback">
                                    Please Select Status!

                                </div>
                            </div>

                        </div>

                    </div>
                </div>
                <div class="modal-footer justify-content-start d-flex">
                    <button type="submit" name="submit" class="btn btn-primary w-100">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#show_hide_password{{ $customer->id }} button").on('click', function(event) {
            event.preventDefault();
            var input = $('#show_hide_password{{ $customer->id }} input');
            var icon = $('#show_hide_password{{ $customer->id }} i');
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

        $("#show_hide_confirm_password{{ $customer->id }} button").on('click', function(event) {
            event.preventDefault();
            var input = $('#show_hide_confirm_password{{ $customer->id }} input');
            var icon = $('#show_hide_confirm_password{{ $customer->id }} i');
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
