<!-- Modal for Creating Technical Tool -->
<div class="modal fade" id="createTechnicalToolModal" tabindex="-1" role="dialog" aria-labelledby="createModalTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border-radius: 8px;">
            <div class="modal-header justify-content-center" style="background-color: #0837a4; color: #fff;">
                <h1 class="modal-title fs-5" id="createModalTitle">Add Technical Tool</h1>
            </div>
            <form action="{{ route('technicaltools.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="container">
                        <div class="row gy-3">
                            <div class="col-lg-6">
                                <label class="form-label12">Tool Name</label>
                                <input class="form-control" type="text" name="tool_name"
                                    placeholder="Enter tool name" required>
                            </div>

                            <div class="col-lg-6">
                                <label class="form-label12">Model Name</label>
                                <input class="form-control" type="text" name="model_name"
                                    placeholder="Enter model name">
                            </div>

                            <div class="col-lg-6">
                                <label class="form-label12">Price</label>
                                <input class="form-control" type="number" step="0.01" name="price"
                                    placeholder="Enter price" required>
                            </div>

                            <div class="col-lg-6">
                                <label class="form-label12">Stock Quantity</label>
                                <input class="form-control" type="number" name="stock"
                                    placeholder="Enter stock quantity" required>
                            </div>

                            <div class="col-lg-6">
                                <label class="form-label12">Image</label>
                                <input class="form-control" type="file" accept="image/*" name="image" required>
                            </div>

                            <div class="col-lg-12">
                                <label class="form-label12">Description</label>
                                <textarea class="form-control" name="description" rows="3" placeholder="Enter description" required></textarea>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label12">Publish</label><br>
                                <input type="checkbox" name="status" checked data-bootstrap-switch
                                    data-off-color="danger" data-on-color="success">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer justify-content-start">
                    <button type="submit" class="btn btn-success">Save Tool</button>
                    <button type="button" data-dismiss="modal" class="btn btn-danger">Cancel</button>
                </div>
            </form>
        </div>
        <span id="output"></span>
    </div>
</div>
