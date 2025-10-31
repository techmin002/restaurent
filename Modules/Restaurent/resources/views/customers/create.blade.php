<div class="modal fade" data-backdrop="static" id="exampleModalCenter" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="border-radius: 8px;">
            <div class="modal-header justify-content-center" style="background-color: #007bff; color: #ffff;">
                <h4 class="modal-title fs-5" id="staticBackdropLabel">Create Customer </h4>
                <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('customers.store') }}" class="needs-validation" novalidate id="expenseForm"
                method="post">
                @csrf
                <div class="modal-body">
                    <div class="container">

                        <div class="row mt-2">
                            <div class="col-lg-12" data-select2-id="select2-data-5-a5wr">
                                <label class="form-label12" for="Name_no">Name <span
                                        class="text-danger">*</span></label>
                                <input class="form-control" placeholder="Enter Name" type="text" name="name"
                                    id="Name_no" required>
                                <div class="invalid-feedback">
                                    Please Enter Name first!

                                </div>
                            </div>
                            <div class="col-lg-12" data-select2-id="select2-data-5-a5wr">
                                <label class="form-label12" for="contact"> Phone<span
                                        class="text-danger">*</span></label>
                                <input class="form-control" placeholder="Enter Contact Numbers" type="text"
                                    name="phone" id="contact" required>
                                <div class="invalid-feedback">
                                    Please Enter Contact Numbers first!

                                </div>
                            </div>

                            <div class="col-lg-12" data-select2-id="select2-data-5-a5wr">
                                <label class="form-label12" for="email">Email<small
                                        >(optional)</small></label>
                               <input type="email" name="email" class="form-control" id="">

                            </div>

                             <div class="col-lg-12" data-select2-id="select2-data-5-a5wr">
                                <label class="form-label12" for="status">Status<span
                                        class="text-danger">*</span></label>
                               <select name="status" class="form-control" id="status" required>
                                 <option value="" selected disabled>Select Status</option>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                               </select>
                                <div class="invalid-feedback">
                                    Please Select Status!

                                </div>
                            </div>

                        </div>

                    </div>
                </div>
                <div class="modal-footer justify-content-start d-flex">

                    <button type="submit" name="submit" id="btnSubmit" class="btn btn-primary w-100">Save
                        Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
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
<script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName('needs-validation');
            // Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function(form) {
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
