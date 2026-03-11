<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

{{-- @can('access_sidebar_management') --}}
<!-- Your app.js or bootstrap.js script -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{ route('home') }}" class="nav-link">Home</a>
        </li>
        {{-- <li class="nav-item">    <button onclick="document.getElementById('notificationAudio').play()">Test Sound</button> --}}
        </li>
    </ul>

    <ul class="navbar-nav ml-auto">
        <li class="nav-link">
            <form class="form-inline my-2 my-lg-0" action="https://classicro.com.np/customer/search" method="get">
                @csrf
                <input class="form-control mr-sm-2" name="username" placeholder="Username">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                <i class="fas fa-th-large"></i>
            </a>
        </li>
        @can('access_counter_management')
            <button id="counterBtn" class="counter-custom-btn" data-state="open">
                <i class="fa-solid fa-toggle-on counter-btn-icon"></i>
                <span class="counter-btn-text">Open Counter</span>
            </button>

            <!-- Close Counter Modal -->
            <div id="closeCounterModal" class="counter-close-modal">
                <div class="counter-modal-content">
                    <!-- Modal Header -->
                    <div class="counter-modal-header">
                        <div class="counter-header-icon" id="printModalBtn" style="cursor:pointer;">
                            <i class="fas fa-print"></i>
                        </div>
                        <div class="counter-header-text">
                            @php
                                $profile = \Modules\Setting\Entities\CompanyProfile::first();
                            @endphp
                            <h2>{{ $branch->name ?? $profile->company_name }}</h2>
                            <p>Daily Counter Summary</p>
                            <p id="summaryDate" class="counter-summary-date"></p>
                        </div>
                        <button class="counter-close-btn" id="modalCloseBtn">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>

                    <!-- Modal Body -->
                    <div class="counter-modal-body">
                        <div id="modalData"></div>
                    </div>
                </div>
            </div>

            <!-- Audio for notifications -->
            <audio id="counterNotificationSound" preload="auto">
                <source src="{{ asset('sounds/notification.mp3') }}" type="audio/mpeg">
            </audio>
        @endcan

        @guest
            @if (Route::has('login'))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                </li>
            @endif

            @if (Route::has('register'))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                </li>
            @endif
        @else
            <li class="nav-item dropdown">
                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    @if (!auth()->user()->image)
                        <i class="fa fa-user"></i>
                    @else
                        <img src="{{ asset('upload/images/users/' . auth()->user()->image) }}"
                            class="img-circle elevation-2" alt="User Image" height="100%">
                    @endif
                    {{ Auth::user()->name }}
                </a>

                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="{{ route('profile.edit') }}">
                        <i class="fas fa-user"></i>
                        {{ __('Profile') }}
                    </a>
                    <a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-arrow-right"></i>
                        {{ __('Logout') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </li>
        @endguest
    </ul>
</nav>

<!-- New Orders Modal -->
<div class="modal fade" id="newOrderModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">

            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="fas fa-bell me-2"></i>New Orders Alert
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle" id="newOrdersTable">
                        <thead class="table-light">
                            <tr>
                                <th>Order ID</th>
                                <th>Table Type</th>
                                <th>Total Amount</th>
                                <th>Items</th>
                                <th>Table ID</th>
                                <th>Customer Name</th>
                                <th>Costumer Contact</th>
                                <th>Office Name</th>
                                <th>Contact No.</th>
                                <th>Address</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="newOrdersBody">
                            <!-- Orders Will Load Here -->
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>
<style>
    #newOrdersTable th,
    #newOrdersTable td {
        font-size: 14px;
        padding: 10px;
    }

    .btn-accept {
        background: #198754;
        color: white;
        border-radius: 6px;
        padding: 5px 12px;
    }

    .btn-reject {
        background: #dc3545;
        color: white;
        border-radius: 6px;
        padding: 5px 12px;
    }

    .item-badge {
        display: inline-block;
        background: #f1f1f1;
        padding: 3px 8px;
        margin: 2px;
        border-radius: 4px;
        font-size: 12px;
    }
</style>
<audio id="newOrderSound" src="{{ asset('sounds/order_received_audio.mp3') }}" preload="auto"></audio>


@can('access_counter_management')
    {{-- Notification popups container --}}
    <div id="popupContainer"></div>
    <audio id="notifySound">
        <source src="{{ asset('sounds/order_completed_audio.mp3') }}" type="audio/mpeg">
    </audio>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let lastTables = [];
            const popupContainer = document.getElementById('popupContainer');

            function checkNotification() {
                fetch('/check-notification')
                    .then(res => res.json())
                    .then(data => {
                        if (data.notify == 1 && data.tables.length > 0) {
                            // Remove existing popups
                            popupContainer.innerHTML = '';

                            // Create separate popup for each table
                            data.tables.forEach((table, index) => {
                                const popup = document.createElement('div');
                                popup.className = 'popup';
                                popup.id = `popup-${table}`;
                                popup.style.top = `${20 + (index * 120)}px`; // Stack popups vertically

                                popup.innerHTML = `
                                <div class="popup-icon">🔔</div>
                                <div class="popup-content">
                                    <h4>Table ${table} Needs Attention</h4>
                                    <p>This table requires immediate service.</p>
                                    <button class="popup-btn" data-table="${table}">OK</button>
                                </div>
                                <span class="popup-close" data-table="${table}">&times;</span>
                            `;

                                popupContainer.appendChild(popup);

                                // Show popup with delay for visual effect
                                setTimeout(() => {
                                    popup.classList.add('show');
                                }, 100 * index);

                                // Add event listeners
                                const closeBtn = popup.querySelector('.popup-close');
                                const okBtn = popup.querySelector('.popup-btn');

                                closeBtn.addEventListener('click', () => closeSinglePopup(table));
                                okBtn.addEventListener('click', () => closeSinglePopup(table));
                            });

                            // Play sound if new tables arrived
                            if (JSON.stringify(data.tables) !== JSON.stringify(lastTables)) {
                                document.getElementById('notifySound').play();
                            }

                            lastTables = data.tables;

                        } else {
                            // No notifications, remove all popups
                            popupContainer.innerHTML = '';
                            lastTables = [];
                        }
                    })
                    .catch(err => console.error(err));
            }

            function closeSinglePopup(tableNumber) {
                const popup = document.getElementById(`popup-${tableNumber}`);
                if (popup) {
                    popup.classList.remove('show');
                    setTimeout(() => {
                        popup.remove();
                    }, 400);

                    // Reset notification for this specific table
                    fetch('/reset-single-notification', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            table_number: tableNumber
                        })
                    });
                }
            }

            setInterval(checkNotification, 3000);
            checkNotification();
        });
    </script>
    <style>
        .popup {
            position: fixed;
            top: 20px;
            right: -350px;
            width: 300px;
            background: #ff4b4b;
            color: white;
            padding: 20px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            gap: 12px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.2);
            z-index: 99999;
            transition: right 0.4s ease;
            font-family: Arial, sans-serif;
            margin-bottom: 10px;
        }

        .popup.show {
            right: 20px;
        }

        .popup-icon {
            font-size: 30px;
        }

        .popup-content h4 {
            margin: 0;
            font-size: 18px;
            font-weight: bold;
        }

        .popup-content p {
            margin: 0;
            font-size: 14px;
        }

        .popup-close {
            margin-left: auto;
            font-size: 22px;
            cursor: pointer;
            font-weight: bold;
        }

        .popup-close:hover {
            color: #000;
        }

        .popup-btn {
            background: white;
            color: #ff4b4b;
            border: none;
            padding: 8px 16px;
            border-radius: 8px;
            margin-top: 10px;
            font-weight: bold;
            cursor: pointer;
        }

        .popup-btn:hover {
            background: #ffe1e1;
        }
    </style>
@endcan


<!-- Counter Button -->
<style>
    /* Counter Button Styles - Unique Classes */
    .counter-custom-btn {
        background: linear-gradient(135deg, #3490dc 0%, #2779bd 100%);
        border: none;
        padding: 12px 24px;
        color: white;
        border-radius: 12px;
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 10px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(52, 144, 220, 0.3);
        position: relative;
        overflow: hidden;
    }

    .counter-custom-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s;
    }

    .counter-custom-btn:hover::before {
        left: 100%;
    }

    .counter-custom-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(52, 144, 220, 0.4);
    }

    .counter-custom-btn:active {
        transform: translateY(-1px);
    }

    .counter-custom-btn[data-state="close"] {
        background: linear-gradient(135deg, #e3342f 0%, #cc1f1a 100%);
        box-shadow: 0 4px 15px rgba(227, 52, 47, 0.3);
    }

    .counter-custom-btn[data-state="close"]:hover {
        box-shadow: 0 8px 25px rgba(227, 52, 47, 0.4);
    }

    .counter-btn-icon {
        font-size: 18px;
        transition: transform 0.3s ease;
    }

    .counter-custom-btn:hover .counter-btn-icon {
        transform: scale(1.1);
    }

    /* Modal Styles - Unique Classes */
    .counter-close-modal {
        display: none;
        position: fixed;
        top: 0;
        left: 120px;
        width: 100%;
        height: 100%;
        backdrop-filter: blur(8px);
        justify-content: center;
        align-items: center;
        z-index: 9999;
        animation: counterFadeIn 0.3s ease;
        padding: 20px;
    }

    @keyframes counterFadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    .counter-modal-content {
        background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
        border-radius: 20px;
        width: 80%;
        max-width: 1200px;
        max-height: 90vh;
        overflow: hidden;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        animation: counterSlideUp 0.4s ease;
        display: flex;
        flex-direction: column;
    }

    @keyframes counterSlideUp {
        from {
            transform: translateY(50px);
            opacity: 0;
        }

        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    .counter-modal-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 25px 30px;
        position: relative;
    }

    .counter-header-icon {
        position: absolute;
        left: 30px;
        top: 50%;
        transform: translateY(-50%);
        background: rgba(255, 255, 255, 0.2);
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        backdrop-filter: blur(10px);
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .counter-header-icon:hover {
        background: rgba(255, 255, 255, 0.3);
        transform: translateY(-50%) scale(1.1);
    }

    .counter-header-text {
        text-align: center;
        padding: 0 60px;
    }

    .counter-header-text h2 {
        margin: 0;
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 5px;
    }

    .counter-header-text p {
        margin: 0;
        opacity: 0.9;
        font-size: 15px;
    }

    .counter-summary-date {
        margin-top: 5px;
        font-size: 14px;
        opacity: 0.8;
        font-weight: 500;
    }

    .counter-close-btn {
        position: absolute;
        top: 20px;
        right: 20px;
        background: rgba(255, 255, 255, 0.2);
        border: none;
        color: white;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        backdrop-filter: blur(10px);
    }

    .counter-close-btn:hover {
        background: rgba(255, 255, 255, 0.3);
        transform: rotate(90deg);
    }

    .counter-modal-body {
        flex: 1;
        overflow-y: auto;
        padding: 0;
    }

    /* Summary Section - Unique Classes */
    .counter-summary-section {
        padding: 25px;
        background: #f8f9fa;
    }

    .counter-summary-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 20px;
    }

    .counter-summary-card {
        background: white;
        border-radius: 16px;
        padding: 20px;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.08);
        display: flex;
        gap: 20px;
        transition: transform 0.3s ease;
    }

    .counter-summary-card:hover {
        transform: translateY(-5px);
    }

    .counter-summary-card.counter-cash-card {
        border-left: 4px solid #28a745;
    }

    .counter-summary-card.counter-bank-card {
        border-left: 4px solid #007bff;
    }

    .counter-summary-card.counter-overall-card {
        border-left: 4px solid #ff6b6b;
    }

    .counter-card-icon {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        color: white;
    }

    .counter-cash-card .counter-card-icon {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    }

    .counter-bank-card .counter-card-icon {
        background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
    }

    .counter-overall-card .counter-card-icon {
        background: linear-gradient(135deg, #ff6b6b 0%, #ee5a52 100%);
    }

    .counter-card-content {
        flex: 1;
    }

    .counter-card-content h4 {
        margin: 0 0 15px 0;
        color: #2c3e50;
        font-size: 18px;
        font-weight: 600;
    }

    .counter-amount-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 8px 0;
        border-bottom: 1px solid #f1f3f4;
    }

    .counter-amount-row:last-child {
        border-bottom: none;
    }

    .counter-amount-row .counter-label {
        color: #6c757d;
        font-size: 14px;
    }

    .counter-amount-row .counter-value {
        font-weight: 600;
        font-size: 16px;
    }

    .counter-opening {
        color: #6c757d;
    }

    .counter-closing {
        color: #28a745;
    }

    .counter-revenue {
        color: #ff6b6b;
    }

    .counter-total-row {
        padding-top: 12px;
        margin-top: 8px;
        border-top: 2px dashed #dee2e6;
    }

    .counter-stats-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 15px;
    }

    .counter-stat-item {
        background: #f8f9fa;
        padding: 12px;
        border-radius: 10px;
        text-align: center;
    }

    .counter-stat-label {
        font-size: 12px;
        color: #6c757d;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 5px;
    }

    .counter-stat-value {
        font-size: 18px;
        font-weight: 700;
        color: #2c3e50;
    }

    /* Orders Section - Table Format */
    .counter-orders-section {
        padding: 25px;
    }

    .counter-section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
        padding-bottom: 15px;
        border-bottom: 2px solid #e9ecef;
    }

    .counter-section-header h3 {
        margin: 0;
        color: #2c3e50;
        font-size: 22px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .counter-section-header h3 i {
        color: #667eea;
    }

    .counter-section-badge .counter-badge {
        padding: 8px 16px;
        font-size: 14px;
        font-weight: 600;
        border-radius: 10px;
    }

    /* Table Container */
    .counter-table-container {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        overflow-x: auto;
    }

    /* Table Styles */
    .counter-orders-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 14px;
    }

    .counter-orders-table thead {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .counter-orders-table th {
        padding: 15px 12px;
        text-align: left;
        font-weight: 600;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        white-space: nowrap;
    }

    .counter-orders-table tbody tr {
        border-bottom: 1px solid #f1f3f4;
        transition: all 0.3s ease;
    }

    .counter-orders-table tbody tr:hover {
        background-color: #f8f9fa;
        transform: scale(1.002);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .counter-table-cell {
        padding: 12px;
        color: #495057;
        vertical-align: top;
    }

    /* Table Cell Specific Styles */
    .counter-order-id-cell {
        font-weight: 600;
        color: #3490dc;
        min-width: 70px;
    }

    .counter-time-cell {
        color: #6c757d;
        font-size: 13px;
        min-width: 80px;
    }

    .counter-type-cell {
        min-width: 80px;
    }

    .counter-customer-cell {
        min-width: 180px;
    }

    .counter-items-cell {
        min-width: 200px;
        max-width: 250px;
    }

    .counter-qty-cell,
    .counter-amount-cell,
    .counter-discount-cell,
    .counter-vat-cell,
    .counter-total-cell {
        text-align: right;
        min-width: 90px;
    }

    .counter-payment-cell {
        min-width: 120px;
    }

    /* Badge Styles */
    .counter-order-type-badge {
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        display: inline-block;
    }

    .counter-badge-dinein {
        background: #17a2b8;
        color: white;
    }

    .counter-badge-office {
        background: #ffc107;
        color: #212529;
    }

    .counter-payment-method-badge {
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .counter-badge-cash {
        background: #28a745;
        color: white;
    }

    .counter-badge-card {
        background: #007bff;
        color: white;
    }

    /* Customer Info */
    .counter-customer-info {
        display: flex;
        flex-direction: column;
        gap: 3px;
    }

    .counter-customer-name {
        font-weight: 500;
        color: #2c3e50;
    }

    .counter-customer-contact {
        font-size: 12px;
        color: #6c757d;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    /* Items List */
    .counter-items-list {
        font-size: 13px;
        line-height: 1.4;
        max-height: 80px;
        overflow-y: auto;
        padding-right: 5px;
    }

    .counter-items-list::-webkit-scrollbar {
        width: 4px;
    }

    .counter-items-list::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    .counter-items-list::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 2px;
    }

    /* Amount Cells */
    .counter-total-qty {
        background: #f8f9fa;
        padding: 4px 8px;
        border-radius: 4px;
        font-weight: 600;
        color: #495057;
    }

    .counter-grand-total {
        color: #28a745;
        font-weight: 700;
    }

    .counter-discount-cell {
        color: #dc3545;
    }

    .counter-vat-cell {
        color: #6c757d;
    }

    /* Payment Info */
    .counter-payment-info {
        display: flex;
        flex-direction: column;
        gap: 5px;
    }

    .counter-payment-amount {
        font-size: 13px;
        font-weight: 600;
        color: #28a745;
    }

    /* No Orders */
    .counter-no-orders {
        text-align: center;
        padding: 50px 20px;
    }

    .counter-no-orders-icon {
        font-size: 64px;
        color: #dee2e6;
        margin-bottom: 20px;
    }

    .counter-no-orders h4 {
        margin: 10px 0;
        color: #6c757d;
        font-weight: 600;
        font-size: 20px;
    }

    .counter-no-orders p {
        color: #adb5bd;
        font-size: 16px;
    }

    /* Toast Notification - Unique Classes */
    .counter-toast-notification {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 10000;
        background: white;
        border-radius: 10px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2);
        padding: 15px 20px;
        display: flex;
        align-items: center;
        gap: 10px;
        transform: translateX(120%);
        transition: transform 0.3s ease;
    }

    .counter-toast-notification.show {
        transform: translateX(0);
    }

    .counter-toast-notification.success {
        border-left: 4px solid #28a745;
    }

    .counter-toast-notification.error {
        border-left: 4px solid #dc3545;
    }

    .counter-toast-icon {
        font-size: 20px;
    }

    .counter-toast-message {
        font-weight: 500;
    }

    /* Responsive Design */
    @media (max-width: 1024px) {
        .counter-modal-content {
            width: 95%;
        }

        .counter-orders-table {
            font-size: 13px;
        }

        .counter-orders-table th,
        .counter-orders-table td {
            padding: 10px 8px;
        }
    }

    @media (max-width: 768px) {
        .counter-close-modal {
            padding: 10px;
            left: 0;
        }

        .counter-modal-header {
            padding: 20px;
        }

        .counter-header-icon {
            position: relative;
            left: 0;
            top: 0;
            transform: none;
            margin-bottom: 15px;
        }

        .counter-header-text {
            padding: 0;
        }

        .counter-summary-grid {
            grid-template-columns: 1fr;
        }

        .counter-section-header {
            flex-direction: column;
            gap: 10px;
            text-align: center;
        }

        .counter-table-container {
            border-radius: 8px;
        }

        .counter-orders-table {
            min-width: 1000px;
        }
    }

    /* Scrollbar Styling */
    .counter-modal-body::-webkit-scrollbar {
        width: 8px;
    }

    .counter-modal-body::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .counter-modal-body::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 10px;
    }

    .counter-modal-body::-webkit-scrollbar-thumb:hover {
        background: #a8a8a8;
    }
</style>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Get elements
        const counterBtn = document.getElementById("counterBtn");
        const btnIcon = counterBtn.querySelector(".counter-btn-icon");
        const btnText = counterBtn.querySelector(".counter-btn-text");
        const modal = document.getElementById("closeCounterModal");
        const modalData = document.getElementById("modalData");
        const modalCloseBtn = document.getElementById("modalCloseBtn");
        const summaryDate = document.getElementById("summaryDate");
        const printBtn = document.getElementById("printModalBtn");

        // Check initial counter state
        checkCounterState();

        // Function to check counter state
        async function checkCounterState() {
            try {
                const response = await fetch("{{ route('getTodayCounter') }}");
                const data = await response.json();

                if (data.state === 'close') {
                    btnIcon.className = "fa-solid fa-toggle-off counter-btn-icon";
                    btnText.textContent = "Close Counter";
                    counterBtn.dataset.state = "close";
                } else {
                    btnIcon.className = "fa-solid fa-toggle-on counter-btn-icon";
                    btnText.textContent = "Open Counter";
                    counterBtn.dataset.state = "open";
                }
            } catch (error) {
                console.error('Error checking counter state:', error);
            }
        }

        // Function to store counter state
        async function storeCounter(type) {
            try {
                const url = type === "open" ?
                    "{{ route('openCounter') }}" :
                    "{{ route('closeCounter') }}";

                const res = await fetch(url, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    }
                });

                return await res.json();
            } catch (err) {
                console.error('Error in storeCounter:', err);
                return null;
            }
        }

        // Function to show toast notification
        function showToast(message, type = 'success') {
            const toastId = 'counter-toast-' + Date.now();
            const toastHtml = `
                <div id="${toastId}" class="counter-toast-notification ${type}">
                    <i class="counter-toast-icon fas fa-${type === 'success' ? 'check-circle' : 'exclamation-triangle'}"></i>
                    <span class="counter-toast-message">${message}</span>
                </div>
            `;

            document.body.insertAdjacentHTML('beforeend', toastHtml);
            const toast = document.getElementById(toastId);

            setTimeout(() => {
                toast.classList.add('show');
            }, 10);

            setTimeout(() => {
                toast.classList.remove('show');
                setTimeout(() => {
                    toast.remove();
                }, 300);
            }, 3000);
        }

        // Counter button click handler
        counterBtn.addEventListener("click", async function(e) {
            e.preventDefault();
            const state = counterBtn.dataset.state;
            const action = state === 'open' ? 'open' : 'close';

            if (!confirm(`Are you sure you want to ${action} the counter?`)) {
                return;
            }

            const data = await storeCounter(action);

            if (!data) {
                showToast('Server error! Please try again.', 'error');
                return;
            }

            if (!data.success) {
                showToast(data.message || 'Failed to ' + action + ' counter!', 'error');
                return;
            }

            showToast('Counter ' + action + 'ed successfully!', 'success');

            if (action === "open") {
                // Change button to Close
                btnIcon.className = "fa-solid fa-toggle-off counter-btn-icon";
                btnText.textContent = "Close Counter";
                counterBtn.dataset.state = "close";
            } else {
                // Change button to Open
                btnIcon.className = "fa-solid fa-toggle-on counter-btn-icon";
                btnText.textContent = "Open Counter";
                counterBtn.dataset.state = "open";

                // Show modal with detailed summary
                displayCounterSummary(data);
            }
        });

        // Function to display counter summary in modal
        function displayCounterSummary(data) {
            const summary = data.summary || {};
            const orders = data.orders || [];

            // Set date
            summaryDate.textContent = summary.date || new Date().toLocaleDateString('en-US', {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });

            let html = `
                <!-- Summary Section -->
                <div class="counter-summary-section">
                    <div class="counter-summary-grid">
                        <!-- Cash Summary -->
                        <div class="counter-summary-card counter-cash-card">
                            <div class="counter-card-icon">
                                <i class="fas fa-money-bill-wave"></i>
                            </div>
                            <div class="counter-card-content">
                                <h4>Cash Summary</h4>
                                <div class="counter-amount-row">
                                    <span class="counter-label">Opening Balance:</span>
                                    <span class="counter-value counter-opening">Rs. ${parseFloat(summary.cash_opening || 0).toFixed(2)}</span>
                                </div>
                                <div class="counter-amount-row">
                                    <span class="counter-label">Today's Cash:</span>
                                    <span class="counter-value">Rs. ${parseFloat(summary.cash_revenue || 0).toFixed(2)}</span>
                                </div>
                                <div class="counter-amount-row counter-total-row">
                                    <span class="counter-label">Closing Balance:</span>
                                    <span class="counter-value counter-closing">Rs. ${parseFloat(summary.cash_closing || 0).toFixed(2)}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Bank Summary -->
                        <div class="counter-summary-card counter-bank-card">
                            <div class="counter-card-icon">
                                <i class="fas fa-university"></i>
                            </div>
                            <div class="counter-card-content">
                                <h4>Bank Summary</h4>
                                <div class="counter-amount-row">
                                    <span class="counter-label">Opening Balance:</span>
                                    <span class="counter-value counter-opening">Rs. ${parseFloat(summary.bank_opening || 0).toFixed(2)}</span>
                                </div>
                                <div class="counter-amount-row">
                                    <span class="counter-label">Today's Bank:</span>
                                    <span class="counter-value">Rs. ${parseFloat(summary.bank_revenue || 0).toFixed(2)}</span>
                                </div>
                                <div class="counter-amount-row counter-total-row">
                                    <span class="counter-label">Closing Balance:</span>
                                    <span class="counter-value counter-closing">Rs. ${parseFloat(summary.bank_closing || 0).toFixed(2)}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Overall Summary -->
                        <div class="counter-summary-card counter-overall-card">
                            <div class="counter-card-icon">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            <div class="counter-card-content">
                                <h4>Overall Summary</h4>
                                <div class="counter-stats-grid">
                                    <div class="counter-stat-item">
                                        <div class="counter-stat-label">Total Revenue</div>
                                        <div class="counter-stat-value">Rs. ${parseFloat(summary.total_revenue || 0).toFixed(2)}</div>
                                    </div>
                                    <div class="counter-stat-item">
                                        <div class="counter-stat-label">Total Orders</div>
                                        <div class="counter-stat-value">${summary.total_orders || 0}</div>
                                    </div>
                                    <div class="counter-stat-item">
                                        <div class="counter-stat-label">Total Items</div>
                                        <div class="counter-stat-value">${summary.total_items || 0}</div>
                                    </div>
                                    <div class="counter-stat-item">
                                        <div class="counter-stat-label">Day</div>
                                        <div class="counter-stat-value">${summary.day || 'Today'}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>`;

            // Orders Table Section
            if (orders.length > 0) {
                html += `
                <div class="counter-orders-section">
                    <div class="counter-section-header">
                        <h3><i class="fas fa-receipt"></i> Today's Orders (${orders.length})</h3>
                        <div class="counter-section-badge">
                            <span class="counter-badge bg-primary">Total Revenue: Rs. ${parseFloat(summary.total_revenue || 0).toFixed(2)}</span>
                        </div>
                    </div>
                    
                    <div class="counter-table-container">
                        <table class="counter-orders-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Time</th>
                                    <th>Type</th>
                                    <th>Customer/Office</th>
                                  
                                    <th>Items</th>
                                    <th>Total Qty</th>
                                    <th>Subtotal</th>
                                    <th>Grand Total</th>
                                    <th>Payment</th>
                                </tr>
                            </thead>
                            <tbody>`;

                orders.forEach((order, index) => {
                    const customer = order.customer_info || {};
                    const customerName = customer.name || 'Guest Customer';
                    const customerContact = customer.contact || '';

                    // Format items for display
                    const itemsList = order.items.map(item => {
                        return `${item.menu_name}${item.variant_name ? ` (${item.variant_name})` : ''} x${item.qty}`;
                    }).join('<br>');

                    html += `
                    <tr class="counter-table-row">
                        <td class="counter-table-cell counter-order-id-cell">
                            <strong>#${order.id}</strong>
                        </td>
                        <td class="counter-table-cell counter-time-cell">
                            ${order.created_at}
                        </td>
                        <td class="counter-table-cell counter-type-cell">
                            <span class="counter-order-type-badge ${order.order_type === 'dinein' ? 'counter-badge-dinein' : 'counter-badge-office'}">
                                ${order.order_type === 'dinein' ? 'Dine-in' : 'Office'}
                            </span>
                        </td>
                        <td class="counter-table-cell counter-customer-cell">
                            <div class="counter-customer-info">
                                <div class="counter-customer-name">${customerName}</div>
                                ${customerContact ? `<div class="counter-customer-contact"><i class="fas fa-phone"></i> ${customerContact}</div>` : ''}
                            </div>
                        </td>
                      
                        <td class="counter-table-cell counter-items-cell">
                            <div class="counter-items-list">
                                ${itemsList}
                            </div>
                        </td>
                        <td class="counter-table-cell counter-qty-cell">
                            <span class="counter-total-qty">${order.total_qty}</span>
                        </td>
                        <td class="counter-table-cell counter-amount-cell">
                            Rs. ${parseFloat(order.sub_total || 0).toFixed(2)}
                        </td>
                      
                        <td class="counter-table-cell counter-total-cell">
                            <strong class="counter-grand-total">Rs. ${parseFloat(order.grand_total || 0).toFixed(2)}</strong>
                        </td>
                        <td class="counter-table-cell counter-payment-cell">
                            <div class="counter-payment-info">
                                <span class="counter-payment-method-badge ${order.payment_method === 'cash' ? 'counter-badge-cash' : 'counter-badge-card'}">
                                    <i class="fas fa-${order.payment_method === 'cash' ? 'money-bill-wave' : 'credit-card'}"></i>
                                    ${order.payment_method}
                                </span>
                                <div class="counter-payment-amount">
                                    Rs. ${parseFloat(order.payment_amount || 0).toFixed(2)}
                                </div>
                            </div>
                        </td>
                    </tr>`;
                });

                html += `</tbody>
                        </table>
                    </div>
                </div>`;
            } else {
                html += `
                <div class="counter-no-orders">
                    <div class="counter-no-orders-icon">
                        <i class="fas fa-clipboard-list"></i>
                    </div>
                    <h4>No Orders Today</h4>
                    <p>There were no orders processed for today.</p>
                </div>`;
            }

            modalData.innerHTML = html;
            modal.style.display = "flex";
        }

        // Close modal button
        modalCloseBtn.addEventListener("click", () => {
            modal.style.display = "none";
        });

        // Close modal when clicking outside
        modal.addEventListener("click", (e) => {
            if (e.target === modal) {
                modal.style.display = "none";
            }
        });

        // Print modal content
        printBtn.addEventListener("click", function() {
            const modalContent = document.querySelector("#closeCounterModal .counter-modal-content")
                .innerHTML;

            const printWindow = window.open('', '_blank');
            printWindow.document.write(`
                <!DOCTYPE html>
                <html>
                <head>
                    <title>Counter Summary - {{ $branch->name ?? ($profile->company_name ?? 'Restaurant') }}</title>
                    <style>
                        body {
                            font-family: Arial, sans-serif;
                            margin: 20px;
                            color: #333;
                        }
                        .print-header {
                            text-align: center;
                            margin-bottom: 30px;
                            padding-bottom: 20px;
                            border-bottom: 2px solid #ccc;
                        }
                        .print-header h1 {
                            margin: 0;
                            color: #2c3e50;
                        }
                        .print-header p {
                            margin: 5px 0;
                            color: #666;
                        }
                        .summary-cards {
                            display: grid;
                            grid-template-columns: repeat(3, 1fr);
                            gap: 20px;
                            margin-bottom: 30px;
                        }
                        .summary-card {
                            border: 1px solid #ddd;
                            padding: 15px;
                            border-radius: 8px;
                        }
                        .summary-card h3 {
                            margin-top: 0;
                            color: #2c3e50;
                            font-size: 16px;
                        }
                        .amount-row {
                            display: flex;
                            justify-content: space-between;
                            margin: 8px 0;
                        }
                        .orders-table {
                            width: 100%;
                            border-collapse: collapse;
                            margin: 20px 0;
                        }
                        .orders-table th {
                            background: #f8f9fa;
                            padding: 12px;
                            text-align: left;
                            border-bottom: 2px solid #dee2e6;
                            font-weight: 600;
                        }
                        .orders-table td {
                            padding: 12px;
                            border-bottom: 1px solid #dee2e6;
                        }
                        .orders-table tr:hover {
                            background: #f8f9fa;
                        }
                        .badge {
                            padding: 4px 8px;
                            border-radius: 4px;
                            font-size: 12px;
                            font-weight: 600;
                        }
                        .badge-dinein {
                            background: #17a2b8;
                            color: white;
                        }
                        .badge-office {
                            background: #ffc107;
                            color: #212529;
                        }
                        .badge-cash {
                            background: #28a745;
                            color: white;
                        }
                        .badge-card {
                            background: #007bff;
                            color: white;
                        }
                        @media print {
                            body { margin: 0; padding: 20px; }
                            .no-print { display: none; }
                            .summary-cards { page-break-inside: avoid; }
                            .orders-table { font-size: 12px; }
                            .orders-table th, .orders-table td { padding: 8px; }
                        }
                    </style>
                </head>
                <body>
                    <div class="print-header">
                        <h1>{{ $branch->name ?? ($profile->company_name ?? 'Restaurant') }}</h1>
                        <p>Daily Counter Summary</p>
                        <p id="printDate"></p>
                    </div>
                    ${modalContent}
                    <script>
                        document.getElementById('printDate').textContent = new Date().toLocaleDateString('en-US', { 
                            weekday: 'long', 
                            year: 'numeric', 
                            month: 'long', 
                            day: 'numeric' 
                        });
                        window.print();
                    <\/script>
                </body>
                </html>
            `);


            printWindow.document.close();
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && modal.style.display === 'flex') {
                modal.style.display = 'none';
            }
        });
    });
</script>
{{-- @endcan --}}

@can('access_counter_management')
    {{-- Reception Orders sent from kitchen --}}
    <div class="modal fade" id="kitchenModal" tabindex="-1" aria-labelledby="kitchenModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title" id="kitchenModalLabel">New Orders Alert!</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered" id="ordersTable">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Order Type</th>
                                <th>Table / Office / Location</th>
                                <th>Customer Name</th>
                                <th>Customer Phone</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Orders populated via JS -->
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <audio id="kitchenAlertSound">
        <source src="{{ asset('sounds/order_completed_audio.mp3') }}" preload="auto" type="audio/mpeg">
    </audio>
    <script>
        // Wait for DOM to be fully loaded
        document.addEventListener('DOMContentLoaded', function() {
            // Get modal element
            var kitchenModalEl = document.getElementById('kitchenModal');
            
            // Check if Bootstrap modal is available
            if (typeof bootstrap === 'undefined' || !bootstrap.Modal) {
                console.error('Bootstrap JavaScript not loaded properly');
                return;
            }
            
            // Initialize modal with proper options
            var kitchenModal = new bootstrap.Modal(kitchenModalEl, {
                backdrop: true,
                keyboard: true,
                focus: true
            });
            
            var modalShown = false;
            var alertSound = document.getElementById('kitchenAlertSound');

            // Manual close function
            function closeModalManually() {
                kitchenModal.hide();
                modalShown = false;
            }

            // Add manual close event listener to Close button
            document.addEventListener('click', function(e) {
                if (e.target && e.target.classList.contains('btn-secondary') && 
                    e.target.closest('#kitchenModal') && 
                    e.target.getAttribute('data-bs-dismiss') === 'modal') {
                    closeModalManually();
                }
            });

            function checkOrders() {
                fetch('{{ route('check.kitchen') }}')
                    .then(res => {
                        if (!res.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return res.json();
                    })
                    .then(data => {
                        if (data.showModal && !modalShown) {
                            var tbody = document.querySelector('#ordersTable tbody');
                            tbody.innerHTML = '';

                            data.orders.forEach(order => {
                                let row = `<tr>
                                    <td>${order.id}</td>
                                    <td>${order.order_type}</td>
                                    <td>${order.location}</td>
                                    <td>${order.customer_name}</td>
                                    <td>${order.customer_phone}</td>
                                    <td>
                                        <button class="btn btn-success btn-sm serve-btn" data-id="${order.id}">OK</button>
                                    </td>
                                </tr>`;
                                tbody.innerHTML += row;
                            });

                            // Play alert sound
                            alertSound.play().catch(err => console.log('Audio play error:', err));

                            // Show modal
                            kitchenModal.show();
                            modalShown = true;

                            // Add click event to OK buttons
                            document.querySelectorAll('.serve-btn').forEach(btn => {
                                btn.addEventListener('click', function() {
                                    let orderId = this.dataset.id;
                                    fetch(`/orders/serve/${orderId}`, {
                                            method: 'POST',
                                            headers: {
                                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                                'Content-Type': 'application/json',
                                                'Accept': 'application/json'
                                            }
                                        })
                                        .then(res => {
                                            if (!res.ok) {
                                                throw new Error('Network response was not ok');
                                            }
                                            return res.json();
                                        })
                                        .then(resp => {
                                            checkOrders(); // refresh modal
                                        })
                                        .catch(error => {
                                            console.error('Error serving order:', error);
                                            // Show error using toastr if available
                                            if (typeof toastr !== 'undefined') {
                                                toastr.error('Failed to mark order as served. Please try again.');
                                            } else {
                                                alert('Failed to mark order as served. Please try again.');
                                            }
                                        });
                                });
                            });

                        } else if (!data.showModal && modalShown) {
                            // Hide modal if no orders
                            closeModalManually();
                        }
                    })
                    .catch(err => {
                        console.error('Error checking orders:', err);
                    });
            }

            // Initial check
            checkOrders();
            
            // Set up interval for checking orders
            setInterval(checkOrders, 10000);

            // Reset modalShown flag when modal is hidden
            kitchenModalEl.addEventListener('hidden.bs.modal', function() {
                modalShown = false;
            });

            // Debug: Log modal events
            kitchenModalEl.addEventListener('hide.bs.modal', function() {
                console.log('Modal hide event triggered');
            });
            
            kitchenModalEl.addEventListener('show.bs.modal', function() {
                console.log('Modal show event triggered');
            });
        });
    </script>
@endcan
