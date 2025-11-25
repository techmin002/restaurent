<!-- Trigger button for the modal -->
<a data-toggle="modal" data-target="#editModal{{ $menu->id }}" class="btn btn-primary btn-sm">
    <i class="fa fa-edit"></i>
</a>

<!-- Modal Structure -->
<div class="modal fade" data-backdrop="static" id="editModal{{ $menu->id }}" tabindex="-1" role="dialog"
    aria-labelledby="editModalLabel{{ $menu->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border-radius: 8px;">
            <div class="modal-header justify-content-center" style="background-color: #007bff; color: #ffff;">
                <h4 class="modal-title" id="editModalLabel{{ $menu->id }}">Edit Section</h4>
                <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('menus.update', $menu->id) }}" enctype="multipart/form-data" class="needs-validation" novalidate
                id="branchEditForm{{ $menu->id }}" method="post">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="container">

                        <div class="row mt-2">
                            <div class="col-lg-12" data-select2-id="select2-data-5-a5wr">
                                <label class="form-label12" for="name">Iteam Name <span
                                        class="text-danger">*</span></label>
                                <input class="form-control" placeholder="Enter Item Name" value="{{ $menu['name'] }}"
                                    type="text" name="name" id="name" required>
                                <div class="invalid-feedback">
                                    Please Enter Item Name first!
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <label class="form-label12" for="name">Category <span
                                        class="text-danger">*</span></label>
                                <select name="category_id" class="form-control" required>
                                    <option value="">Select Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" @if ($menu['category_id'] == $category->id) selected @endif>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-12" data-select2-id="select2-data-5-a5wr">
                                <label class="form-label12" for="name">Image <small>(optional)</small></label>
                                <input class="form-control" placeholder="Enter Item Name" type="file" name="image"
                                    id="image">
                                <img src="{{ asset('upload/images/menu/' . $menu['image']) }}"
                                    style="height: 100px;width:100px" alt="">
                            </div>
                            <div class="col-lg-12" data-select2-id="select2-data-5-a5wr">
                                <label class="form-label12" for="name">Description <span
                                        class="text-danger">*</span></label>
                                <textarea name="description" class="form-control" id="">{{ $menu['description'] }}</textarea>
                                <div class="invalid-feedback">
                                    Please Enter Description first!
                                </div>
                            </div>
                            <div class="col-lg-12" data-select2-id="select2-data-5-a5wr">
                                <label class="form-label12" for="price">Price <span
                                        class="text-danger">*</span></label>
                                <input class="form-control" placeholder="Enter Price" value="{{ $menu['price'] }}"
                                    type="number" name="base_price" id="price" required>
                                <div class="invalid-feedback">
                                    Please Enter Menu Price first!
                                </div>
                            </div>
                            <div class="col-lg-12 mt-3">
                                <div class="form-check">
                                    <input class="form-check-input hasVariationCheckboxEdit" type="checkbox"
                                        {{ $menu->variations->count() ? 'checked' : '' }}
                                        data-id="{{ $menu->id }}">
                                    <label class="form-check-label">
                                        This Item has variations
                                    </label>
                                </div>
                            </div>


                            <div class="row mt-3" id="variation-section-edit-{{ $menu->id }}"
                                style="{{ $menu->variations->count() ? '' : 'display: none;' }}">
                                <h4>Variations:</h4>
                                <div id="variation-list-edit-{{ $menu->id }}">
                                    @foreach ($menu->variations as $vIndex => $variation)
                                        <div class="variation-item mb-2">
                                            <div class="row mt-2">
                                                <div class="col-lg-6">
                                                    <input type="text" name="variations[{{ $vIndex }}][name]"
                                                        class="form-control" value="{{ $variation->name }}"
                                                        placeholder="Variation Name" required>
                                                    <input type="hidden" name="variations[{{ $vIndex }}][id]"
                                                        value="{{ $variation->id }}">
                                                </div>
                                                <div class="col-lg-5">
                                                    <input type="number" step="0.01"
                                                        name="variations[{{ $vIndex }}][price]"
                                                        class="form-control" value="{{ $variation->price }}"
                                                        placeholder="Price" required>
                                                </div>
                                                <div class="col-lg-1 d-flex align-items-center">
                                                    <button type="button"
                                                        class="btn btn-danger btn-sm remove-variation">×</button>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    <button type="button" class="btn btn-success btn-sm"
                                        onclick="addVariation({{ $menu->id }})">Add New Variation</button>

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
    function addVariation(menuId) {
        const list = document.getElementById('variation-list-edit-' + menuId);
        const index = list.querySelectorAll('.variation-item').length;

        const html = `
        <div class="variation-item mb-2">
            <div class="row mt-2">
                <div class="col-lg-6">
                    <input type="text" name="variations[${index}][name]" class="form-control" placeholder="Variation Name" required>
                </div>
                <div class="col-lg-5">
                    <input type="number" step="0.01" name="variations[${index}][price]" class="form-control" placeholder="Price" required>
                </div>
                <div class="col-lg-1 d-flex align-items-center">
                    <button type="button" class="btn btn-danger btn-sm remove-variation">×</button>
                </div>
            </div>
        </div>
        `;

        list.insertAdjacentHTML('beforeend', html);
    }

    // Remove variation
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-variation')) {
            e.target.closest('.variation-item').remove();
        }
    });
</script>


<script>
    document.querySelectorAll('.hasVariationCheckboxEdit').forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            const menuId = this.getAttribute('data-id');
            const section = document.getElementById('variation-section-edit-' + menuId);
            if (this.checked) {
                section.style.display = 'block';
            } else {
                section.style.display = 'none';
            }
        });
    });
</script>
