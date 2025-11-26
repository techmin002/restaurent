@extends('setting::layouts.master')

@section('title', 'Customers')
@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Customers</li>
    </ol>
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h1>Customer Details</h1>
                    <a href="{{ route('customers.index') }}" class="btn btn-secondary">Back to List</a>
                </div>
            </div>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">

                <!-- Customer Info -->
                <div class="card mb-4 shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Customer Info</h5>
                    </div>
                    <div class="card-body d-flex justify-content-around">
                        <p><strong>Customer ID:</strong> #RCO000{{ $customer->id }}</p>
                        <p><strong>Name:</strong> {{ $customer->name ?? 'N/A' }}</p>
                        <p><strong>Phone:</strong> {{ $customer->phone ?? 'N/A' }}</p>
                        <p><strong>Due Amount:</strong> <span class="badge badge-danger">{{ $latestDue?? 0 }}</span></p>
                         <button type="button" class="btn btn-success btn-sm"
                                                            data-toggle="modal"
                                                            data-target="#payDueModal{{ $customer->id }}">
                                                            Pay-Due
                                                        </button>
                        
                    </div>
                </div>

<section class="content">
  
        <div class="row justify-content-center mb-4">

            <div class="col-md-3">
                <div class="card bg-info text-white p-3 h-100">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <h4>Total Ordered</h4>
                        <h3>Rs.{{ $totalOrdered }}</h3>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card bg-warning text-white p-3 h-100">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <h4>Total Paid</h4>
                        <h3>Rs.{{ $totalPaid }}</h3>
                    </div>
                </div>
            </div>
 
            <div class="col-md-3">
                <div class="card bg-primary text-white p-3 h-100">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <h4>Due Amount</h4>
                        <h3>Rs.{{ $latestDue }}</h3>
                    </div>
                </div>
            </div>

        </div>
     
    
</section>
        


                <!-- Orders Table -->
                <div class="card mb-4 shadow-sm">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">Order History</h5>
                    </div>

                    <div class="card">
                        <div class="card-header">

                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example2" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center">S.N</th>
                                          <th class="text-center">Ordered Amount</th>
                                        <th class="text-center">Date</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $order)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td class="text-center">{{ $order->grand_total }}</td>
                                            <td class="text-center">{{ $order->order_time }}</ }}</td>
                                            <td class="text-center">
                                                <span
                                                    class="badge {{ $order->status == 'completed' ? 'badge-success' : 'badge-warning' }}">
                                                    {{ ucfirst($order->status) }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('customers.show', $order->id) }}"
                                                    class="btn btn-info btn-sm">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th class="text-center">S.N</th>
                                        <th class="text-center">Ordered Amount</th>
                                        <th class="text-center">Date</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>

                </div>

                <!-- Payments Table -->
                <div class="card mb-4 shadow-sm">
                    <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Payments History</h5>

                    </div>
                    <div class="card">
                        <div class="card-header">

                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center">S.N</th>
                                        <th class="text-center">Paid Amount</th>
                                        <th class="text-center">Payment Method</th>
                                        <th class="text-center">Date</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Remarks</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($customer->payments as $payment)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td class="text-center">{{ $payment->amount }}</td>
                                            <td class="text-center">{{ ucfirst($payment->payment_method) }}</td>
                                            <td class="text-center">{{ $payment->created_at->format('d M Y') }}</td>
                                            <td class="text-center">
                                                <span
                                                    class="badge {{ $payment->status == 'paid' ? 'badge-success' : 'badge-warning' }}">
                                                    {{ ucfirst($payment->status) }}
                                                </span>
                                            </td>
                                            <td class="text-center">{{ $payment->remarks ?? '-' }}</td>
                                            <td class="text-center">
                                                <a href="{{ route('customers.show', $payment->id) }}"
                                                    class="btn btn-info btn-sm">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center">No payments found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th class="text-center">S.N</th>
                                        <th class="text-center">Paid Amount</th>
                                        <th class="text-center">Payment Method</th>
                                        <th class="text-center">Date</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Remarks</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>

<!-- Pay Due Modal -->
<div class="modal fade" id="payDueModal{{ $customer->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 450px;">
        <div class="modal-content border-0 shadow-lg rounded-3">

            <form action="{{ route('customers.payDue') }}" method="POST">
                @csrf
                <input type="hidden" name="customer_id" value="{{ $customer->id }}">

                <!-- Header -->
                <div class="modal-header bg-primary text-white py-3">
                    <h5 class="modal-title fw-bold">Pay Due Amount</h5>
                </div>

                <!-- Body -->
                <div class="modal-body">

                    <!-- Due Amount Display -->
                    <div class="text-center mb-4">
                        <small class="text-muted d-block">Total Due</small>
                        <div class="h3 text-danger fw-bold">Rs. {{ $latestDue }}</div>
                    </div>

                    <!-- Payment Wrapper -->
                    <div id="payment-wrapper">

                        <div class="payment-row p-3 rounded shadow-sm mb-3 single-payment" style="background: #f8f9fa; border-left: 4px solid #0d6efd;">
                            <div class="row g-2">

                                <!-- Payment Method -->
                                <div class="col-6">
                                    <label class="form-label fw-semibold">Method</label>
                                    <div class="input-group">
                                        <select name="payment_method[]" class="form-select payment-method-select">
                                            <option value="cash" data-img="{{ asset('payment_images/cash.png') }}">Cash</option>
                                            <option value="card" data-img="{{ asset('payment_images/card.png') }}">Card</option>
                                            <option value="online" data-img="{{ asset('payment_images/esewa.png') }}">Online</option>
                                        </select>
                                        <span class="input-group-text bg-white">
                                            <img src="{{ asset('payment_images/cash.png') }}" class="payment-method-img" width="35">
                                        </span>
                                    </div>
                                </div>

                                <!-- Amount -->
                                <div class="col-6">
                                    <label class="form-label fw-semibold">Amount</label>
                                    <input type="number" name="paying_amount[]" max="{{ $latestDue }}" 
                                           class="form-control" placeholder="0.00" required>
                                </div>

                            </div>
                        </div>

                    </div>

                    <!-- Multiple Pay Checkbox -->
                    <div class="form-check mb-3">
                        <input type="checkbox" class="form-check-input" id="multiple_pay">
                        <label for="multiple_pay" class="form-check-label fw-semibold">Add Multiple Payments</label>
                    </div>

                    <!-- Remarks -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Remarks (Optional)</label>
                        <textarea class="form-control" name="remarks" rows="2" placeholder="Add a note…"></textarea>
                    </div>
                </div>

                <!-- Footer -->
                <div class="modal-footer border-0 d-flex justify-content-between px-3 py-2">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary px-4">Pay Now</button>
                </div>

            </form>
        </div>
    </div>
</div>

<!-- Hidden Images for JS -->
<input type="hidden" id="img_cash" value="{{ asset('payment_images/cash.png') }}">
<input type="hidden" id="img_card" value="{{ asset('payment_images/card.png') }}">
<input type="hidden" id="img_online" value="{{ asset('payment_images/esewa.png') }}">



            </div><!-- /.container-fluid -->
        </section>
    </div>


<script>
document.addEventListener('DOMContentLoaded', function () {

    const totalDue = parseFloat({{ $latestDue }});
    const wrapper = document.getElementById('payment-wrapper');
    const multiplePay = document.getElementById('multiple_pay');

    // Add / attach events to a payment row
    function attachRowEvents(row) {
        const select = row.querySelector('.payment-method-select');
        const img = row.querySelector('.payment-method-img');
        const amountInput = row.querySelector('input[name="paying_amount[]"]');

        // Payment method change → update image
        select.addEventListener('change', function() {
            img.src = select.options[select.selectedIndex].dataset.img;
        });

        // Amount input → enforce max total due
        amountInput.addEventListener('input', function() {
            let sumOther = 0;
            wrapper.querySelectorAll('input[name="paying_amount[]"]').forEach(i => {
                if (i !== amountInput) sumOther += parseFloat(i.value) || 0;
            });
            const remaining = totalDue - sumOther;
            amountInput.max = remaining;
            if (parseFloat(amountInput.value) > remaining) amountInput.value = remaining;
        });
    }

    // Attach events to initial row
    attachRowEvents(wrapper.querySelector('.single-payment'));

    // Checkbox: add/remove multiple payment rows
    multiplePay.addEventListener('change', function() {
        if (this.checked) {
            const originalRow = wrapper.querySelector('.single-payment');
            const clone = originalRow.cloneNode(true);

            // Reset cloned row
            clone.querySelector('input[name="paying_amount[]"]').value = '';
            clone.querySelector('.payment-method-select').value = 'cash';
            clone.querySelector('.payment-method-img').src = document.getElementById('img_cash').value;

            wrapper.appendChild(clone);
            attachRowEvents(clone);
        } else {
            wrapper.querySelectorAll('.single-payment:not(:first-child)').forEach(el => el.remove());
        }
    });

    // Form submit validation
    const form = wrapper.closest('form');
    form.addEventListener('submit', function(e) {
        let sum = 0;
        wrapper.querySelectorAll('input[name="paying_amount[]"]').forEach(input => {
            sum += parseFloat(input.value) || 0;
        });
        if (sum > totalDue) {
            e.preventDefault();
            alert('Total payment exceeds due amount!');
        }
    });

});
</script>






@endsection

<script>

    document.addEventListener('DOMContentLoaded', function () {
        // Select all payment-method selects
        document.querySelectorAll('.payment-method-select').forEach(function(select) {
            select.addEventListener('change', function() {
                // Get the closest input-group parent
                const inputGroup = select.closest('.input-group');
                if (!inputGroup) return;

                // Find the image inside the input group
                const img = inputGroup.querySelector('.payment-method-img');
                if (!img) return;

                // Update the image source
                const newSrc = select.options[select.selectedIndex].dataset.img;
                if (newSrc) {
                    img.src = newSrc;
                }
            });
        });
    });

               $('#example2').DataTable({
        "paging": true,
        "searching": true,
        "ordering": true,
        "info": true
    });
</script>


