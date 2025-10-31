<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border-radius: 8px;">
            <div class="modal-header justify-content-center" style="background-color: #08A4A4; color: #ffff;">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Add Expenses </h1>
            </div>
            <form action="{{ route('expenses.store') }}" id="expenseForm" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="container">
                        <div class="row gy-3">


                            <div class="mt-3 col-lg-6">
                                <label class="form-label12">Title</label>
                                <input class="form-control" placeholder="Enter Title" type="text" name="title" id="title">
                            </div>
                            <div class="mt-3 col-lg-6">
                                <label class="form-label12">Amount (INR)</label>
                                <input class="form-control" placeholder="" type="text" name="amount">
                            </div>
                            <div class="mt-3 col-lg-6">
                                <label class="form-label12">Date</label>
                                <input class="form-control" placeholder="" type="date" name="date" id="date">
                            </div>
                            <div class="mt-3 col-lg-6">
                                <label class="form-label12">Mode of Payment </label>
                                <select class="form-control" name="mode">
                                    <option value="" selected disabled>Select Payment Mode</option>
                                    <option value="petty cash">Petty Cash</option>
                                    <option value="online">Online</option>
                                    <option value="cheque">Cheque</option>
                                </select>
                            </div>

                            <div class="mt-3 col-lg-6" data-select2-id="select2-data-5-a5wr">
                                <label class="form-label12">Expense Type</label>
                                <select class="form-control" name="categoryId">
                                <option value="1" selected disabled>Select Expense Category</option>
                                @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->title }}</option>
                                @endforeach
                                </select>
                            </div>

                            <div class="mt-3 col-lg-6" data-select2-id="select2-data-5-a5wr">
                                <label class="form-label12">Receipt <small>(Optional)</small></label>
                                <input type="file" class="form-contro" name="receipt">
                            </div>
                            <div class="mt-3 col-lg-12" data-select2-id="select2-data-5-a5wr">
                                <label class="form-label12">Branch</label>
                                <select class="form-control" name="branchId">
                                <option value="1" selected disabled>Select Branch</option>
                                @foreach ($branches as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                                </select>
                            </div>
                            <div class="mt-3 col-lg-12">
                                <label class="form-label12">Description <small>(Optional)</small></label>
                                <textarea name="description" class="form-control" id=""></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-start">

                    <button type="submit" name="submit" id="btnSubmit" class="btn btn-success">Save Item</button>

                    <button type="cancel" data-dismiss="modal" class="btn btn-danger">Cancel</button>
                </div>
            </form>
            <span id="output"></span>
        </div>
    </div>
  </div>
