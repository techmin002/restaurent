<div class="modal fade" data-backdrop="static" id="exampleModalCenter" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
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
                                <label class="form-label12" for="name">Item Name <span
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
                                <label class="form-label12" for="description">Description <span
                                        class="text-danger">*</span></label>
                                <textarea name="description" class="form-control" id="description" required></textarea>
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
                            <div class="col-lg-12" data-select2-id="select2-data-5-a5wr">
                                <label class="form-label12" for="category_id">Category <span
                                        class="text-danger">*</span></label>
                                <select name="category_id" id="category_id" class="form-control" required   >
                                    <option value="" disabled selected>Select Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">
                                    Please Select Category first!
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
                                    <div class="variation-item mb-2">
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
                                                <button type="button" class="btn btn-success btn-sm add-variation">+</button>
                                            </div>
                                          
                                        </div>
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
    document.addEventListener('DOMContentLoaded', function() {
        // Form validation
        (function() {
            'use strict';
            window.addEventListener('load', function() {
                var forms = document.getElementsByClassName('needs-validation');
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

        // Variation functionality
        let variationIndex = 1;

        function addVariation() {
            const variationList = document.getElementById('variation-list');
            
            if (!variationList) {
                console.error('Variation list element not found');
                return;
            }

            const html = `
            <div class="variation-item mb-2">
                <div class="row">
                    <div class="col-lg-6">
                        <input type="text" name="variations[${variationIndex}][name]" class="form-control" placeholder="Variation Name" required>
                        <input type="hidden" name="variations[${variationIndex}][restaurent_id]" value="{{ auth()->user()->restaurent_id }}">
                    </div>
                    <div class="col-lg-5">
                        <input type="number" step="0.01" name="variations[${variationIndex}][price]" class="form-control" placeholder="Price" required>
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

        // Event delegation for variation buttons
        document.addEventListener('click', function(e) {
            // Add variation
            if (e.target.classList.contains('add-variation')) {
                addVariation();
            }
            
            // Remove variation
            if (e.target.classList.contains('remove-variation')) {
                const variationItem = e.target.closest('.variation-item');
                if (variationItem) {
                    variationItem.remove();
                }
            }
        });

        // Checkbox change event
        const variationCheckbox = document.getElementById('hasVariationCheckbox');
        if (variationCheckbox) {
            variationCheckbox.addEventListener('change', function() {
                const section = document.getElementById('variation-section');
                if (section) {
                    section.style.display = this.checked ? 'block' : 'none';
                    
                    // Add required attribute to variation fields when section is visible
                    const variationInputs = section.querySelectorAll('input[type="text"], input[type="number"]');
                    variationInputs.forEach(input => {
                        if (this.checked) {
                            input.setAttribute('required', 'required');
                        } else {
                            input.removeAttribute('required');
                        }
                    });
                }
            });
        }

        // Handle form submission for variations
        const expenseForm = document.getElementById('expenseForm');
        if (expenseForm) {
            expenseForm.addEventListener('submit', function(e) {
                const hasVariations = document.getElementById('hasVariationCheckbox').checked;
                const variationSection = document.getElementById('variation-section');
                
                if (hasVariations && variationSection.style.display !== 'none') {
                    const variationItems = document.querySelectorAll('.variation-item');
                    let hasEmptyVariations = false;
                    
                    variationItems.forEach(item => {
                        const nameInput = item.querySelector('input[type="text"]');
                        const priceInput = item.querySelector('input[type="number"]');
                        
                        if (!nameInput.value.trim() || !priceInput.value) {
                            hasEmptyVariations = true;
                            if (!nameInput.value.trim()) {
                                nameInput.classList.add('is-invalid');
                            }
                            if (!priceInput.value) {
                                priceInput.classList.add('is-invalid');
                            }
                        }
                    });
                    
                    if (hasEmptyVariations) {
                        e.preventDefault();
                        e.stopPropagation();
                        alert('Please fill in all variation fields or uncheck "This Item has variations".');
                    }
                }
            });
        }

        // Real-time validation for variation fields
        document.addEventListener('input', function(e) {
            if (e.target.closest('.variation-item')) {
                if (e.target.value.trim()) {
                    e.target.classList.remove('is-invalid');
                }
            }
        });
    });
</script>