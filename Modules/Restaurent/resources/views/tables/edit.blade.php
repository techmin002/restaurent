<!-- Trigger button for the modal -->
<a data-toggle="modal" data-target="#editModal{{ $table->id }}" class="btn btn-primary btn-sm">
    <i class="fa fa-edit"></i>
</a>

<!-- Modal Structure -->
<div class="modal fade" data-backdrop="static" id="editModal{{ $table->id }}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel{{ $table->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="border-radius: 8px;">
            <div class="modal-header justify-content-center" style="background-color: #007bff; color: #ffff;">
                <h4 class="modal-title" id="editModalLabel{{ $table->id }}">Edit Section</h4>
                <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('tables.update', $table->id) }}" class="needs-validation" novalidate id="branchEditForm{{ $table->id }}" method="post">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="container">

                        <div class="row mt-2">
                            <div class="col-lg-12">
                                <label class="form-label" for="name">Section Name <span class="text-danger">*</span></label>
                                <input class="form-control" placeholder="Enter Section name" type="text" name="table_no" id="name{{ $table->id }}" value="{{ $table->table_number }}" required>
                                <div class="invalid-feedback">
                                    Please enter the Section name.
                                </div>
                            </div>
                            <div class="col-lg-12" data-select2-id="select2-data-5-a5wr">
                                <label class="form-label12" for="capacity">People Capacity <span
                                        class="text-danger">*</span></label>
                                <input class="form-control" placeholder="Enter People Capacity" value="{{ $table->capacity }}"  type="number"
                                    name="capacity" id="capacity" required>
                                    <div class="invalid-feedback">
                                        Please Enter People Capacity!

                                    </div>
                            </div>
                            <div class="col-lg-12" data-select2-id="select2-data-5-a5wr">
                                <label class="form-label12" for="section_id">Section <small>(optional)</small> </label>
                               <select name="section_id" id="" class="form-control">
                                <option value="" selected disabled>Select Section where table exist</option>
                                @foreach ($sections as $section)
                                <option value="{{ $section['id'] }}" @if($section['id'] == $table['section_id']) selected @endif>{{ $section['name'] }}</option>
                                @endforeach
                               </select>

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
        $("#show_hide_password{{ $table->id }} button").on('click', function(event) {
            event.preventDefault();
            var input = $('#show_hide_password{{ $table->id }} input');
            var icon = $('#show_hide_password{{ $table->id }} i');
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

        $("#show_hide_confirm_password{{ $table->id }} button").on('click', function(event) {
            event.preventDefault();
            var input = $('#show_hide_confirm_password{{ $table->id }} input');
            var icon = $('#show_hide_confirm_password{{ $table->id }} i');
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
