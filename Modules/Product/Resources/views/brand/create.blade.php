<div class="modal fade" data-backdrop="static" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-lg"  role="document">
        <div class="modal-content" style="border-radius: 8px;">
            <div class="modal-header justify-content-center" style="background-color: #007bff; color: #ffff;">
                <h4 class="modal-title fs-5" id="staticBackdropLabel">Create Brand </h4>
                <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
            </div>
            <form action="{{ route('products-brands.store') }}" class="needs-validation" novalidate id="expenseForm" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="container">
                        <div class="form-row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" class="form-control"
                                        placeholder="Enter name " value="{{ old('name') }}" required>
                                    @error('name')
                                        <p style="color: red">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="description">Description( <small>Optional</small> )</label>
                                    <textarea type="text" name="description" class="form-control" placeholder="Enter Short description">{{ old('description') }}</textarea>
                                    @error('description')
                                        <p style="color: red">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="image">Image </label>

                                    <input type="file" id="file-ip-1" accept="image/*"
                                        class="form-control-file border" value="{{ old('image') }}"
                                        onchange="showPreview1(event);" name="image">
                                    @error('image')
                                        <p style="color: red">{{ $message }}</p>
                                    @enderror
                                    <div class="preview mt-2">
                                        <img src="" id="file-ip-1-preview" width="200px">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <!-- Bootstrap Switch -->
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
