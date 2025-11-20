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
    <div class="modal-dialog modal-dialog-centered modal-sm" style="max-width: 400px;">
        <div class="modal-content border-0 shadow">

            <form action="{{ route('customers.payDue') }}" method="POST">
                @csrf
                <input type="hidden" name="customer_id" value="{{ $customer->id }}">

                <!-- Header -->
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title fw-bold">Pay Due Amount</h5>
                </div>

                <!-- Body -->
                <div class="modal-body">

                    <!-- Due Amount -->
                    <div class="text-center mb-4">
                        <small class="text-muted d-block">Total Due</small>
                        <div class="h3 text-danger fw-bold">Rs. {{ $latestDue }}</div>
                    </div>

                    <!-- Payment Method -->
                   <div class="d-flex align-items-center mb-3">

                         <div class="mb-3">
                        <label class="form-label fw-semibold">Payment Method</label>

                        <div class="input-group">
                            <select name="payment_method" class="form-select payment-method-select">
                                <option value="cash" data-img="{{ asset('payment_images/cash.png') }}">Cash</option>
                                <option value="card" data-img="{{ asset('payment_images/card.png') }}">Card</option>
                                <option value="online" data-img="{{ asset('payment_images/esewa.png') }}">Online</option>
                            </select>

                            <span class="input-group-text bg-white">
                                <img src="{{ asset('payment_images/cash.png') }}" alt="method" 
                                     class="payment-method-img" width="40" height="40">
                            </span>
                        </div>
                    </div>

                    <!-- Amount -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Amount to Pay</label>
                        <input type="number" name="paying_amount" max="{{ $latestDue }}"
                               class="form-control" placeholder="Enter amount" required>
                    </div> 
                   </div>
                           <input type="checkbox" class="newline"> <label>multiple pay</label>
            
                 
                

                    <!-- Remarks -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Remarks (Optional)</label>
                        <textarea class="form-control" name="remarks" rows="2" placeholder="Add a note…"></textarea>
                    </div>

                </div>

                <!-- Footer -->
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
                        Cancel
                    </button>

                    <button type="submit" class="btn btn-primary">
                        Pay Now
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>


            </div><!-- /.container-fluid -->
        </section>
    </div>

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
