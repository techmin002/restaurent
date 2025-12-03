@extends('setting::layouts.master')

@section('title', 'Office Details')
@section('breadcrumb')
<ol class="breadcrumb border-0 m-0">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item active">Offices</li>
</ol>
@endsection

@section('content')

<div class="content-wrapper">

    <!-- Header -->
    <section class="content-header">
        <div class="container-fluid d-flex justify-content-between align-items-center mb-3">
            <h1>Office Details</h1>
            <a href="{{ route('offices.index') }}" class="btn btn-secondary">Back to List</a>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">

            <!-- Office Info -->
            <div class="card shadow mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Office Info</h5>
                </div>

                <div class="card-body d-flex justify-content-around">
                    <p><strong>Office ID:</strong> #OFF000{{ $office->id }}</p>
                    <p><strong>Name:</strong> {{ $office->name }}</p>
                    <p><strong>Address:</strong> {{ $office->address }}</p>
                    <p><strong>Phone:</strong> {{ $office->contact_numbers }}</p>

                    <p><strong>Due Amount:</strong>
                        <span class="badge badge-danger">{{ $latestDue }}</span>
                    </p>

                    <button class="btn btn-success btn-sm"
                        data-toggle="modal"
                        data-target="#payDueModal{{ $office->id }}">
                        Pay Due
                    </button>
                </div>
            </div>


            <!-- Summary Cards -->
            <div class="row justify-content-center mb-4">
                <div class="col-md-3">
                    <div class="card bg-info text-white p-3">
                        <h4>Total Ordered</h4>
                        <h3>Rs. {{ $totalOrdered }}</h3>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card bg-warning text-white p-3">
                        <h4>Total Paid</h4>
                        <h3>Rs. {{ $totalPaid }}</h3>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card bg-primary text-white p-3">
                        <h4>Due Amount</h4>
                        <h3>Rs. {{ $latestDue }}</h3>
                    </div>
                </div>
            </div>


            <!-- Order History -->
            <div class="card shadow mb-4">
                <div class="card-header bg-success text-white">
                    <h5>Order History</h5>
                </div>

                <div class="card-body">
                    <table id="example2" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>S.N</th>
                            <th>Amount</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach ($orders as $order)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $order->grand_total }}</td>
                                <td>{{ $order->order_time }}</td>
                                <td>
                                    <span class="badge {{ $order->status == 'completed' ? 'badge-success':'badge-warning' }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                 <td class="text-center">
    <form action="{{ route('orders.destroy', $order->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this order?');">
        @csrf
        @method('DELETE')
        <button class="btn btn-danger btn-sm">
            <i class="fa fa-trash"></i>
        </button>
    </form>
</td>
                            </tr>
                        @endforeach
                        </tbody>

                    </table>
                </div>
            </div>



            <!-- Payment History -->
            <div class="card shadow mb-4">
                <div class="card-header bg-info text-white">
                    <h5>Payments History</h5>
                </div>

                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>S.N</th>
                            <th>Paid Amount</th>
                            <th>Method</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Remarks</th>
                            <th>Action</th>
                        </tr>
                        </thead>

                        <tbody>
                        @forelse ($office->payments as $payment)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $payment->amount }}</td>
                                <td>{{ ucfirst($payment->payment_method) }}</td>
                                <td>{{ $payment->created_at->format('d M Y') }}</td>
                                <td>
                                    <span class="badge {{ $payment->status == 'paid' ? 'badge-success':'badge-warning' }}">
                                        {{ ucfirst($payment->status) }}
                                    </span>
                                </td>
                                <td>{{ $payment->remarks ?? '-' }}</td>
                                 <td class="text-center">
    <form action="{{ route('payments.destroy', $payment->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this payment?');">
        @csrf
        @method('DELETE')
        <button class="btn btn-danger btn-sm">
            <i class="fa fa-trash"></i>
        </button>
    </form>
</td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="text-center">No payment records.</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>


            <!-- Pay Due Modal -->
            <div class="modal fade" id="payDueModal{{ $office->id }}" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered" style="max-width: 450px;">
                    <div class="modal-content shadow-lg">

                        <form action="{{ route('customers.payDue') }}" method="POST">
                            @csrf
                            <input type="hidden" name="office_id" value="{{ $office->id }}">

                            <div class="modal-header bg-primary text-white">
                                <h5>Pay Due Amount</h5>
                            </div>

                            <div class="modal-body">

                                <div class="text-center mb-4">
                                    <small>Total Due</small>
                                    <h3 class="text-danger">Rs. {{ $latestDue }}</h3>
                                </div>

                                <div id="payment-wrapper">

                                    <div class="single-payment p-3 rounded shadow-sm"
                                         style="background:#f8f9fa; border-left:4px solid #0d6efd;">

                                        <div class="row">

                                            <div class="col-6">
                                                <label>Method</label>
                                                <div class="input-group">
                                                    <select name="payment_method[]" class="form-select payment-method-select">
                                                        <option value="cash" data-img="{{ asset('payment_images/cash.png') }}">Cash</option>
                                                        <option value="card" data-img="{{ asset('payment_images/card.png') }}">Card</option>
                                                        <option value="online" data-img="{{ asset('payment_images/esewa.png') }}">Online</option>
                                                    </select>

                                                    <span class="input-group-text bg-white">
                                                        <img src="{{ asset('payment_images/cash.png') }}" width="35" class="payment-method-img">
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="col-6">
                                                <label>Amount</label>
                                                <input type="number" name="paying_amount[]" class="form-control"
                                                       max="{{ $latestDue }}" placeholder="0.00" required>
                                            </div>

                                        </div>
                                    </div>

                                </div>

                                <div class="form-check mt-3 mb-3">
                                    <input type="checkbox" class="form-check-input" id="multiple_pay">
                                    <label class="form-check-label" for="multiple_pay">Add Multiple Payments</label>
                                </div>

                                <div class="mb-3">
                                    <label>Remarks (Optional)</label>
                                    <textarea class="form-control" name="remarks" rows="2"></textarea>
                                </div>

                            </div>

                            <div class="modal-footer border-0 d-flex justify-content-between">
                                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Pay Now</button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>

        </div>
    </section>

</div>


<!-- JS for payment modal -->
<script>
document.addEventListener('DOMContentLoaded', function () {

    const totalDue = {{ $latestDue }};
    const wrapper = document.getElementById('payment-wrapper');
    const multiplePay = document.getElementById('multiple_pay');

    function attachEvents(row) {

        const select = row.querySelector('.payment-method-select');
        const img = row.querySelector('.payment-method-img');
        const amountInput = row.querySelector('input[name="paying_amount[]"]');

        select.addEventListener('change', function () {
            img.src = select.options[select.selectedIndex].dataset.img;
        });

        amountInput.addEventListener('input', function () {

            let sumOther = 0;

            wrapper.querySelectorAll('input[name="paying_amount[]"]').forEach(inp => {
                if (inp !== amountInput) sumOther += parseFloat(inp.value) || 0;
            });

            const remain = totalDue - sumOther;
            amountInput.max = remain;

            if (parseFloat(amountInput.value) > remain) {
                amountInput.value = remain;
            }
        });
    }

    // first row
    attachEvents(wrapper.querySelector('.single-payment'));

    // Add multiple rows
    multiplePay.addEventListener('change', function () {
        if (this.checked) {
            const clone = wrapper.querySelector('.single-payment').cloneNode(true);

            clone.querySelector('input[name="paying_amount[]"]').value = '';
            clone.querySelector('.payment-method-select').value = 'cash';
            clone.querySelector('.payment-method-img').src =
                "{{ asset('payment_images/cash.png') }}";

            wrapper.appendChild(clone);
            attachEvents(clone);
        } else {
            wrapper.querySelectorAll('.single-payment:not(:first-child)').forEach(el => el.remove());
        }
    });

});
</script>


<script>
$('#example1').DataTable();
$('#example2').DataTable();
</script>

@endsection
