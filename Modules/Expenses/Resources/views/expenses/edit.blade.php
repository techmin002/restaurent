<div class="modal fade" id="editCategory{{ $exp->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border-radius: 8px;">
            <div class="modal-header justify-content-center" style="background-color: #08A4A4; color: #ffff;">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Expenses </h1>
            </div>
            <form action="{{ route('expenses.update',$exp->id) }}" id="expenseForm" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="container">
                        <div class="row gy-3">


                            <div class="mt-3 col-lg-6">
                                <label class="form-label12">Title</label>
                                <input class="form-control" placeholder="Enter Title" value="{{ $exp->title }}" type="text" name="title" id="title">
                            </div>
                            <div class="mt-3 col-lg-6">
                                <label class="form-label12">Amount (INR)</label>
                                <input class="form-control" placeholder="" type="text" value="{{ $exp->amount }}" name="amount">
                            </div>
                            <div class="mt-3 col-lg-6">
                                <label class="form-label12">Date</label>
                                <input class="form-control" placeholder="" type="date" value="{{ old('date', $exp->date) }}" name="date" id="date">
                            </div>

                            <div class="mt-3 col-lg-6">
                                <label class="form-label12">Mode of Payment</label>
                                <select class="form-control" name="mode">
                                    <option value="" selected disabled>Select Payment Mode</option>
                                    <option value="petty cash" {{ old('mode', $exp->mode) == 'petty cash' ? 'selected' : '' }}>Petty Cash</option>
                                    <option value="online" {{ old('mode', $exp->mode) == 'online' ? 'selected' : '' }}>Online</option>
                                    <option value="cheque" {{ old('mode', $exp->mode) == 'cheque' ? 'selected' : '' }}>Cheque</option>
                                </select>
                            </div>

                            <div class="mt-3 col-lg-6">
                                <label class="form-label12">Expense Type</label>
                                <select class="form-control" name="categoryId">
                                    <option value="" selected disabled>Select Expense Category</option>
                                    @foreach ($categories as $cat)
                                        <option value="{{ $cat->id }}" {{ old('categoryId', $exp->expense_category_id) == $cat->id ? 'selected' : '' }}>
                                            {{ $cat->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mt-3 col-lg-6" data-select2-id="select2-data-5-a5wr">
                                <label class="form-label12">Receipt <small>(Optional)</small></label>
                                <input type="file" class="form-contro" name="receipt">
                                <img src="{{ asset('upload/images/expenses-receipt/'.$exp->receipt) }}" style="width: 100px" alt="">
                            </div>
                            <div class="mt-3 col-lg-12">
                                <label class="form-label12">Branch </label>
                                <select class="form-control" name="branchId">
                                    <option value="" selected disabled>Select Branch</option>
                                    @foreach ($branches as $cat)
                                        <option value="{{ $cat->id }}" {{ old('branchId', $exp->branch_id) == $cat->id ? 'selected' : '' }}>
                                            {{ $cat->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mt-3 col-lg-12">
                                <label class="form-label12">Description <small>(Optional)</small></label>
                                <textarea name="description" class="form-control" id="">{{ $exp->description }}</textarea>
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
