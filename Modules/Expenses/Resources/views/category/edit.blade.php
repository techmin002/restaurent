<div class="modal fade" id="editCategory{{ $exp->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border-radius: 8px;">
            <div class="modal-header justify-content-center" style="background-color: #0837a4; color: #ffff;">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Category </h1>
            </div>
            <form action="{{ route('expenses-categories.update',$exp->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="container">
                        <div class="row gy-3">

                            <div class="col-lg-6">
                                <div class="form-group">
                                <label class="form-label12">Title</label>
                                <input class="form-control" placeholder="Enter Vendor Name" value="{{ $exp->title }}" type="text"
                                    name="title" id="vendor">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                <label class="form-label12">image</label>
                                <input class="form-control" placeholder="Enter Title" type="file" name="image"
                                    id="image">
                                    <img src="{{  asset('upload/images/expenses-category/'.$exp->image)  }}" height="100px" alt="">
                                </div>
                            </div>
                            
                            <div class="col-lg-12" data-select2-id="select2-data-5-a5wr">
                                <div class="form-group">
                                <label class="form-label12">Branch </label>
                                <select class="form-control" name="branch_id">
                                    <option value="" selected disabled>Select Branch</option>
                                    @foreach ($branches as $branch)
                                        <option value="{{ $branch->id }}" @if($branch->id == $exp->branch_id) selected @endif>{{ $branch->name }}</option>
                                    @endforeach
                                </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                <label class="form-label12">Description</label>
                                <textarea name="description" id="" class="form-control">{{ $exp->description }}</textarea>
                            </div>
                            </div>
                            <div class="col-md-12 mt-2">
                                <!-- Bootstrap Switch -->
                                <div class="card card-secondary">
                                    <div class="card-header">
                                        <h3 class="card-title">Publish</h3>
                                    </div>
                                    <div class="card-body">
                                        <input type="checkbox" name="status" @if($branch->id == $exp->branch_id) checked @endif data-bootstrap-switch
                                            data-off-color="danger" data-on-color="success">
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-center">

                    <button type="submit" name="submit" id="btnSubmit" class="btn btn-success">Save Item</button>
        
                    <button type="cancel" data-dismiss="modal" class="btn btn-danger">Cancel</button>
                </div>
        </div>
        
        </form>
        <span id="output"></span>
    </div>
</div>
</div>
