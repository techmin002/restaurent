@extends('setting::layouts.master')
<meta name="csrf-token" content="{{ csrf_token() }}">

@section('title', 'Orders')

@section('content')
    <div class="content-wrapper">
        <!-- Page header -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>New Order Requests</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Reception</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-12">
                        <div class="card shadow-sm">
                            <div class="card-header bg-success text-white">
                                <h5 class="mb-0">Order Details</h5>
                            </div>

                            <div class="card">
                                <div class="card-header">

                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>S.N</th>
                                                <th>Order ID</th>
                                                <th>Customer</th>
                                                <th>Phone</th>
                                                <th>Items</th>
                                                <th>Type</th>
                                                <th>Source</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($orders as $res)
                                                <tr>
                                                    <td class="text-center">{{ $loop->iteration }}</td>
                                                    <td class="text-center">#RCO000{{ $res->id }}</td>
                                                    <td class="text-center">{{ $res->customer['name'] ?? 'N/A' }}</td>
                                                    <td class="text-center">{{ $res->customer['phone'] ?? 'N/A' }}</td>
                                                    <td>
                                                        <ul class="list-unstyled mb-0">
                                                            @foreach ($res->items as $item)
                                                                @php
                                                                    $menu = Modules\Restaurent\Models\Menu::find(
                                                                        $item->menu_id,
                                                                    );
                                                                    $variation = Modules\Restaurent\Models\MenuVariation::find(
                                                                        $item->variation_id,
                                                                    );
                                                                @endphp
                                                                <li>
                                                                    {{ $variation->name ?? 'N/A' }} -
                                                                    {{ $menu->name ?? 'N/A' }}
                                                                    <span
                                                                        class="badge bg-secondary">{{ $item->qty ?? 0 }}x</span>
                                                                    <span class="text-muted">Rs.
                                                                        {{ $variation->price ?? 0 }}</span>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </td>
                                                    <td class="text-center">
                                                        @php
                                                            $type = strtolower($res->order_type);
                                                            $typeBadge = match ($type) {
                                                                'table' => 'secondary',
                                                                'office' => 'info',
                                                                'takeaway' => 'dark',
                                                                default => 'secondary',
                                                            };
                                                        @endphp
                                                        <span
                                                            class="badge bg-{{ $typeBadge }}">{{ ucfirst($type) }}</span>
                                                    </td>
                                                    <td class="text-center">
                                                        @php
                                                            $source = strtolower($res->order_source);
                                                            $sourceBadge = match ($source) {
                                                                'online' => 'success',
                                                                'reception' => 'primary',
                                                                'walk-in' => 'secondary',
                                                                default => 'secondary',
                                                            };
                                                        @endphp
                                                        <span
                                                            class="badge bg-{{ $sourceBadge }}">{{ ucfirst($source) }}</span>
                                                    </td>
                                                    <td class="text-center">
                                                        @php
                                                            $status = strtolower($res->status);
                                                            $statusBadge = match ($status) {
                                                                'pending' => 'warning',
                                                                'sent to kitchen' => 'info',
                                                                'cooking' => 'primary',
                                                                'serve' => 'success',
                                                                default => 'secondary',
                                                            };
                                                        @endphp
                                                        <span
                                                            class="badge bg-{{ $statusBadge }}">{{ ucfirst($status) }}</span>
                                                    </td>
                                                    <td class="text-center">
                                                        @if ($res->status === 'pending')
                                                            <form action="{{ route('orders.moveToKitchen', $res->id) }}"
                                                                method="POST" class="d-inline">
                                                                @csrf
                                                                <button type="submit" class="btn btn-primary btn-sm">
                                                                    <i class="fa fa-paper-plane me-1"></i>
                                                                    Send to Kitchen
                                                                </button>
                                                            </form>
                                                        @elseif (in_array($res->status, ['sent to kitchen', 'cooking']))
                                                            <button class="btn btn-warning btn-sm" disabled>
                                                                {{ ucfirst($res->status) }} <i
                                                                    class="fa fa-spinner fa-spin"></i>
                                                            </button>
                                                        @elseif ($res->status === 'serve')
                                                            <button type="button" class="btn btn-success btn-sm"
                                                                data-toggle="modal"
                                                                data-target="#serveModal{{ $res->id }}">
                                                                Take Payment
                                                            </button>

                                                            <form action="{{ route('orders.updatePayment') }}"
                                                                method="POST">
                                                                @csrf
                                                                <input type="hidden" name="order_id"
                                                                    value="{{ $res->id }}">
                                                                <input type="hidden" name="customer_id"
                                                                    value="{{ $res->customer_id ?? ($res->customer['id'] ?? null) }}">

                                                                <!-- Serve Order Modal -->
                                                                <div class="modal fade serveModal"
                                                                    id="serveModal{{ $res->id }}" tabindex="-1"
                                                                    aria-labelledby="serveModalLabel{{ $res->id }}"
                                                                    aria-hidden="true">
                                                                    <div
                                                                        class="modal-dialog modal-md modal-dialog-centered">
                                                                        <!-- smaller width -->
                                                                        <div class="modal-content rounded-4 shadow">

                                                                            <!-- Header -->
                                                                            <div
                                                                                class="modal-header bg-info text-white rounded-top-4">
                                                                                <h5 class="modal-title fw-bold"
                                                                                    id="serveModalLabel{{ $res->id }}">
                                                                                    Order Summary</h5>
                                                                                <button type="button"
                                                                                    class="btn-close btn-close-white"
                                                                                    data-dismiss="modal"
                                                                                    aria-label="Close">close</button>
                                                                            </div>

                                                                            <!-- Body -->
                                                                            <div class="modal-body p-3">

                                                                                <!-- Order Info -->
                                                                                <div
                                                                                    class="d-flex justify-content-between mb-2">
                                                                                    <p class="mb-0"><strong>Order
                                                                                            ID:</strong>
                                                                                        #RCO000{{ $res->id }}</p>
                                                                                    <p class="mb-0">
                                                                                        <strong>Customer:</strong>
                                                                                        {{ $res->customer['name'] ?? 'N/A' }}
                                                                                    </p>
                                                                                </div>
                                                                                <hr class="my-2">

                                                                                <!-- Order Details Table -->
                                                                                <h6 class="mb-2">Order Details</h6>
                                                                                <div class="table-responsive mb-2">
                                                                                    <table
                                                                                        class="table table-sm table-bordered text-center align-middle mb-0">
                                                                                        <thead class="table-light">
                                                                                            <tr>
                                                                                                <th>Item</th>
                                                                                                <th>Variation</th>
                                                                                                <th>Qty</th>
                                                                                                <th>Price (Rs.)</th>
                                                                                                <th>Total (Rs.)</th>
                                                                                            </tr>
                                                                                        </thead>
                                                                                        <tbody>
                                                                                            @foreach ($res->items as $item)
                                                                                                @php
                                                                                                    $variation = Modules\Restaurent\Models\MenuVariation::find(
                                                                                                        $item->variation_id,
                                                                                                    );
                                                                                                @endphp
                                                                                                <tr>
                                                                                                    <td>{{ $variation->menu->name ?? 'N/A' }}
                                                                                                    </td>
                                                                                                    <td>{{ $variation->name ?? 'N/A' }}
                                                                                                    </td>
                                                                                                    <td>{{ $item->qty ?? 0 }}
                                                                                                    </td>
                                                                                                    <td>{{ $variation->price ?? 0 }}
                                                                                                    </td>
                                                                                                    <td>{{ ($variation->price ?? 0) * ($item->qty ?? 1) }}
                                                                                                    </td>
                                                                                                </tr>
                                                                                            @endforeach
                                                                                        </tbody>
                                                                                        <tfoot>
                                                                                            <tr
                                                                                                class="table-secondary text-end">
                                                                                                <th colspan="4">Grand
                                                                                                    Total:</th>
                                                                                                <td>{{ $res->grand_total ?? 0 }}
                                                                                                </td>
                                                                                            </tr>
                                                                                        </tfoot>
                                                                                    </table>
                                                                                </div>

                                                                                <!-- Payment Section -->
                                                                                <div
                                                                                    class="card border-info shadow-sm mt-3">
                                                                                    <div
                                                                                        class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                                                                                        <h6 class="mb-0"><i
                                                                                                class="fa fa-credit-card me-2"></i>Payment
                                                                                            Details</h6>
                                                                                        <small class="text-white-50">Order
                                                                                            ID:
                                                                                            #{{ $res->id }}</small>
                                                                                    </div>
                                                                                    <div class="card-body p-3">

                                                                                        <!-- Payment Status -->
                                                                                        <div class="mb-3">
                                                                                            <label
                                                                                                class="form-label fw-bold">Payment
                                                                                                Status:</label><br>
                                                                                            <div
                                                                                                class="form-check form-check-inline">
                                                                                                <input
                                                                                                    class="form-check-input payment-status"
                                                                                                    type="radio"
                                                                                                    name="payment_status_{{ $res->id }}"
                                                                                                    value="unpaid" checked>
                                                                                                <label
                                                                                                    class="form-check-label">Unpaid</label>
                                                                                            </div>
                                                                                            <div
                                                                                                class="form-check form-check-inline">
                                                                                                <input
                                                                                                    class="form-check-input payment-status"
                                                                                                    type="radio"
                                                                                                    name="payment_status_{{ $res->id }}"
                                                                                                    value="paid">
                                                                                                <label
                                                                                                    class="form-check-label">Paid</label>
                                                                                            </div>
                                                                                        </div>



                                                                                        <!-- Payment Modal -->
                                                                                        <div class="modal fade"
                                                                                            id="paymentModal{{ $res->id }}"
                                                                                            tabindex="-1"
                                                                                            aria-labelledby="paymentModalLabel{{ $res->id }}"
                                                                                            aria-hidden="true">
                                                                                            <div
                                                                                                class="modal-dialog modal-md modal-dialog-centered">
                                                                                                <div
                                                                                                    class="modal-content border-0 shadow-lg rounded-4">

                                                                                                    <form
                                                                                                        id="paymentForm{{ $res->id }}"
                                                                                                        action="{{ route('orders.updatePayment') }}"
                                                                                                        method="POST">
                                                                                                        @csrf
                                                                                                        <input
                                                                                                            type="hidden"
                                                                                                            name="order_id"
                                                                                                            value="{{ $res->id }}">
                                                                                                        <input
                                                                                                            type="hidden"
                                                                                                            name="customer_id"
                                                                                                            value="{{ $res->customer_id ?? ($res->customer['id'] ?? null) }}">

                                                                                                        <!-- Header -->
                                                                                                        <div class="modal-header"
                                                                                                            style="background: linear-gradient(135deg, #20c997 0%, #17a2b8 100%); color: #fff; border-top-left-radius: 1rem; border-top-right-radius: 1rem;">
                                                                                                            <h5 class="modal-title fw-bold"
                                                                                                                id="paymentModalLabel{{ $res->id }}">
                                                                                                                <i
                                                                                                                    class="fas fa-credit-card me-2"></i>Payment
                                                                                                                Details
                                                                                                            </h5>

                                                                                                        </div>

                                                                                                        <!-- Body -->
                                                                                                        <div
                                                                                                            class="modal-body p-4">
                                                                                                            <div
                                                                                                                class="payment-section mb-3">


                                                                                                                <!-- Payment Rows Wrapper -->
                                                                                                                <div
                                                                                                                    id="paymentRows{{ $res->id }}">
                                                                                                                    <!-- Main Payment Row -->
                                                                                                                    <div
                                                                                                                        class="payment-row mb-3">
                                                                                                                        <div
                                                                                                                            class="input-group input-group-sm shadow-sm">
                                                                                                                            <select
                                                                                                                                name="payment_method[]"
                                                                                                                                class="form-select form-select-sm border-0 bg-white">
                                                                                                                                <option
                                                                                                                                    value="cash">
                                                                                                                                    💵
                                                                                                                                    Cash
                                                                                                                                </option>
                                                                                                                                <option
                                                                                                                                    value="card">
                                                                                                                                    💳
                                                                                                                                    Card
                                                                                                                                </option>
                                                                                                                                <option
                                                                                                                                    value="esewa">
                                                                                                                                    📱
                                                                                                                                    eSewa
                                                                                                                                </option>
                                                                                                                            </select>
                                                                                                                            <input
                                                                                                                                type="number"
                                                                                                                                name="paying_amount[]"
                                                                                                                                class="form-control form-control-sm text-end"
                                                                                                                                placeholder="0.00"
                                                                                                                                min="0"
                                                                                                                                step="0.01">
                                                                                                                        </div>
                                                                                                                    </div>

                                                                                                                    <!-- Extra Payment Row (Initially Hidden) -->
                                                                                                                    <div class="extra-payment-row mb-3"
                                                                                                                        style="display:none;">
                                                                                                                        <div
                                                                                                                            class="input-group input-group-sm shadow-sm">
                                                                                                                            <select
                                                                                                                                name="payment_method[]"
                                                                                                                                class="form-select form-select-sm border-0 bg-white">
                                                                                                                                <option
                                                                                                                                    value="cash">
                                                                                                                                    💵
                                                                                                                                    Cash
                                                                                                                                </option>
                                                                                                                                <option
                                                                                                                                    value="card">
                                                                                                                                    💳
                                                                                                                                    Card
                                                                                                                                </option>
                                                                                                                                <option
                                                                                                                                    value="esewa">
                                                                                                                                    📱
                                                                                                                                    eSewa
                                                                                                                                </option>
                                                                                                                            </select>
                                                                                                                            <input
                                                                                                                                type="number"
                                                                                                                                name="paying_amount[]"
                                                                                                                                class="form-control form-control-sm text-end"
                                                                                                                                placeholder="0.00"
                                                                                                                                min="0"
                                                                                                                                step="0.01">
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                                <div class="form-check mb-2"
                                                                                                                    style="display: flex; align-items: center;">
                                                                                                                    <input
                                                                                                                        class="form-check-input border-primary me-2"
                                                                                                                        type="checkbox"
                                                                                                                        id="addPaymentRow{{ $res->id }}">
                                                                                                                    <label
                                                                                                                        class="form-check-label fw-semibold text-dark small"
                                                                                                                        for="addPaymentRow{{ $res->id }}">
                                                                                                                        <i
                                                                                                                            class="fas fa-plus-circle me-1 text-primary"></i>Add
                                                                                                                        Payment
                                                                                                                    </label>
                                                                                                                </div>

                                                                                                            </div>



                                                                                                            <!-- JS to toggle extra row -->

                                                                                                            <script>
                                                                                                                document.addEventListener('DOMContentLoaded', function() {
                                                                                                                    const checkbox = document.getElementById('addPaymentRow{{ $res->id }}');
                                                                                                                    const extraRow = document.querySelector('#paymentRows{{ $res->id }} .extra-payment-row');
                                                                                                                    const payingInputs = document.querySelectorAll('#paymentRows{{ $res->id }} .paying-input');
                                                                                                                    const paidAmountEl = document.querySelector('.paid-amount');
                                                                                                                    const dueAmountEl = document.querySelector('.due-amount');
                                                                                                                    const totalAmount = parseFloat({{ $res->grand_total ?? 0 }});
                                                                                                                    const previousDue = parseFloat(dueAmountEl.dataset.oldDue || 0);

                                                                                                                    // Toggle extra row
                                                                                                                    checkbox.addEventListener('change', function() {
                                                                                                                        if (this.checked) {
                                                                                                                            extraRow.style.display = 'block';
                                                                                                                        } else {
                                                                                                                            extraRow.style.display = 'none';
                                                                                                                            extraRow.querySelector('.paying-input').value = 0;
                                                                                                                            calculateDue();
                                                                                                                        }
                                                                                                                    });

                                                                                                                    // Calculate Paid and Due dynamically
                                                                                                                    function calculateDue() {
                                                                                                                        let paid = 0;
                                                                                                                        document.querySelectorAll('#paymentRows{{ $res->id }} .paying-input').forEach(input => {
                                                                                                                            paid += parseFloat(input.value || 0);
                                                                                                                        });
                                                                                                                        paidAmountEl.textContent = 'Rs. ' + paid.toFixed(2);
                                                                                                                        const due = totalAmount + previousDue - paid;
                                                                                                                        dueAmountEl.textContent = 'Rs. ' + due.toFixed(2);
                                                                                                                    }

                                                                                                                    payingInputs.forEach(input => {
                                                                                                                        input.addEventListener('input', calculateDue);
                                                                                                                    });
                                                                                                                });
                                                                                                            </script>


                                                                                                            <!-- Amount Summary Section -->
                                                                                                            <div
                                                                                                                class="amount-summary-section">
                                                                                                                <h6
                                                                                                                    class="fw-bold text-dark mb-3 border-bottom pb-2">
                                                                                                                    <i
                                                                                                                        class="fas fa-calculator me-2 text-primary"></i>Amount
                                                                                                                    Summary
                                                                                                                </h6>

                                                                                                                <div
                                                                                                                    class="row g-2 text-dark">
                                                                                                                    <!-- Total Amount -->
                                                                                                                    <div
                                                                                                                        class="col-12 mb-2">
                                                                                                                        <div
                                                                                                                            class="p-3 bg-white border border-primary rounded-3 shadow-sm d-flex justify-content-between align-items-center">
                                                                                                                            <span
                                                                                                                                class="fw-semibold text-dark">
                                                                                                                                <i
                                                                                                                                    class="fas fa-receipt me-2 text-primary"></i>Total
                                                                                                                                Amount:
                                                                                                                            </span>
                                                                                                                            <span
                                                                                                                                class="fw-bold fs-6 net-payable text-primary">
                                                                                                                                Rs.
                                                                                                                                {{ number_format($res->grand_total ?? 0, 2) }}
                                                                                                                            </span>
                                                                                                                        </div>
                                                                                                                    </div>

                                                                                                                    <!-- Paid Amount -->
                                                                                                                    <div
                                                                                                                        class="col-12 mb-2">
                                                                                                                        <div
                                                                                                                            class="p-3 bg-white border border-success rounded-3 shadow-sm d-flex justify-content-between align-items-center">
                                                                                                                            <span
                                                                                                                                class="fw-semibold text-dark">
                                                                                                                                <i
                                                                                                                                    class="fas fa-check-circle me-2 text-success"></i>Paid
                                                                                                                                Amount:
                                                                                                                            </span>
                                                                                                                            <span
                                                                                                                                class="paid-amount total-paid fw-bold fs-6 text-success" id="paidAmount{{$res->id}}">
                                                                                                                                Rs.
                                                                                                                                0.00
                                                                                                                            </span>
                                                                                                                        </div>
                                                                                                                    </div>

                                                                                                                    <!-- Due Amount Section -->
                                                                                                                    <div
                                                                                                                        class="col-12 mb-2">
                                                                                                                        <div
                                                                                                                            class="p-3 bg-white border border-danger rounded-3 shadow-sm">
                                                                                                                            <div
                                                                                                                                class="d-flex justify-content-between align-items-center mb-1">
                                                                                                                                <span
                                                                                                                                    class="fw-semibold text-dark">
                                                                                                                                    <i
                                                                                                                                        class="fas fa-clock me-2 text-danger"></i>Due
                                                                                                                                    Amount:
                                                                                                                                </span>
                                                                                                                                @php
                                                                                                                                    $cid =
                                                                                                                                        $res->customer_id ??
                                                                                                                                        ($res
                                                                                                                                            ->customer[
                                                                                                                                            'id'
                                                                                                                                        ] ??
                                                                                                                                            null);
                                                                                                                                    $due =
                                                                                                                                        \Modules\Restaurent\Models\CustomerPayment::where(
                                                                                                                                            'customer_id',
                                                                                                                                            $cid,
                                                                                                                                        )->value(
                                                                                                                                            'due_amount',
                                                                                                                                        ) ??
                                                                                                                                        0;
                                                                                                                                    $currentOrder =
                                                                                                                                        \Modules\Restaurent\Models\Order::where(
                                                                                                                                            'id',
                                                                                                                                            $res->customer_id,
                                                                                                                                        )->value(
                                                                                                                                            'grand_total',
                                                                                                                                        ) ??
                                                                                                                                        0;
                                                                                                                                @endphp
                                                                                                                                <span
                                                                                                                                    id="dueAmount{{ $res->id }}"
                                                                                                                                    data-old-due="{{ $due }}">
                                                                                                                                    Rs.
                                                                                                                                    {{  $res->grand_total ?? 0 }}
                                                                                                                                </span>
                                                                                                                            </div>
                                                                                                                            <small
                                                                                                                                class="text-muted d-block">
                                                                                                                                (Current
                                                                                                                                Order:
                                                                                                                                Rs.
                                                                                                                                {{ number_format($res->grand_total ?? 0, 2) }}
                                                                                                                                +
                                                                                                                                Previous
                                                                                                                                Due:
                                                                                                                                Rs.
                                                                                                                                {{ number_format($due, 2) }})
                                                                                                                            </small>
                                                                                                                        </div>
                                                                                                                    </div>

                                                                                                                </div>
                                                                                                            </div>

                                                                                                        </div>

                                                                                                        
<script>
document.addEventListener('DOMContentLoaded', function() {
    const paymentRows = document.querySelectorAll('#paymentRows{{ $res->id }} .payment-row, #paymentRows{{ $res->id }} .extra-payment-row');
    const dueAmountSpan = document.getElementById('dueAmount{{ $res->id }}');
    const paidAmountSpan = document.getElementById('paidAmount{{ $res->id }}'); // Add paid amount span
    const currentOrder = parseFloat({{ $res->grand_total ?? 0 }});

    function updateAmounts() {
        let totalPaid = 0;
        paymentRows.forEach(row => {
            const input = row.querySelector('input[name="paying_amount[]"]');
            if(input && input.value) {
                totalPaid += parseFloat(input.value);
            }
        });
        const due = currentOrder - totalPaid;

        // Update both paid and due amounts
        dueAmountSpan.textContent = 'Rs. ' + due.toFixed(2);
        paidAmountSpan.textContent = 'Rs. ' + totalPaid.toFixed(2);
    }

    // Attach event listeners to all existing inputs
    paymentRows.forEach(row => {
        const input = row.querySelector('input[name="paying_amount[]"]');
        if(input) input.addEventListener('input', updateAmounts);
    });

    // Checkbox for extra row
    const checkbox = document.getElementById('addPaymentRow{{ $res->id }}');
    if(checkbox) {
        checkbox.addEventListener('change', function() {
            const extraRow = document.querySelector('#paymentRows{{ $res->id }} .extra-payment-row');
            if(this.checked && extraRow) {
                extraRow.style.display = 'block';
                const input = extraRow.querySelector('input[name="paying_amount[]"]');
                if(input) input.addEventListener('input', updateAmounts);
            } else if(extraRow) {
                extraRow.style.display = 'none';
                const input = extraRow.querySelector('input[name="paying_amount[]"]');
                if(input) input.value = '';
                updateAmounts();
            }
        });
    }
});
</script>


                                                                                                        <!-- Footer -->
                                                                                                        <div
                                                                                                            class="modal-footer border-0 justify-content-center pt-0">
                                                                                                            <button
                                                                                                                type="button"
                                                                                                                class="btn btn-outline-secondary rounded-pill px-4 me-2"
                                                                                                                data-dismiss="modal">
                                                                                                                <i
                                                                                                                    class="fas fa-times me-1"></i>Cancel
                                                                                                            </button>
                                                                                                            <button
                                                                                                                type="submit"
                                                                                                                class="btn rounded-pill px-4 fw-bold shadow-sm"
                                                                                                                style="background: linear-gradient(135deg, #20c997 0%, #17a2b8 100%); color:white;">
                                                                                                                <i
                                                                                                                    class="fas fa-paper-plane me-1"></i>Pay
                                                                                                                Now
                                                                                                            </button>
                                                                                                        </div>

                                                                                                    </form>

                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <script>
                                                                                            document.addEventListener("DOMContentLoaded", function() {
                                                                                                const wrapper = document.getElementById("paymentRows{{ $res->id }}");
                                                                                                const netPayableEl = document.querySelector("#paymentModal{{ $res->id }} .net-payable");
                                                                                                const paidAmountEl = document.querySelector("#paymentModal{{ $res->id }} .paid-amount");
                                                                                                const dueAmountEl = document.getElementById("dueAmount{{ $res->id }}");
                                                                                                const checkbox = document.getElementById("addPaymentRow{{ $res->id }}");
                                                                                                const extraRow = wrapper.querySelector(".extra-payment-row");

                                                                                                function parseNumber(str) {
                                                                                                    return Number(str.replace(/[^\d.]/g, "").trim()) || 0;
                                                                                                }

                                                                                                function updateTotals() {
                                                                                                    let totalPaid = 0;

                                                                                                    // Sum all visible paying inputs
                                                                                                    wrapper.querySelectorAll(".paying-input").forEach(input => {
                                                                                                        if (input.closest(".payment-row, .extra-payment-row")?.offsetParent !== null) {
                                                                                                            totalPaid += parseFloat(input.value) || 0;
                                                                                                        }
                                                                                                    });

                                                                                                    const currentOrder = parseNumber(netPayableEl.textContent);
                                                                                                    const oldDue = parseNumber(dueAmountEl.dataset.oldDue);

                                                                                                    // Total owed = current + old
                                                                                                    const remainingDue = Math.max(currentOrder + oldDue - totalPaid, 0);

                                                                                                    // Update UI
                                                                                                    paidAmountEl.textContent = `Rs. ${totalPaid.toFixed(2)}`;
                                                                                                    dueAmountEl.textContent = `Rs. ${remainingDue.toFixed(2)}`;

                                                                                                    // Update color
                                                                                                    dueAmountEl.style.color = remainingDue > 0 ? "#dc3545" : "#28a745"; // red if due, green if complete
                                                                                                }

                                                                                                // Attach events to all inputs
                                                                                                function attachEvents(row) {
                                                                                                    const input = row.querySelector(".paying-input");
                                                                                                    if (input) {
                                                                                                        input.addEventListener("input", updateTotals);
                                                                                                        input.addEventListener("change", updateTotals);
                                                                                                    }
                                                                                                }

                                                                                                wrapper.querySelectorAll(".payment-row, .extra-payment-row").forEach(attachEvents);

                                                                                                // Checkbox to add extra payment
                                                                                                checkbox.addEventListener("change", () => {
                                                                                                    if (checkbox.checked) {
                                                                                                        extraRow.style.display = "flex";
                                                                                                        attachEvents(extraRow);
                                                                                                    } else {
                                                                                                        extraRow.style.display = "none";
                                                                                                        const extraInput = extraRow.querySelector(".paying-input");
                                                                                                        if (extraInput) extraInput.value = "";
                                                                                                    }
                                                                                                    updateTotals();
                                                                                                });

                                                                                                // Initial calculation
                                                                                                updateTotals();
                                                                                            });
                                                                                        </script>

                                                                                    </div>
                                                                                </div>

                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </form>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>S.N</th>
                                                <th>Order ID</th>
                                                <th>Customer</th>
                                                <th>Phone</th>
                                                <th>Items</th>
                                                <th>Type</th>
                                                <th>Source</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                <!-- /.card-body -->
                            </div>


                        </div>
                    </div>
        </section>

    </div>
    </div>
    </div>
    </div>

    </div>
    </section>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');


            // Payment Status Toggle
            document.querySelectorAll('.payment-status').forEach(radio => {
                radio.addEventListener('change', function() {
                    const paidSection = this.closest('.payment-details').querySelector(
                        '.paid-section');
                    paidSection.style.display = (this.value === 'paid') ? 'block' : 'none';
                });
            });


            // Payment Method Image Update
            document.querySelectorAll('.payment-method-select').forEach(select => {
                const img = select.closest('.input-group-text').querySelector('.payment-method-img');
                select.addEventListener('change', () => {
                    img.src = select.options[select.selectedIndex].dataset.img;
                });
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
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





        // Payment Status Modal Trigger
        document.querySelectorAll('.payment-status').forEach(radio => {
            radio.addEventListener('change', function() {
                if (this.value === 'paid') {
                    const orderId = this.name.split('_')[2]; // get order id
                    const paymentModal = new bootstrap.Modal(document.getElementById('paymentModal' +
                        orderId));
                    paymentModal.show();

                    // reset radio to unpaid inside main modal
                    this.checked = false;
                    document.querySelector(`input[name="${this.name}"][value="unpaid"]`).checked = true;
                }
            });
        });
    </script>

@endsection
