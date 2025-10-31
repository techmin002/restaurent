<div class="modal fade" data-backdrop="static" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-lg"  role="document">
        <div class="modal-content" style="border-radius: 8px;">
            <div class="modal-header justify-content-center" style="background-color: #007bff; color: #ffff;">
                <h4 class="modal-title fs-5" id="staticBackdropLabel">Create Branch </h4>
                <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
            </div>
            <form action="{{ route('branches.store') }}" class="needs-validation" novalidate id="expenseForm" method="post">
                @csrf
                <div class="modal-body">
                    <div class="container">
                        <div class="row bg-secondary">
                            <div class="col-md-12">
                                <h5>Branch Detail's</h5>
                            </div>
                            
                            
                        </div>
                        <div class="row mt-2">
                            <div class="col-lg-6" data-select2-id="select2-data-5-a5wr">
                                <label class="form-label12" for="name">Branch Name <span
                                        class="text-danger">*</span></label>
                                <input class="form-control" placeholder="Enter branch Name" type="text"
                                    name="name" id="name" required>
                                    <div class="invalid-feedback">
                                        Please Enter Branch Name first!
                                      </div>
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label12" for="phone">Contact Number <span
                                        class="text-danger">*</span></label>
                                <input class="form-control" placeholder="Enter Title" type="text" minlength="10"
                                    maxlength="10" name="phone" id="phone" required>
                                    <div class="invalid-feedback">
                                        Please Enter Branch Contact Number first!
                                      </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-lg-6">
                                <label class="form-label12" for="address">Address <span
                                        class="text-danger">*</span></label>
                                <input class="form-control" placeholder="Enter address" type="text" name="address"
                                    id="address" required>
                                    <div class="invalid-feedback">
                                        Please Enter Branch Address first!
                                      </div>
                            </div>

                            <div class="col-lg-6">
                                <label class="form-label12" for="email">Email <small>Optional</small></label>
                                <input class="form-control" placeholder="Enter branch email" type="email"
                                    name="email" id="email">
                            </div>
                        </div>
                        
                        <div class="row mt-2 bg-secondary">
                            <div class="col-md-12">
                                <h5>Admin Detail's</h5>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-6">
                                <label class="form-label12" for="name">Admin Name <span class="text-danger"></span></label>
                                <input class="form-control" placeholder="Enter Admin Name" type="text" required name="admin name">
                                <div class="invalid-feedback">
                                    Please Enter Admin Name first!
                                  </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label12" for="phone">Admin Phone <span class="text-danger"></span></label>
                                <input class="form-control" placeholder="Enter Admin phone" maxlength="10" minlength="10" type="text" required name="admin_phone">
                                <div class="invalid-feedback">
                                    Please Enter Admin Phone first!
                                  </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label12" for="email">Admin Email <span class="text-danger"></span></label>
                                <input class="form-control" placeholder="Enter Admin email" type="email" required name="admin_email">
                                <div class="invalid-feedback">
                                    Please Enter Admin Email first!
                                  </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label12" for="admin_address">Admin Address <span class="text-danger"></span></label>
                                <input class="form-control" placeholder="Enter Admin address" type="text" required name="admin_address">
                                <div class="invalid-feedback">
                                    Please Enter Admin Address first!
                                  </div>
                            </div>
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
                                        <div class="invalid-feedback">
                                            Please Enter Password first!
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
                                        <div class="invalid-feedback">
                                            Please Enter Confirm Password first!
                                          </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-lg-12">
                                <div class="card card-secondary">
                                    <div class="card-header">
                                        <h3 class="card-title">Publish</h3>
                                    </div>
                                    <div class="card-body">
                                        <input type="checkbox" name="status" checked data-bootstrap-switch
                                            data-off-color="danger" data-on-color="success">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-start d-flex">

                    <button type="submit" name="submit" id="btnSubmit" class="btn btn-primary w-25">Save Changes</button>

                    <button type="reset" class="btn btn-danger w-25">Reset Branch</button>
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
