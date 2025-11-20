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
                                                                                                class="modal-dialog modal-sm modal-dialog-centered">
                                                                                                <!-- smaller width -->
                                                                                                <div
                                                                                                    class="modal-content border-0 shadow-lg rounded-4">

                                                                                                    <form
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
                                                                                                            style="background-color: #20c997; color: #fff; border-top-left-radius: 1rem; border-top-right-radius: 1rem;">
                                                                                                            <h5 class="modal-title fw-bold"
                                                                                                                id="paymentModalLabel{{ $res->id }}">
                                                                                                                Payment
                                                                                                                Details
                                                                                                            </h5>

                                                                                                        </div>

                                                                                                        <!-- Body -->
                                                                                                        <div
                                                                                                            class="modal-body p-3">

                                                                                                            <!-- Payment Method -->
                                                                                                            <div
                                                                                                                class="mb-3">
                                                                                                                <label
                                                                                                                    class="form-label fw-bold">Payment
                                                                                                                    Method</label>
                                                                                                                <div
                                                                                                                    class="input-group shadow-sm rounded border">
                                                                                                                    <select
                                                                                                                        name="payment_method"
                                                                                                                        class="form-select form-select-sm payment-method-select">
                                                                                                                        <option
                                                                                                                            value="cash"
                                                                                                                            data-img="{{ asset('payment_images/cash.png') }}">
                                                                                                                            Cash
                                                                                                                        </option>
                                                                                                                        <option
                                                                                                                            value="card"
                                                                                                                            data-img="{{ asset('payment_images/card.png') }}">
                                                                                                                            Card
                                                                                                                        </option>
                                                                                                                        <option
                                                                                                                            value="esewa"
                                                                                                                            data-img="{{ asset('payment_images/esewa.png') }}">
                                                                                                                            eSewa
                                                                                                                        </option>
                                                                                                                    </select>
                                                                                                                    <span
                                                                                                                        class="input-group-text bg-white border-start-0">
                                                                                                                        <img class="payment-method-img rounded"
                                                                                                                            src="{{ asset('payment_images/cash.png') }}"
                                                                                                                            alt="Payment"
                                                                                                                            style="width:35px; height:35px;">
                                                                                                                    </span>
                                                                                                                </div>
                                                                                                            </div>

                                                                                                            <!-- Amount Details -->
                                                                                                            <div
                                                                                                                class="row g-2 text-dark">

                                                                                                                <!-- Total Amount -->
                                                                                                                <div
                                                                                                                    class="col-12 mb-2">
                                                                                                                    <div
                                                                                                                        class="p-2 bg-light border rounded shadow-sm d-flex justify-content-between align-items-center">
                                                                                                                        <span>Total
                                                                                                                            Amount:</span>
                                                                                                                        <span
                                                                                                                            class="fw-bold fs-6 net-payable text-primary">{{ $res->grand_total ?? 0 }}</span>
                                                                                                                    </div>
                                                                                                                </div>

                                                                                                                <!-- Paying Amount -->
                                                                                                                <div
                                                                                                                    class="col-12 mb-2">
                                                                                                                    <div
                                                                                                                        class="p-2 bg-light border rounded shadow-sm d-flex justify-content-between align-items-center">
                                                                                                                        <span>Paying
                                                                                                                            Amount:</span>
                                                                                                                        <input
                                                                                                                            type="number"
                                                                                                                            name="paying_amount"
                                                                                                                            class="form-control form-control-sm paying-input text-end rounded-pill"
                                                                                                                            style="width:100px;"
                                                                                                                            placeholder="0">
                                                                                                                    </div>
                                                                                                                </div>

                                                                                                                <!-- Paid Amount -->
                                                                                                                <div
                                                                                                                    class="col-12 mb-2">
                                                                                                                    <div
                                                                                                                        class="p-2 bg-light border rounded shadow-sm d-flex justify-content-between align-items-center">
                                                                                                                        <span>Paid
                                                                                                                            Amount:</span>
                                                                                                                        <span
                                                                                                                            class="paid-amount fw-bold fs-6 text-success">Rs.
                                                                                                                            0</span>
                                                                                                                    </div>
                                                                                                                </div>

                                                                                                                <!-- Due Amount -->
                                                                                                                <div
                                                                                                                    class="col-12 mb-2">
                                                                                                                    <div
                                                                                                                        class="p-2 bg-light border rounded shadow-sm d-flex justify-content-between align-items-center">
                                                                                                                        <span>Due
                                                                                                                            Amount:</span>
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
                                                                                                                        @endphp
                                                                                                                        <span
                                                                                                                            class="due-amount fw-bold fs-6 text-danger"
                                                                                                                            data-old-due="{{ $due }}">Rs.
                                                                                                                            {{ $due }}</span>
                                                                                                                    </div>
                                                                                                                </div>

                                                                                                            </div>
                                                                                                        </div>

                                                                                                        <!-- Footer -->
                                                                                                        <div
                                                                                                            class="modal-footer border-0 justify-content-center">
                                                                                                            <button
                                                                                                                type="submit"
                                                                                                                class="btn"
                                                                                                                style="background-color:#20c997; color:white; border-radius:50px; padding:0.5rem 2rem; font-weight:600; box-shadow:0 2px 6px rgba(0,0,0,0.2);">
                                                                                                                Pay Now
                                                                                                            </button>
                                                                                                        </div>

                                                                                                    </form>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>


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

            // Discount & Net Payable
            function updateNetPayable(modal) {
                const total = parseFloat(modal.querySelector('.total-amount').innerText) || 0;
                const discount = parseFloat(modal.querySelector('.discount-input').value) || 0;
                const type = modal.querySelector('.discount-type').value;
                let net = total;
                if (type === 'percent') net -= (total * discount / 100);
                else net -= discount;
                modal.querySelector('.net-payable').innerText = net.toFixed(2);
            }
            document.querySelectorAll('.discount-input, .discount-type').forEach(el => {
                el.addEventListener('input', function() {
                    const modal = el.closest('.modal-content');
                    updateNetPayable(modal);
                });
            });

            //paying and due amount
            document.querySelectorAll('.serveModal').forEach(modal => {
                const payingInput = modal.querySelector('.paying-input');
                const netPayableEl = modal.querySelector('.net-payable');
                const paidAmountEl = modal.querySelector('.paid-amount');
                const dueAmountEl = modal.querySelector('.due-amount');

                if (payingInput && netPayableEl && paidAmountEl && dueAmountEl) {
                    // Read old due amount from a data attribute
                    const oldDue = parseFloat(dueAmountEl.dataset.oldDue) || 0;

                    payingInput.addEventListener('input', () => {
                        // Parse net payable and paying amount
                        let netText = netPayableEl.textContent.replace(/[^0-9.]/g, '').trim();
                        const net = parseFloat(netText) || 0;
                        const payingAmount = parseFloat(payingInput.value) || 0;

                        // Paid = current paying amount
                        paidAmountEl.textContent = `Rs. ${(payingAmount).toFixed(2)}`;

                        // Due = old due + net - paying
                        const totalDue = Math.max(oldDue + net - payingAmount, 0);
                        dueAmountEl.textContent = `Rs. ${totalDue.toFixed(2)}`;
                    });
                }
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
