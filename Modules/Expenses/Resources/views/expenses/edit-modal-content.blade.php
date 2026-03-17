<!-- resources/views/expenses/expenses/edit-modal-content.blade.php -->
<div class="modal-header">
    <h5 class="modal-title">Edit Expense</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<form id="editExpenseForm" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="modal-body">
        <div class="form-group">
            <label for="edit_title">Title <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="edit_title" name="title" value="{{ $expense->title }}" required>
        </div>

        <div class="form-group">
            <label for="edit_amount">Amount <span class="text-danger">*</span></label>
            <input type="number" step="0.01" class="form-control" id="edit_amount" name="amount" value="{{ $expense->amount }}" required>
        </div>

        <div class="form-group">
            <label for="edit_date">Date <span class="text-danger">*</span></label>
            <input type="date" class="form-control" id="edit_date" name="date" value="{{ $expense->date }}" required>
        </div>

        <div class="form-group">
            <label for="edit_mode">Payment Mode <span class="text-danger">*</span></label>
            <select class="form-control" id="edit_mode" name="mode" required>
                <option value="">Select Mode</option>
                <option value="Cash" {{ $expense->mode == 'Cash' ? 'selected' : '' }}>Cash</option>
                <option value="Cheque" {{ $expense->mode == 'Cheque' ? 'selected' : '' }}>Cheque</option>
                <option value="Bank Transfer" {{ $expense->mode == 'Bank Transfer' ? 'selected' : '' }}>Bank Transfer</option>
                <option value="Card" {{ $expense->mode == 'Card' ? 'selected' : '' }}>Card</option>
                <option value="Digital Payment" {{ $expense->mode == 'Digital Payment' ? 'selected' : '' }}>Digital Payment</option>
            </select>
        </div>

        <div class="form-group">
            <label for="edit_expense_category_id">Expense Category <span class="text-danger">*</span></label>
            <select class="form-control" id="edit_expense_category_id" name="expense_category_id" required>
                <option value="">Select Category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ $expense->expense_category_id == $category->id ? 'selected' : '' }}>
                        {{ $category->title }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="edit_receipt">Receipt (PDF/Image)</label>
            <div class="custom-file">
                <input type="file" class="custom-file-input" id="edit_receipt" name="receipt" accept="image/*,.pdf">
                <label class="custom-file-label" for="edit_receipt">Choose file</label>
            </div>
            @if($expense->receipt)
                <small class="form-text text-muted mt-2">
                    Current file: 
                    <a href="{{ asset('upload/images/expenses-receipt/' . $expense->receipt) }}" target="_blank">
                        View current receipt
                    </a>
                </small>
            @endif
        </div>

        <div class="form-group">
            <label for="edit_description">Description</label>
            <textarea class="form-control" id="edit_description" name="description" rows="3">{{ $expense->description }}</textarea>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary">Update Expense</button>
    </div>
</form>