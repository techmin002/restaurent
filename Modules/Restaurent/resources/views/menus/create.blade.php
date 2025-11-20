<div class="modal fade" data-backdrop="static" id="exampleModalCenter" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="border-radius: 8px;">
            <div class="modal-header justify-content-center" style="background-color: #007bff; color: #ffff;">
                <h4 class="modal-title fs-5" id="staticBackdropLabel">Create Menu </h4>
                <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('menus.store') }}" class="needs-validation" enctype="multipart/form-data" novalidate
                id="expenseForm" method="post">
                @csrf
                <div class="modal-body">
                    <div class="container">

                        <div class="row mt-2">
                            <div class="col-lg-12" data-select2-id="select2-data-5-a5wr">
                                <label class="form-label12" for="name">Iteam Name <span
                                        class="text-danger">*</span></label>
                                <input class="form-control" placeholder="Enter Item Name" type="text" name="name"
                                    id="name" required>
                                <div class="invalid-feedback">
                                    Please Enter Item Name first!
                                </div>
                            </div>
                            <div class="col-lg-12" data-select2-id="select2-data-5-a5wr">
                                <label class="form-label12" for="name">Image <small>(optional)</small></label>
                                <input class="form-control" placeholder="Enter Item Name" type="file" name="image"
                                    id="image">

                            </div>
                            <div class="col-lg-12" data-select2-id="select2-data-5-a5wr">
                                <label class="form-label12" for="name">Description <span
                                        class="text-danger">*</span></label>
                                <textarea name="description" class="form-control" id=""></textarea>
                                <div class="invalid-feedback">
                                    Please Enter Description first!
                                </div>
                            </div>
                            <div class="col-lg-12" data-select2-id="select2-data-5-a5wr">
                                <label class="form-label12" for="price">Price <span
                                        class="text-danger">*</span></label>
                                <input class="form-control" placeholder="Enter Price" type="number" name="base_price"
                                    id="price" required>
                                <div class="invalid-feedback">
                                    Please Enter Menu Price first!
                                </div>
                            </div>
                            <div class="col-lg-12 mt-3">
                                <div class="form-check">
                                    <input class="form-check-input" value="1" name="variation_exist"
                                        type="checkbox" id="hasVariationCheckbox">
                                    <label class="form-check-label" for="hasVariationCheckbox">
                                        This Item has variations
                                    </label>
                                </div>
                            </div>

                            <div class="row mt-3" id="variation-section" style="display: none;">
                                <h4>Variations:</h4>
                                <div id="variation-list">
                                    <div>
                                        <div class="row">
                                            <div class="col-lg-6">

                                                <input type="text" name="variations[0][name]" class="form-control"
                                                    placeholder="Variation Name">
                                                <input type="hidden" name="variations[0][restaurent_id]"
                                                    value="{{ auth()->user()->restaurent_id }}">

                                            </div>
                                            <div class="col-lg-5">

                                                <input type="number" step="0.01" name="variations[0][price]"
                                                    class="form-control" placeholder="Price">
                                            </div>
                                            <div class="col-lg-1 d-flex align-items-center">
                                                <button type="button" class="btn btn-success btn-sm"
                                                    onclick="addVariation()">+</button>
                                            </div>
                                          
                                        </div>
                                        {{-- <div class="row mt-2">
                                            <div class="col-lg-12">

                                            </div>
                                        </div> --}}
                                    </div>
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
<script>
    let variationIndex = 1;

    function addVariation() {
        const variationList = document.getElementById('variation-list');

        const html = `
        <div class="variation-item mb-2">
            <div class="row mt-2">
                <div class="col-lg-6">
                    <input type="text" name="variations[${variationIndex}][name]" class="form-control" placeholder="Variation Name">
                    <input type="hidden" name="variations[${variationIndex}][restaurent_id]" value="{{ auth()->user()->restaurent_id }}">

                </div>
                <div class="col-lg-5">
                    <input type="number" step="0.01" name="variations[${variationIndex}][price]" class="form-control" placeholder="Price">
                </div>
                <div class="col-lg-1 d-flex align-items-center">
                    <button type="button" class="btn btn-danger btn-sm remove-variation">×</button>
                </div>
            </div>
        </div>
        `;

        variationList.insertAdjacentHTML('beforeend', html);
        variationIndex++;
    }

    // Event delegation to remove variation
    document.getElementById('variation-list').addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-variation')) {
            e.target.closest('.variation-item').remove();
        }
    });
</script>

<script>
    document.getElementById('hasVariationCheckbox').addEventListener('change', function() {
        const section = document.getElementById('variation-section');
        if (this.checked) {
            section.style.display = 'block';
        } else {
            section.style.display = 'none';
        }
    });
</script>
