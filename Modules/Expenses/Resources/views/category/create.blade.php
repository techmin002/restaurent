<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border-radius: 8px;">
            <div class="modal-header justify-content-center" style="background-color: #0837a4; color: #ffff;">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Add Category</h1>
            </div>
            <form action="{{ route('expenses-categories.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="container">
                        <div class="row gy-3">

                            <div class="mt-3 col-lg-6">
                                <label class="form-label12">Title</label>
                                <input class="form-control" placeholder="Enter Vendor Name" type="text"
                                    name="title" id="vendor">
                            </div>

                            <div class="mt-3 col-lg-6">
                                <label class="form-label12">Image</label>
                                <input class="form-control" type="file" name="image" id="image">
                            </div>

                            <div class="mt-3 col-lg-12">
                                <label class="form-label12">Branch</label>
                                <select class="form-control" name="branch_id">
                                    <option value="" selected disabled>Select Branch</option>
                                    @foreach ($branches as $branch)
                                        <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mt-3 col-md-12">
                                <label class="form-label12">Description</label>
                                <textarea name="description" class="form-control"></textarea>
                            </div>

                            <div class="mt-3 col-md-12">
                                <label class="form-label12">Publish</label><br>
                                <input type="checkbox" name="status" checked data-bootstrap-switch
                                    data-off-color="danger" data-on-color="success">
                            </div>

                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-start">
                    <button type="submit" name="submit" id="btnSubmit" class="btn btn-success">Save Item</button>
                    <button type="button" data-dismiss="modal" class="btn btn-danger">Cancel</button>
                </div>
            </form>
            <span id="output"></span>
        </div>
    </div>
</div>
