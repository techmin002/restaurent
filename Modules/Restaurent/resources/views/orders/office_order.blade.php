<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create Order | Office Management</title>
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
            --glass: rgba(255, 255, 255, 0.9);
            --radius: 12px;
        }

        html,
        body {
            height: 100%;
            font-family: Inter, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
            background: var(--bg);
            margin: 0;
        }

        .app-shell {
            padding: 22px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .topnav {
            background: linear-gradient(90deg, #0b4b8a, #063459);
            color: #fff;
            padding: 12px 18px;
            border-radius: var(--radius);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 18px;
        }

        .topnav .brand {
            display: flex;
            align-items: center;
            gap: 12px;
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
            font-weight: 700;
        }

        .small-muted {
            color: var(--muted);
            font-size: .9rem;
        }

        .card-shadow {
            box-shadow: 0 6px 18px rgba(35, 47, 52, 0.06);
            border-radius: var(--radius);
            border: 0;
            background: var(--glass);
        }

        .card-header-prim {
            background: linear-gradient(90deg, var(--primary), var(--accent));
            color: #fff;
            border-top-left-radius: var(--radius);
            border-top-right-radius: var(--radius);
            padding: 14px 18px;
        }

        .order-summary {
            background: linear-gradient(180deg, #fff, #f8fafc);
            padding: 14px;
            border-radius: 10px;
        }

        .btn-wide {
            min-width: 140px;
        }

        .badge-soft {
            background: rgba(11, 125, 209, 0.12);
            color: var(--accent);
            padding: .35rem .6rem;
            border-radius: .7rem;
            font-weight: 600;
        }

        footer {
            padding: 18px;
            text-align: center;
            color: var(--muted);
            font-size: .9rem;
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
            font-size: 1.4rem;
        }

        .form-label.fw-600 {
            font-weight: 600;
        }

        .itemRow .form-label {
            font-size: .85rem;
            color: var(--muted);
        }

        .visually-hidden {
            position: absolute !important;
            height: 1px;
            width: 1px;
            overflow: hidden;
            clip: rect(1px, 1px, 1px, 1px);
            white-space: nowrap;
        }

        .customer-section {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .discount-section {
            background: #fff8e1;
            padding: 15px;
            border-radius: 8px;
            margin: 15px 0;
        }

        /* Recent Orders Styling */
        .recent-orders {
            max-height: 300px;
            overflow-y: auto;
            padding: 16px;
            background: linear-gradient(135deg, #f8f9ff 0%, #f0f2ff 100%);
            border-radius: 12px;
            margin: 16px;
            border: 1px solid #e1e5ff;
            box-shadow: 0 2px 8px rgba(13, 110, 253, 0.08);
            display: none;
        }

        .recent-orders-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
            padding-bottom: 8px;
            border-bottom: 1px solid #e1e5ff;
        }

        .recent-orders-header h6 {
            margin: 0;
            color: var(--primary);
            font-weight: 700;
        }

        .recent-orders-count {
            background: var(--primary);
            color: white;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .recent-orders .order-item {
            padding: 12px;
            border-radius: 10px;
            background: white;
            margin-bottom: 10px;
            border-left: 4px solid var(--primary);
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.04);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .recent-orders .order-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        .recent-orders .order-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
            font-weight: 600;
        }

        .recent-orders .order-id {
            font-size: 0.9rem;
            color: var(--primary);
        }

        .recent-orders .order-status {
            font-size: 0.75rem;
            padding: 4px 10px;
            border-radius: 20px;
            font-weight: 600;
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

        .recent-orders .status-completed {
            background: #d1f7e4;
            color: #0f5132;
        }

        .recent-orders .order-time {
            font-size: 0.8rem;
            color: var(--muted);
            margin-bottom: 8px;
        }

        .recent-orders .order-items {
            font-size: 0.85rem;
            color: var(--muted);
            line-height: 1.4;
        }

        .recent-orders .order-total {
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--primary);
            margin-top: 6px;
            text-align: right;
        }

        @media (max-width: 768px) {
            .topnav {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>
</head>

<body>
    <div class="app-shell">
        <div class="topnav">
            <div class="brand">
                <div class="logo">R</div>
                <div>
                    <div style="font-weight:700">BG RestroCare</div>
                    <div class="small-muted">Office Orders</div>
                </div>
            </div>

            <div class="d-flex align-items-center gap-3">
                <div class="small-muted d-none d-md-block text-end me-2">
                    <div>Hello, Admin</div>
                    <div class="small-muted">Today: {{ \Carbon\Carbon::now()->format('d M, Y') }}</div>
                </div>
                <button class="btn btn-outline-light btn-sm"><i class="fa-regular fa-bell"></i></button>
                <button class="btn btn-light btn-sm" id="compactNavToggle"><i class="fa-solid fa-bars"></i></button>
            </div>
        </div>

        <main class="main">
            <div class="topbar d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h3 class="mb-0">Create New Order</h3>
                    <div class="small-muted">Make an order from office for delivery</div>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <button class="btn btn-outline-secondary btn-sm"><i class="fa-regular fa-bell"></i></button>
                    <span class="badge-soft">Office Order</span>
                </div>
            </div>

            <div class="row g-4">
                <!-- Office Details (left) -->
                <div class="col-lg-5">
                    <div class="card card-shadow">
                        <div class="card-header-prim">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <h5 class="mb-0">Office Details</h5>
                                    <small class="small-muted">Auto-filled for this office</small>
                                </div>
                                <div class="small-muted">Office Info</div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex gap-3 align-items-center mb-3">
                                <div class="cust-avatar"><i class="fa-solid fa-building"></i></div>
                                <div>
                                    <h6 class="mb-0">{{ $office->name ?? 'N/A' }}</h6>
                                    <div class="small-muted">{{ $office->address ?? 'Address not available' }}</div>
                                </div>
                            </div>

                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label fw-600">Office Name</label>
                                    <input type="text" class="form-control" value="{{ $office->name ?? 'N/A' }}"
                                        readonly>
                                </div>

                                <div class="col-12">
                                    <label class="form-label fw-600">Office Phone</label>
                                    <input type="text" class="form-control"
                                        value="{{ $office->contact_numbers ?? 'N/A' }}" readonly>
                                </div>

                                <div class="col-12">
                                    <label class="form-label fw-600">Location</label>
                                    <input type="text" class="form-control" value="{{ $office->address ?? 'N/A' }}"
                                        readonly>
                                </div>

                                <div class="col-12 mt-2">
                                    <div class="small-muted">Restaurant:
                                        <strong>{{ $office->restaurent->name ?? ($office->restaurent_id ?? 'N/A') }}</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Details (right) -->
                <div class="col-lg-7">
                    <div class="card card-shadow">
                        <div class="card-header-prim">
                            <div class="d-flex align-items-center justify-content-between">
                                <h5 class="mb-0">Order Details</h5>
                                <div class="small-muted">Create items and place order</div>
                            </div>
                        </div>

                        <form id="orderForm" action="{{ route('office.orders.submit') }}" method="post">
                            @csrf
                            <!-- Hidden fields for order data -->
                            <input type="hidden" name="office_id" value="{{ $office->id ?? '' }}">
                            <input type="hidden" name="restaurent_id" value="{{ $office->restaurent_id ?? '' }}">
                            <input type="hidden" name="created_by" value="{{ auth()->id() ?? 1 }}">
                            <input type="hidden" name="orderType" value="office">
                            <input type="hidden" name="order_from" value="web">
                            <input type="hidden" name="order_time" value="{{ now() }}">

                            <div class="card-body">
                                <!-- Recent Orders Section -->
                                <div id="recentOrdersContainer" class="recent-orders"></div>

                                <!-- Customer Section -->
                                <div class="customer-section">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <h6 class="mb-0">Customer Information</h6>
                                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#addCustomerModal">
                                            <i class="fa-solid fa-plus me-1"></i> Add Customer
                                        </button>
                                    </div>
                                    <div class="form-group">
                                        <label for="customerName" class="form-label">Select Customer</label>
                                        <select class="form-control" id="customerName" name="customer_id" required>
                                            <option value="">-- Select Customer --</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Items Section -->
                                <div id="itemsContainer">
                                    <div class="d-flex justify-content-between align-items-end mb-3">
                                        <div>
                                            <h6 class="mb-0">Order Items</h6>
                                            <small class="small-muted">Select menu items & variations</small>
                                        </div>
                                        <div>
                                            <button type="button" id="addItemBtn" class="btn btn-success btn-sm">
                                                <i class="fa-solid fa-plus me-1"></i> Add Item
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Initial Item Row -->
                                    <div class="itemRow row g-2 align-items-end mb-2">
                                        <div class="col-md-5">
                                            <label class="form-label small-muted">Item</label>
                                            <select class="form-control item-search" name="menu_id[]" required>
                                                <option value="">-- Select Item --</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label small-muted">Variation</label>
                                            <div class="variation-container">
                                                <select class="form-control item-variation" name="variation_id[]"
                                                    required>
                                                    <option value="">Select Variation</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="form-label small-muted">Qty</label>
                                            <input type="number" name="qty[]" class="form-control item-qty"
                                                placeholder="Qty" min="1" value="1" required>
                                        </div>
                                        <div class="col-md-1 text-end">
                                            <button type="button" class="btn btn-outline-danger btn-sm btn-remove"
                                                title="Remove">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Remarks / Message</label>
                                    <textarea class="form-control" id="remarks" name="remarks" rows="2"
                                        placeholder="Any special instructions..."></textarea>
                                </div>

                                <div
                                    class="order-summary d-flex gap-3 align-items-center justify-content-between mt-3">
                                    <div>
                                        <div class="small-muted">Current Order</div>
                                        <h4 id="totalAmount" class="mb-0">0.00</h4>
                                    </div>
                                    <div>
                                        <div class="small-muted">Recent Orders</div>
                                        <h5 id="recentOrdersTotal" class="mb-0">0.00</h5>
                                    </div>
                                    <div>
                                        <div class="small-muted">Grand Total</div>
                                        <h3 id="grandTotal" class="mb-0 text-success">0.00</h3>
                                    </div>
                                    <div class="ms-3">
                                        <button type="submit" class="btn btn-primary btn-wide">
                                            <i class="fa-solid fa-check me-1"></i> Place Order
                                        </button>
                                    </div>
                                </div>

                                <!-- Hidden inputs for calculated values -->
                                <input type="hidden" name="sub_total" id="subTotalInput" value="0">
                                <input type="hidden" name="discount_amount" id="discountAmountInput"
                                    value="0">
                                <input type="hidden" name="grand_total" id="grandTotalInput" value="0">
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <footer class="mt-4">
                © {{ date('Y') }} Restaurant Admin • Crafted for operations
            </footer>
        </main>
    </div>

    <!-- Add Customer Modal -->
    <div class="modal fade" id="addCustomerModal" tabindex="-1" aria-labelledby="addCustomerModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCustomerModalLabel">Add New Customer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addCustomerForm">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="newCustomerName" class="form-label">Name *</label>
                            <input type="text" class="form-control" id="newCustomerName" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="newCustomerPhone" class="form-label">Phone</label>
                            <input type="text" class="form-control" id="newCustomerPhone" name="phone">
                        </div>
                        <div class="mb-3">
                            <label for="newCustomerEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="newCustomerEmail" name="email">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">
                            <i class="fa-solid fa-save me-1"></i> Save Customer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- JS: jQuery and Bootstrap bundle -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

    <script>
        // Global variables
        let customers = [];
        let products = [];
        let userRestaurantId = "{{ $office->restaurent_id ?? '' }}";
        let recentOrdersTotal = 0;

        // Initialize the application
        $(document).ready(function() {
            fetchCustomers();
            fetchProductsByRestaurant(userRestaurantId, $('.item-search'));
            updateTotal();
            hideRecentOrders();

            // Initialize event listeners
            initializeEventListeners();
        });

        // Fetch customers from API
        function fetchCustomers() {
            console.log('Fetching customers from:', '/api/customers');

            $.ajax({
                url: '/api/customers',
                method: 'GET',
                success: function(data) {
                    console.log('Customers API response:', data);
                    customers = data;

                    if (data && data.length > 0) {
                        populateCustomerSelect(data);
                    } else {
                        console.log('No customers found in response');
                        // Add fallback dummy data
                        const dummyCustomers = [{
                                id: 1,
                                name: 'John Doe',
                                phone: '123-456-7890'
                            },
                            {
                                id: 2,
                                name: 'Jane Smith',
                                phone: '098-765-4321'
                            },
                            {
                                id: 3,
                                name: 'Robert Johnson',
                                phone: '555-123-4567'
                            }
                        ];
                        populateCustomerSelect(dummyCustomers);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Failed to fetch customers:', error);
                    console.log('Status:', status);
                    console.log('XHR response:', xhr.responseText);

                    // Add fallback dummy data
                    const dummyCustomers = [{
                            id: 1,
                            name: 'John Doe',
                            phone: '123-456-7890'
                        },
                        {
                            id: 2,
                            name: 'Jane Smith',
                            phone: '098-765-4321'
                        },
                        {
                            id: 3,
                            name: 'Robert Johnson',
                            phone: '555-123-4567'
                        }
                    ];
                    populateCustomerSelect(dummyCustomers);
                }
            });
        }

        // Populate customer select dropdown
        function populateCustomerSelect(customerList) {
            const customerSelect = $('#customerName');
            customerSelect.empty().append('<option value="">-- Select Customer --</option>');

            if (customerList && customerList.length > 0) {
                console.log('Populating customers:', customerList.length, 'customers found');
                customerList.forEach(customer => {
                    const displayText = customer.phone ?
                        `${customer.name} - ${customer.phone}` : customer.name;
                    customerSelect.append(
                        `<option value="${customer.id}">${displayText}</option>`
                    );
                });
            } else {
                console.log('No customers to populate');
                customerSelect.append('<option value="">No customers found</option>');
            }
        }

        // Fetch recent orders for selected customer
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

        // Display recent orders
        function displayRecentOrders(orders) {
            const container = $('#recentOrdersContainer');

            if (!orders || orders.length === 0) {
                container.html('<div class="text-center text-muted p-3">No incomplete orders found</div>').show();
                recentOrdersTotal = 0;
                updateRecentOrdersTotalDisplay();
                updateOverallTotal();
                return;
            }

            let html = `
                <div class="recent-orders-header">
                    <h6><i class="fas fa-history me-2"></i>Recent Incomplete Orders</h6>
                    <span class="recent-orders-count">${orders.length} orders</span>
                </div>
            `;

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
                            <span class="order-id">Order #${order.id}</span>
                            <span class="order-status ${statusClass}">${order.status.toUpperCase()}</span>
                        </div>
                        <div class="order-time">
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
                        ${order.table_number ? `
                            <div class="order-location">
                                <i class="fas fa-table me-1"></i>Table: ${order.table_number}
                            </div>
                        ` : ''}
                        <div class="order-total">
                            Total: Rs. ${orderTotal.toFixed(2)}
                        </div>
                    </div>
                `;
            });

            container.html(html).show();
            updateRecentOrdersTotalDisplay();
            updateOverallTotal();
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

        // Hide recent orders container
        function hideRecentOrders() {
            $('#recentOrdersContainer').hide().html('');
            recentOrdersTotal = 0;
            updateRecentOrdersTotalDisplay();
            updateOverallTotal();
        }

        // Update recent orders total display
        function updateRecentOrdersTotalDisplay() {
            $('#recentOrdersTotal').text(recentOrdersTotal.toFixed(2));
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

        // Add new customer via form
        $('#addCustomerForm').on('submit', function(e) {
            e.preventDefault();

            const formData = {
                name: $('#newCustomerName').val(),
                phone: $('#newCustomerPhone').val(),
                email: $('#newCustomerEmail').val(),
                _token: $('meta[name="csrf-token"]').attr('content')
            };

            $.ajax({
                url: '/api/customers/store',
                method: 'POST',
                data: formData,
                success: function(response) {
                    // Add new customer to the select and select it
                    const displayText = response.phone ?
                        `${response.name} - ${response.phone}` : response.name;
                    $('#customerName').append(
                        `<option value="${response.id}" selected>${displayText}</option>`
                    );

                    // Close modal and reset form
                    $('#addCustomerModal').modal('hide');
                    $('#addCustomerForm')[0].reset();

                    // Show success message
                    alert('Customer added successfully!');
                },
                error: function(xhr, status, error) {
                    console.error('Failed to add customer:', error);
                    alert('Failed to add customer. Please try again.');
                }
            });
        });

        // Calculate discount
        function calculateDiscount(subTotal, discountType, discountValue) {
            let discountAmount = 0;

            if (discountType && discountValue) {
                if (discountType === 'fixed') {
                    discountAmount = Math.min(parseFloat(discountValue), subTotal);
                } else if (discountType === 'percentage') {
                    discountAmount = (subTotal * parseFloat(discountValue)) / 100;
                }
            }

            return discountAmount;
        }

        // Update total amounts
        function updateTotal() {
            let subTotal = 0;

            // Calculate subtotal from items
            $(".itemRow").each(function() {
                const qty = parseFloat($(this).find(".item-qty").val()) || 0;
                let price = 0;

                // Try to get price from variation select
                const variationSelect = $(this).find(".item-variation");
                if (variationSelect.is('select')) {
                    price = parseFloat(variationSelect.find("option:selected").data("price")) || 0;
                } else {
                    // If it's a static input (no variations)
                    price = parseFloat(variationSelect.data("price")) || 0;
                }

                subTotal += qty * price;
            });

            // Calculate discount
            const discountType = $("#discountType").val();
            const discountValue = parseFloat($("#discountValue").val()) || 0;
            const discountAmount = calculateDiscount(subTotal, discountType, discountValue);
            const grandTotal = subTotal - discountAmount;

            // Update display
            $("#totalAmount").text(subTotal.toFixed(2));
            $("#discountApplied").text(discountAmount.toFixed(2));

            // Update hidden inputs
            $("#subTotalInput").val(subTotal.toFixed(2));
            $("#discountAmountInput").val(discountAmount.toFixed(2));
            
            // Update overall total when current order changes
            updateOverallTotal();
        }

        // Fetch products by restaurant ID
        function fetchProductsByRestaurant(restaurantId, selectElement) {
            if (!restaurantId) {
                console.error('No restaurant ID provided');
                selectElement.empty().append('<option value="">-- No Items Available --</option>');
                return;
            }

            // Use the search endpoint that works with table ID 0 (for office orders)
            $.ajax({
                url: '/api/products/search/0', // Using 0 as placeholder for office orders
                method: 'GET',
                data: {
                    query: '',
                    restaurant_id: restaurantId
                },
                success: function(data) {
                    products = data;
                    selectElement.empty().append('<option value="">-- Select Item --</option>');

                    if (data.length === 0) {
                        selectElement.append(
                            '<option value="">No items available for this restaurant</option>');
                    } else {
                        data.forEach(product => {
                            selectElement.append(
                                `<option value="${product.id}">${product.name}</option>`
                            );
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Failed to fetch products:', error);

                    // Alternative: Try the by-restaurant endpoint without table_id
                    $.ajax({
                        url: '/api/products/by-restaurant/' + restaurantId,
                        method: 'GET',
                        success: function(fallbackData) {
                            products = fallbackData;
                            selectElement.empty().append(
                                '<option value="">-- Select Item --</option>');
                            if (fallbackData.length === 0) {
                                selectElement.append(
                                    '<option value="">No items available</option>');
                            } else {
                                fallbackData.forEach(product => {
                                    selectElement.append(
                                        `<option value="${product.id}">${product.name}</option>`
                                    );
                                });
                            }
                        },
                        error: function() {
                            // Final fallback with dummy data
                            console.log('Using fallback dummy data');
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
                            selectElement.empty().append(
                                '<option value="">-- Select Item --</option>');
                            dummyProducts.forEach(product => {
                                selectElement.append(
                                    `<option value="${product.id}">${product.name}</option>`
                                );
                            });
                        }
                    });
                }
            });
        }

        // Fetch variations by product ID with restaurant filter
        function fetchVariationsByProductId(id, selectElement) {
            if (!id) {
                selectElement.closest('.variation-container').html(
                    `<select class="form-control item-variation" name="variation_id[]" required>
                        <option value="">Select Variation</option>
                    </select>`
                );
                updateTotal();
                return;
            }

            $.ajax({
                url: '/api/products/' + id,
                method: 'GET',
                data: {
                    restaurant_id: userRestaurantId
                },
                success: function(product) {
                    const options = product.variations || [];
                    const variationContainer = selectElement.closest('.variation-container');

                    if (options.length > 0) {
                        const selectHTML =
                            `<select class="form-control item-variation" name="variation_id[]" required>
                                <option value="">Select Variation</option>
                                ${options.map(opt => 
                                    `<option data-price="${opt.price}" value="${opt.id}">
                                                    ${opt.name} - Rs. ${opt.price}
                                                </option>`
                                ).join('')}
                            </select>`;
                        variationContainer.html(selectHTML);
                    } else {
                        const basePrice = product.price || 0;
                        const staticHTML =
                            `<input type="text" class="form-control item-variation" 
                                data-price="${basePrice}" 
                                value="Standard - Rs. ${basePrice}" 
                                readonly>`;
                        variationContainer.html(staticHTML);
                    }
                    updateTotal();
                },
                error: function(xhr, status, error) {
                    console.error('Failed to fetch product variations:', error);
                    // Fallback to standard price
                    const variationContainer = selectElement.closest('.variation-container');
                    const basePrice = 0; // Default price
                    const staticHTML =
                        `<input type="text" class="form-control item-variation" 
                            data-price="${basePrice}" 
                            value="Standard - Rs. ${basePrice}" 
                            readonly>`;
                    variationContainer.html(staticHTML);
                    updateTotal();
                }
            });
        }

        // Initialize event listeners
        function initializeEventListeners() {
            // Customer selection change - fetch recent orders
            $(document).on('change', '#customerName', function() {
                const customerId = $(this).val();
                if (customerId) {
                    fetchRecentOrders(customerId);
                } else {
                    hideRecentOrders();
                }
            });

            // Item search change
            $(document).on('change', '.item-search', function() {
                const menuId = $(this).val();
                const variationSelect = $(this).closest('.itemRow').find('.item-variation');
                fetchVariationsByProductId(menuId, variationSelect);
            });

            // Variation and quantity change
            $(document).on('change', '.item-variation, .item-qty', updateTotal);

            // Discount type change
            $(document).on('change', '#discountType', function() {
                const discountType = $(this).val();
                const discountValueInput = $('#discountValue');

                if (discountType) {
                    discountValueInput.prop('disabled', false);
                    discountValueInput.val('');
                } else {
                    discountValueInput.prop('disabled', true);
                    discountValueInput.val('0');
                }
                updateTotal();
            });

            // Discount value input
            $(document).on('input', '#discountValue', updateTotal);

            // Add item button
            $(document).on('click', '#addItemBtn', function() {
                const itemRow = `<div class="itemRow row g-2 align-items-end mb-2">
                    <div class="col-md-5">
                        <label class="form-label visually-hidden">Item</label>
                        <select class="form-control item-search" name="menu_id[]" required>
                            <option value="">-- Select Item --</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label visually-hidden">Variation</label>
                        <div class="variation-container">
                            <select class="form-control item-variation" name="variation_id[]" required>
                                <option value="">Select Variation</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label visually-hidden">Qty</label>
                        <input type="number" class="form-control item-qty" name="qty[]" 
                            placeholder="Qty" min="1" value="1" required>
                    </div>
                    <div class="col-md-1 text-end">
                        <button type="button" class="btn btn-outline-danger btn-sm btn-remove" title="Remove">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </div>
                </div>`;

                $('#itemsContainer').append(itemRow);
                fetchProductsByRestaurant(userRestaurantId, $('#itemsContainer .itemRow:last .item-search'));
            });

            // Remove item button
            $(document).on('click', '.btn-remove', function() {
                if ($('.itemRow').length > 1) {
                    $(this).closest('.itemRow').remove();
                    updateTotal();
                } else {
                    alert('At least one item is required.');
                }
            });

            // Form submission
            $('#orderForm').on('submit', function(e) {
                const itemCount = $('.itemRow').length;
                if (itemCount === 0) {
                    e.preventDefault();
                    alert('Please add at least one item to the order.');
                    return false;
                }

                // Validate customer selection
                const customerId = $('#customerName').val();
                if (!customerId) {
                    e.preventDefault();
                    alert('Please select a customer for this order.');
                    $('#customerName').focus();
                    return false;
                }

                // Validate that all items have selections
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
            });
        }
    </script>
</body>

</html>