<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Orders - Admin</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <style>
        :root {
            --primary: #0d6efd;
            --muted: #6c757d;
            --card: #ffffff;
            --bg: #f4f6f9;
            --accent: #0b5ed7;
            --glass: rgba(255, 255, 255, 0.85);
        }

        html,
        body {
            height: 100%;
            font-family: Inter, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
        }

        body {
            background: var(--bg);
            margin: 0
        }

        /* layout */
        .app-shell {
            padding: 24px;
            max-width: 1200px;
            margin: 0 auto
        }

        /* top navigation (replaces sidebar) */
        .topnav {
            background: linear-gradient(90deg, #0b4b8a, #063459);
            color: #fff;
            padding: 12px 18px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 18px;
        }

        .topnav .brand {
            display: flex;
            align-items: center;
            gap: 12px
        }

        .topnav .logo {
            width: 44px;
            height: 44px;
            border-radius: 8px;
            background: #fff;
            color: var(--accent);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700
        }

        .topnav .nav-links a {
            color: rgba(255, 255, 255, 0.95);
            margin-left: 14px;
            text-decoration: none;
            font-weight: 600
        }

        .topnav .nav-links a:hover {
            opacity: 0.9
        }

        .topnav .actions {
            display: flex;
            align-items: center;
            gap: 8px
        }

        .main {
            padding: 12px 0
        }

        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 18px
        }

        .card-shadow {
            box-shadow: 0 6px 18px rgba(35, 47, 52, 0.06);
            border-radius: 12px;
            border: 0;
            background: var(--glass)
        }

        .card-header-prim {
            background: linear-gradient(90deg, var(--primary), var(--accent));
            color: #fff;
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
            padding: 14px 18px
        }

        .small-muted {
            color: var(--muted);
            font-size: .9rem
        }

        .order-summary {
            background: linear-gradient(180deg, #fff, #f8fafc);
            padding: 18px;
            border-radius: 10px
        }

        .btn-wide {
            min-width: 140px
        }

        .text-info-Soft {
            color: #0b76d1
        }

        .badge-soft {
            background: rgba(11, 125, 209, 0.12);
            color: var(--accent);
            padding: .35rem .6rem;
            border-radius: .7rem;
            font-weight: 600
        }

        footer {
            padding: 18px;
            text-align: center;
            color: var(--muted);
            font-size: .9rem
        }

        /* Customer card specific */
        .customer-card {
            padding: 18px
        }

        .cust-head {
            display: flex;
            gap: 12px;
            align-items: center;
            margin-bottom: 10px
        }

        .cust-avatar {
            width: 64px;
            height: 64px;
            border-radius: 12px;
            background: linear-gradient(180deg, #fff, #f1f6fb);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            color: var(--accent);
            box-shadow: 0 6px 18px rgba(11, 93, 155, 0.08);
        }

        .cust-meta {
            flex: 1;
            min-width: 0
        }

        .cust-meta h6 {
            margin: 0;
            font-weight: 700
        }

        .cust-meta .muted {
            font-size: .85rem;
            color: var(--muted)
        }

        .customer-actions {
            display: flex;
            gap: 8px;
            align-items: center
        }

        .phone-input-group .form-control:focus {
            box-shadow: 0 0 0 .15rem rgba(13, 110, 253, .12);
            border-color: var(--primary)
        }

        .recent-orders {
            max-height: 200px;
            overflow: auto;
            padding: 12px;
            background: #f8f9fa;
            border-radius: 8px;
            margin: 12px;
            display: none;
        }

        .recent-orders .order-item {
            padding: 10px;
            border-radius: 8px;
            background: white;
            margin-bottom: 8px;
            border-left: 4px solid var(--primary);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .recent-orders .order-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
            font-weight: 600;
        }

        .recent-orders .order-status {
            font-size: 0.8rem;
            padding: 2px 8px;
            border-radius: 12px;
        }

        .recent-orders .status-pending {
            background: #fff3cd;
            color: #856404;
        }

        .recent-orders .status-preparing {
            background: #cce7ff;
            color: #004085;
        }

        .recent-orders .status-ready {
            background: #d1ecf1;
            color: #0c5460;
        }

        .recent-orders .order-items {
            font-size: 0.85rem;
            color: var(--muted);
        }

        .badge-green {
            background: #e6f7ed;
            color: #0f5132;
            padding: .25rem .45rem;
            border-radius: .45rem;
            font-weight: 600
        }

        .form-hint {
            font-size: .85rem;
            color: var(--muted)
        }

        @media (max-width: 768px) {
            .topnav {
                flex-direction: column;
                align-items: flex-start
            }

            .topnav .nav-links {
                width: 100%;
                margin-top: 8px
            }

            .topnav .nav-links a {
                display: inline-block;
                margin: 6px 10px 0 0
            }
        }
    </style>
</head>

<body>
    <div class="app-shell">
        <!-- Top navigation (replaces sidebar) -->
        <div class="topnav">
            <div class="brand">
                <div class="logo">R</div>
                <div>
                    <div style="font-weight:700">BG RestroCare</div>
                    <div class="small-muted">Orders Panel</div>
                </div>
            </div>

            <div class="d-flex align-items-center gap-3">
                <div class="actions">
                    <div class="small-muted d-none d-md-block text-end me-2">
                        <div>Hello, Admin</div>
                        <div class="small-muted">Today: {{ \Carbon\Carbon::now()->format('d M, Y') }}</div>
                    </div>
                    <button class="btn btn-outline-light btn-sm"><i class="fa-regular fa-bell"></i></button>
                    <button class="btn btn-light btn-sm" id="compactNavToggle"><i class="fa-solid fa-bars"></i></button>
                </div>
            </div>
        </div>

        <main class="main">
            <div class="topbar">
                <div>
                    <h3 class="mb-0">Make an Order</h3>
                    <div class="small-muted">Create new takeaway / delivery orders quickly</div>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="small-muted text-end me-2 d-md-none">
                        <div>Hello, Admin</div>
                        <div class="small-muted">Today: {{ \Carbon\Carbon::now()->format('d M, Y') }}</div>
                    </div>
                    <button class="btn btn-outline-secondary btn-sm"><i class="fa-regular fa-bell"></i></button>
                    <button class="btn btn-primary btn-sm btn-wide"><i class="fa-solid fa-plus me-2"></i>New</button>
                </div>
            </div>

            <!-- SINGLE FORM FOR BOTH CUSTOMER AND ORDER DETAILS -->
            <form id="orderForm" action="{{ route('tables.orders.submit') }}" method="post">
                <input type="hidden" name="office_id" value="{{ $table->id ?? '' }}">
                <input type="hidden" name="restaurent_id" value="{{ auth()->user()->restaurent_id ?? '' }}">
                <input type="hidden" name="created_by" value="{{ auth()->id() ?? 1 }}">
                <input type="hidden" name="order_from" value="web">
                <input type="hidden" name="order_time" value="{{ now() }}">
                <input type="hidden" name="table_id" value="{{ $restaurent_table->table_number ?? '' }}">
                @csrf
                <div class="row g-4">
                    <!-- Customer Card -->
                    <div class="col-lg-5">
                        <div class="card card-shadow customer-card">
                            <div class="card-header-prim"
                                style="border-top-left-radius:12px;border-top-right-radius:12px;">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <h5 class="mb-0">Customer Details</h5>
                                        <small class="small-muted">Auto-fill by phone</small>
                                    </div>
                                    <div class="small-muted">Orders / Customers</div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <!-- Hidden field for existing customer ID -->
                                    <input type="hidden" id="customer_id" name="customer_id">

                                    <div class="col-12">
                                        <label class="form-label fw-600">Customer Phone *</label>
                                        <div class="input-group phone-input-group">
                                            <span class="input-group-text bg-white"><i
                                                    class="fa-solid fa-phone text-muted"></i></span>
                                            <input type="text" class="form-control shadow-sm" id="customer_phone"
                                                name="customer_phone" placeholder="e.g. 03001234567" required>
                                            <button type="button" id="clearPhone"
                                                class="btn btn-outline-secondary d-none"><i
                                                    class="fa-solid fa-xmark"></i></button>
                                        </div>
                                        <div id="phone-feedback" class="mt-2 small-muted" style="font-size:.9rem;">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label fw-600">Customer Name *</label>
                                        <input type="text" class="form-control shadow-sm" id="customer_name"
                                            name="customer_name" required>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label fw-600">Email</label>
                                        <input type="email" class="form-control shadow-sm" id="customer_email"
                                            name="customer_email" placeholder="optional">
                                    </div>

                                    <div class="col-12 d-flex gap-2 align-items-center">
                                        <!-- Quick tips -->
                                        <div class="mt-3 small-muted">
                                            <div class="mb-2"><strong>Tip:</strong> Enter a phone to auto-fill
                                                existing
                                                customer.</div>
                                        </div>
                                        <button type="button" id="resetCustomer"
                                            class="btn btn-light ms-auto">Reset</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Details Card -->
                    <div class="col-lg-7">
                        <div class="card card-shadow">

                            <div class="card-header-prim">
                                <div class="d-flex align-items-center justify-content-between">
                                    <h5 class="mb-0">Order Details</h5>
                                    <div class="small-muted">Create items and place order</div>
                                </div>
                            </div>

                            {{-- ************************************************************************ --}}
                            <div id="recentOrdersContainer" class="recent-orders"></div>

                            <div class="card-body">
                                <div id="itemsContainer">
                                    <div class="d-flex justify-content-between align-items-end mb-3">
                                        <div>
                                            <h6 class="mb-0">Order Items</h6>
                                            <small class="small-muted">Select menu items & variations</small>
                                        </div>
                                        <div>
                                            <button type="button" id="addItemBtn" class="btn btn-success btn-sm"><i
                                                    class="fa-solid fa-plus me-1"></i> Add Item</button>
                                        </div>
                                    </div>

                                    <div class="itemRow row g-2 align-items-end mb-2">
                                        <div class="col-md-6">
                                            <label class="form-label small-muted">Item</label>
                                            <select class="form-control item-search" name="menu_id[]" required>
                                                <option value="">-- Select Item --</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label small-muted">Variation</label>
                                            <select class="form-control item-variation" name="variation_id[]"
                                                required>
                                                <option value="">Select Variation</option>
                                            </select>
                                        </div>
                                        <div class="col-md-1">
                                            <label class="form-label small-muted">Qty</label>
                                            <input type="number" name="qty[]" class="form-control item-qty"
                                                placeholder="Qty" min="1" value="1" required>
                                        </div>
                                        <div class="col-md-1 text-end">
                                            <button type="button" class="btn btn-outline-danger btn-sm btn-remove"
                                                title="Remove"><i class="fa-solid fa-trash"></i></button>
                                        </div>
                                    </div>
                                </div>

                                <input type="text" name="orderType" id="orderType" value="dinein" hidden>

                                <div class="mb-3">
                                    <label class="form-label">Remarks / Message</label>
                                    <textarea class="form-control" id="remarks" name="remarks" rows="2"
                                        placeholder="Any special instructions..."></textarea>
                                </div>

                                <div class="order-summary d-flex gap-3 align-items-center justify-content-between">
                                    <div>
                                        <div class="small-muted">Total Amount</div>
                                        <h4 id="totalAmount" class="mb-0">0.00</h4>
                                    </div>
                                    <div>
                                        <div class="small-muted">Discount Applied</div>
                                        <h5 id="discountApplied" class="mb-0">0.00</h5>
                                    </div>
                                    <div>
                                        <div class="small-muted">Grand Total</div>
                                        <h3 id="grandTotal" class="mb-0 text-success">0.00</h3>
                                    </div>
                                    <div class="ms-3">
                                        <button type="submit" class="btn btn-primary btn-wide"><i
                                                class="fa-solid fa-check me-1"></i> Place Order</button>
                                    </div>
                                </div>

                                <input type="hidden" name="sub_total" id="subTotalInput">
                                <input type="hidden" name="discount_amount" id="discountAmountInput"
                                    value="0">
                                <input type="hidden" name="grand_total" id="grandTotalInput">
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <footer class="mt-4">
                © {{ date('Y') }} Restaurant Admin • Crafted for operations
            </footer>
        </main>
    </div>

    <!-- Optional Add Customer Modal (keeps referenced ID) -->
    <div class="modal fade" id="addCustomerModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content card-shadow">
                <div class="modal-header">
                    <h5 class="modal-title">Add Customer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addCustomerForm">
                    <div class="modal-body">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input id="newCustomerName" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phone</label>
                            <input id="newCustomerPhone" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input id="newCustomerEmail" type="email" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Add Customer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- JS: jQuery and Bootstrap bundle -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

   <script>
    let userRestaurantId = "{{ auth()->user()->restaurent_id ?? '' }}";
    let recentOrdersTotal = 0;

    // Function to check if customer exists by phone number
    function checkCustomerByPhone(phone) {
        if (!phone || phone.length < 10) {
            return;
        }

        const formData = new FormData();
        formData.append('_token', '{{ csrf_token() }}');
        formData.append('phone', phone);

        fetch('{{ route('check.customer.by.phone') }}', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                console.log('Customer check response:', data);

                if (data.exists && data.customer) {
                    // Set customer details in the form
                    $('#customer_name').val(data.customer.name || '');
                    $('#customer_email').val(data.customer.email || '');

                    // IMPORTANT: Set the customer ID from the response
                    if (data.customer.id) {
                        $('#customer_id').val(data.customer.id);
                        console.log('Customer ID set to:', data.customer.id);

                        // Fetch recent orders for this customer
                        fetchRecentOrders(data.customer.id);
                    } else {
                        console.warn('Customer ID not found in response');
                        $('#customer_id').val('');
                        hideRecentOrders();
                    }

                    $('#phone-feedback').html(
                        '<span class="text-success"><i class="fas fa-check-circle"></i> Customer found! Name auto-filled.</span>'
                    );
                    $('#clearPhone').removeClass('d-none');
                    setTimeout(() => $('#phone-feedback').html(''), 3000);
                } else {
                    // Clear customer ID for new customer
                    $('#customer_id').val('');
                    $('#customer_name').val('');
                    $('#customer_email').val('');
                    $('#phone-feedback').html(
                        '<span class="text-info"><i class="fas fa-info-circle"></i> New customer. Please enter details.</span>'
                    );
                    $('#clearPhone').removeClass('d-none');
                    hideRecentOrders();
                    setTimeout(() => $('#phone-feedback').html(''), 3000);
                }
            })
            .catch(error => {
                console.error('Error checking customer:', error);
                $('#phone-feedback').html(
                    '<span class="text-danger"><i class="fas fa-exclamation-triangle"></i> Error checking customer.</span>'
                );
                setTimeout(() => $('#phone-feedback').html(''), 3000);
                hideRecentOrders();
            });
    }

    // Function to fetch recent orders for a customer
    function fetchRecentOrders(customerId) {
        if (!customerId) {
            hideRecentOrders();
            return;
        }

        console.log('Fetching recent orders for customer:', customerId);

        fetch(`/api/customers/${customerId}/recent-orders`, {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log('Recent orders received:', data);
                displayRecentOrders(data);
            })
            .catch(error => {
                console.error('Error fetching recent orders:', error);
                hideRecentOrders();
            });
    }

    // Function to display recent orders with totals
    function displayRecentOrders(orders) {
        const container = $('#recentOrdersContainer');

        if (!orders || orders.length === 0) {
            container.html('<div class="text-center text-muted p-3">No incomplete orders found</div>').show();
            recentOrdersTotal = 0;
            updateOverallTotal();
            return;
        }

        let html = '<h6 class="mb-3"><i class="fas fa-history me-2"></i>Recent Incomplete Orders</h6>';

        // Reset recent orders total
        recentOrdersTotal = 0;

        orders.forEach(order => {
            const statusClass = getStatusClass(order.status);
            const orderTime = new Date(order.order_time).toLocaleString();
            
            // Use grand_total from the order (preferred) or calculated_total as fallback
            const orderTotal = order.grand_total || order.calculated_total || 0;
            recentOrdersTotal += orderTotal;

            html += `
                <div class="order-item">
                    <div class="order-header">
                        <span>Order #${order.id}</span>
                        <span class="order-status ${statusClass}">${order.status}</span>
                    </div>
                    <div class="order-time small text-muted mb-2">
                        <i class="fas fa-clock me-1"></i>${orderTime}
                    </div>
                    <div class="order-items">
                        ${order.items && order.items.length > 0 
                            ? order.items.map(item => 
                                `${item.qty}x ${item.item_name} ${item.variation_name ? '(' + item.variation_name + ')' : ''}`
                              ).join(', ')
                            : 'No items'
                        }
                    </div>
                    <div class="order-total small text-muted mt-2">
                        <strong>Order Total: Rs. ${orderTotal.toFixed(2)}</strong>
                    </div>
                    ${order.table_number ? `
                        <div class="order-location small text-muted mt-1">
                            <i class="fas fa-table me-1"></i>Table: ${order.table_number}
                        </div>
                    ` : ''}
                </div>
            `;
        });

        container.html(html).show();
        updateOverallTotal();
    }

    // Function to hide recent orders container
    function hideRecentOrders() {
        $('#recentOrdersContainer').hide().html('');
        recentOrdersTotal = 0;
        updateOverallTotal();
    }

    // Update overall total (current order + recent orders)
    function updateOverallTotal() {
        const currentOrderTotal = parseFloat($('#totalAmount').text()) || 0;
        const overallTotal = currentOrderTotal + recentOrdersTotal;
        
        // Update the grand total display
        $('#grandTotal').text(overallTotal.toFixed(2));
        
        // Update hidden form field
        $('#grandTotalInput').val(overallTotal.toFixed(2));
        
        console.log('Current Order:', currentOrderTotal, 'Recent Orders:', recentOrdersTotal, 'Overall:', overallTotal);
    }

    // Helper function to get status class
    function getStatusClass(status) {
        const statusMap = {
            'pending': 'status-pending',
            'confirmed': 'status-preparing',
            'preparing': 'status-preparing',
            'ready': 'status-ready',
            'completed': 'status-completed'
        };
        return statusMap[status] || 'status-pending';
    }

    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }
    const debouncedCheckCustomer = debounce(checkCustomerByPhone, 500);

    function updateTotal() {
        let total = 0;
        $(".itemRow").each(function() {
            const qty = parseFloat($(this).find(".item-qty").val()) || 0;

            let price = parseFloat($(this).find(".item-variation option:selected").data("price"));
            if (isNaN(price)) {
                price = parseFloat($(this).find(".item-variation").data("price")) || 0;
            }
            total += qty * price;
        });

        let discountAmount = 0;
        const grandTotal = total - discountAmount;

        $("#totalAmount").text(total.toFixed(2));
        $("#discountApplied").text(discountAmount.toFixed(2));
        $("#grandTotal").text(grandTotal.toFixed(2));

        $("#subTotalInput").val(total.toFixed(2));
        $("#discountAmountInput").val(discountAmount.toFixed(2));
        $("#grandTotalInput").val(grandTotal.toFixed(2));
        
        // Update overall total when current order changes
        updateOverallTotal();
    }

    function fetchAllProducts(selectElement) {
        let tableid = "{{ $id }}";

        $.ajax({
            url: '/api/products/search/' + tableid,
            method: 'GET',
            data: {
                query: ''
            },
            success: function(data) {
                selectElement.empty().append('<option value="">-- Select Item --</option>');
                data.forEach(product => {
                    selectElement.append(
                        `<option data-id="${product.id}" data-price="${product.price}" value="${product.id}">${product.name}</option>`
                    );
                });
            },
            error: function() {
                console.error('Failed to fetch products');
                // Fallback: add some dummy products for demo
                const dummyProducts = [{
                        id: 1,
                        name: 'Pizza Margherita',
                        price: 12.99
                    },
                    {
                        id: 2,
                        name: 'Chicken Burger',
                        price: 8.99
                    },
                    {
                        id: 3,
                        name: 'Caesar Salad',
                        price: 7.99
                    }
                ];
                selectElement.empty().append('<option value="">-- Select Item --</option>');
                dummyProducts.forEach(product => {
                    selectElement.append(
                        `<option value="${product.id}">${product.name}</option>`
                    );
                });
            }
        });
    }

    function fetchVariationsByProductId(id, selectElement) {
        if (!id) {
            selectElement.closest('.col-md-4, .col-md-3').html(
                `<select class="form-control item-variation" name="variation_id[]" required><option value="">Select Variation</option></select>`
            );
            updateTotal();
            return;
        }
        $.ajax({
            url: '/api/products/' + id,
            method: 'GET',
            success: function(product) {
                const options = product.variations || [];
                const variationContainer = selectElement.closest('.col-md-4, .col-md-3');

                if (options.length > 0) {
                    const selectHTML = `
                        <select class="form-control item-variation" name="variation_id[]" required>
                            <option value="">Select Variation</option>
                            ${options.map(opt => `<option data-price="${opt.price}" value="${opt.id}">${opt.name} - Rs. ${opt.price}</option>`).join('')}
                        </select>
                    `;
                    variationContainer.html(selectHTML);
                } else {
                    const basePrice = product.price || 0;
                    const staticHTML =
                        `<input type="text" class="form-control item-variation" data-price="${basePrice}" value="Price - Rs. ${basePrice}" readonly>`;
                    variationContainer.html(staticHTML);
                }

                updateTotal();
            },
            error: function() {
                console.error('Failed to fetch product variations');
                // Fallback
                const variationContainer = selectElement.closest('.col-md-4, .col-md-3');
                const staticHTML =
                    `<input type="text" class="form-control item-variation" data-price="0" value="Standard" readonly>`;
                variationContainer.html(staticHTML);
                updateTotal();
            }
        });
    }

    // Event Listeners
    $(document).on('change', '.item-search', function() {
        const menuId = $(this).val();
        const variationSelect = $(this).closest('.itemRow').find('.item-variation');
        fetchVariationsByProductId(menuId, variationSelect);
        updateTotal();
    });

    $(document).on('change', '.item-variation, .item-qty', updateTotal);

    $(document).on('click', '#addItemBtn', function() {
        const itemRow = `<div class="itemRow row g-2 align-items-end mb-2">
            <div class="col-md-6">
                <label class="form-label visually-hidden">Item</label>
                <select class="form-control item-search" name="menu_id[]" required>
                    <option value="">-- Select Item --</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label visually-hidden">Variation</label>
                <select class="form-control item-variation" name="variation_id[]" required>
                    <option value="">Select Variation</option>
                </select>
            </div>
            <div class="col-md-1">
                <label class="form-label visually-hidden">Qty</label>
                <input type="number" class="form-control item-qty" name="qty[]" placeholder="Qty" min="1" value="1" required>
            </div>
            <div class="col-md-1 text-end">
                <button type="button" class="btn btn-outline-danger btn-sm btn-remove" title="Remove">
                    <i class="fa-solid fa-trash"></i>
                </button>
            </div>
        </div>`;
        $('#itemsContainer').append(itemRow);
        fetchAllProducts($('#itemsContainer .itemRow:last .item-search'));
    });

    $(document).on('click', '.btn-remove', function() {
        if ($('.itemRow').length > 1) {
            $(this).closest('.itemRow').remove();
            updateTotal();
        } else {
            alert('At least one item is required.');
        }
    });

    $('#customer_phone').on('input', function() {
        const phone = $(this).val().trim();
        if (phone.length >= 10) {
            debouncedCheckCustomer(phone);
        } else {
            $('#phone-feedback').html('');
            $('#clearPhone').addClass('d-none');
            $('#customer_id').val(''); // Clear customer ID if phone is incomplete
            hideRecentOrders();
        }
    });

    // Clear phone quickly
    $('#clearPhone').on('click', function() {
        $('#customer_phone').val('').trigger('input').focus();
        $('#customer_id').val(''); // Clear customer ID
        $(this).addClass('d-none');
        hideRecentOrders();
    });

    // Reset customer form
    $('#resetCustomer').on('click', function() {
        $('#customer_phone').val('');
        $('#customer_name').val('');
        $('#customer_email').val('');
        $('#customer_id').val('');
        $('#phone-feedback').html('');
        $('#clearPhone').addClass('d-none');
        hideRecentOrders();
    });

    $(document).ready(function() {
        fetchAllProducts($('.item-search'));
        updateTotal();
        hideRecentOrders();
    });

    // Form validation before submission
    $('#orderForm').on('submit', function(e) {
        console.log('Form submission started');

        // Validate customer details
        if (!$('#customer_phone').val() || !$('#customer_name').val()) {
            e.preventDefault();
            alert('Please fill in customer phone and name.');
            return false;
        }

        // Check if customer_id is set
        const customerId = $('#customer_id').val();
        console.log('Customer ID being submitted:', customerId);

        // Validate at least one item is added
        const itemCount = $('.itemRow').length;
        if (itemCount === 0) {
            e.preventDefault();
            alert('Please add at least one item to the order.');
            return false;
        }

        // Validate all items have selections
        let valid = true;
        $('.itemRow').each(function() {
            const menuId = $(this).find('.item-search').val();
            const variation = $(this).find('.item-variation');

            if (!menuId) {
                valid = false;
                $(this).find('.item-search').addClass('is-invalid');
            } else {
                $(this).find('.item-search').removeClass('is-invalid');
            }

            if (variation.is('select') && !variation.val()) {
                valid = false;
                variation.addClass('is-invalid');
            } else {
                variation.removeClass('is-invalid');
            }
        });

        if (!valid) {
            e.preventDefault();
            alert('Please select both item and variation for all order items.');
            return false;
        }

        console.log('Form validation passed, submitting...');
    });

    // Add customer via AJAX (for modal)
    $('#addCustomerForm').on('submit', function(e) {
        e.preventDefault();

        const formData = {
            name: $('#newCustomerName').val(),
            phone: $('#newCustomerPhone').val(),
            email: $('#newCustomerEmail').val(),
            _token: '{{ csrf_token() }}'
        };

        $.ajax({
            url: '/api/customers/store',
            type: 'POST',
            data: formData,
            success: function(response) {
                console.log('New customer created:', response);

                // Update the main form with new customer data
                $('#customer_phone').val(response.phone);
                $('#customer_name').val(response.name);
                $('#customer_email').val(response.email || '');

                // IMPORTANT: Set the customer ID from the new customer
                if (response.id) {
                    $('#customer_id').val(response.id);
                    console.log('New customer ID set to:', response.id);
                }

                $('#addCustomerModal').modal('hide');
                $('#addCustomerForm')[0].reset();

                alert('Customer added successfully!');
            },
            error: function(xhr) {
                console.error('Error adding customer:', xhr);
                alert('Failed to add customer. Please try again.');
            }
        });
    });
</script>
</body>

</html>
