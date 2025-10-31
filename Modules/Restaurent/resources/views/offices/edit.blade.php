<!-- Trigger button for the modal -->
<a data-toggle="modal" data-target="#editModal{{ $office->id }}" class="btn btn-primary btn-sm">
    <i class="fa fa-edit"></i>
</a>

<!-- Modal Structure -->
<div class="modal fade" data-backdrop="static" id="editModal{{ $office->id }}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel{{ $office->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="border-radius: 8px;">
            <div class="modal-header justify-content-center" style="background-color: #007bff; color: #ffff;">
                <h4 class="modal-title" id="editModalLabel{{ $office->id }}">Edit Section</h4>
                <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('offices.update', $office->id) }}" class="needs-validation" novalidate id="branchEditForm{{ $office->id }}" method="post">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="container">

                         <div class="row mt-2">
                            <div class="col-lg-12" data-select2-id="select2-data-5-a5wr">
                                <label class="form-label12" for="Name_no">Name <span
                                        class="text-danger">*</span></label>
                                <input class="form-control" placeholder="Enter Name" type="text" value="{{ $office['name'] }}" name="name"
                                    id="Name_no" required>
                                <div class="invalid-feedback">
                                    Please Enter Name first!

                                </div>
                            </div>
                            <div class="col-lg-12" data-select2-id="select2-data-5-a5wr">
                                <label class="form-label12" for="contact">Name Numbers<span
                                        class="text-danger">*</span></label>
                                <input class="form-control" placeholder="Enter Contact Numbers" type="text"
                                    value="{{ $office['contact_numbers'] }}" name="phone_numbers" id="contact" required>
                                <div class="invalid-feedback">
                                    Please Enter Contact Numbers first!

                                </div>
                            </div>

                            <div class="col-lg-12" data-select2-id="select2-data-5-a5wr">
                                <label class="form-label12" for="address">Location<span
                                        class="text-danger">*</span></label>
                                <textarea name="address" id="address" class="form-control" required>{{ $office['address'] }}</textarea>
                                <div class="invalid-feedback">
                                    Please Enter Shop/office Location!

                                </div>
                            </div>
                            <div class="col-lg-12" data-select2-id="select2-data-5-a5wr">
                                <label class="form-label12" for="type">Type <span
                                        class="text-danger">*</span></label>
                                <select name="type" class="form-control" id="type" required>
                                    <option value="" selected disabled>Select Type</option>
                                    <option value="offie" @if($office['type'] == 'office') selected @endif>Office</option>
                                    <option value="shop" @if($office['type'] == 'shop') selected @endif>Shop</option>
                                </select>
                                <div class="invalid-feedback">
                                    Please Select office type!

                                </div>
                            </div>
                             <div class="col-lg-12" data-select2-id="select2-data-5-a5wr">
                                <label class="form-label12" for="status">Status<span
                                        class="text-danger">*</span></label>
                               <select name="status" class="form-control" id="status" required>
                                 <option value="" selected disabled>Select Status</option>
                                <option value="active" @if($office['status'] == 'active') selected @endif>Active</option>
                                <option value="inactive" @if($office['status'] == 'inactive') selected @endif>Inactive</option>
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
        $("#show_hide_password{{ $office->id }} button").on('click', function(event) {
            event.preventDefault();
            var input = $('#show_hide_password{{ $office->id }} input');
            var icon = $('#show_hide_password{{ $office->id }} i');
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

        $("#show_hide_confirm_password{{ $office->id }} button").on('click', function(event) {
            event.preventDefault();
            var input = $('#show_hide_confirm_password{{ $office->id }} input');
            var icon = $('#show_hide_confirm_password{{ $office->id }} i');
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
