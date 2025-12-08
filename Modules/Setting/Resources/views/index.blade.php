@extends('setting::layouts.master')
@section('title', 'Restaurant Dashboard')
@section('content')
    @can('access_counter_management')
        <div class="content-wrapper">
            <!-- Content Header -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Restaurant Dashboard</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Dashboard</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <section class="content">
                <div class="container-fluid">
                    <!-- Statistics Cards -->
                    <div class="row">
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-gradient-primary">
                                <div class="inner">
                                    <h3>{{ $todaysOrders }}</h3>
                                    <p>Today's Orders</p>
                                </div>
                                <div class="icon"><i class="fas fa-utensils"></i></div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-gradient-success">
                                <div class="inner">
                                    <h3>{{ $kitchenOrdersCount }}</h3>
                                    <p>Kitchen Orders</p>
                                </div>
                                <div class="icon"><i class="fas fa-utensil-spoon"></i></div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-gradient-warning">
                                <div class="inner">
                                    <h3>{{ $servingOrdersCount }}</h3>
                                    <p>Serving Orders</p>
                                </div>
                                <div class="icon"><i class="fas fa-concierge-bell"></i></div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-gradient-danger">
                                <div class="inner">
                                    <h3>{{ $completedOrdersCount }}</h3>
                                    <p>Completed Orders</p>
                                </div>
                                <div class="icon"><i class="fas fa-check-circle"></i></div>
                            </div>
                        </div>
                    </div>

                    <!-- Main Dashboard Content -->
                    <div class="row">
                        <!-- Left Column -->
                        <section class="col-lg-7 connectedSortable">
                            <!-- Recent Orders Card -->
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        <a href="{{ route('receptionorders') }}"
                                            class="nav-link {{ request()->routeIs('receptionorders') ? 'active' : '' }}">
                                            <i class="fas fa-list-alt mr-1"></i> Recent Accepted Orders
                                        </a>
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead class="bg-light">
                                                <tr>
                                                    <th>Order ID</th>
                                                    <th>Customer</th>
                                                    <th>Items</th>
                                                    <th>Total Amount</th>
                                                    <th>Order Time</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($recentOrders as $order)
                                                    <tr>
                                                        <td>#{{ $order->id }}</td>
                                                        <td>{{ $order->customer->name ?? 'Office Order' }}</td>
                                                        <td>{{ $order->items->count() }} items</td>
                                                        <td>Rs. {{ number_format($order->grand_total ?? 0, 2) }}</td>
                                                        <td>{{ $order->created_at->format('h:i A') }}</td>
                                                        <td>
                                                            <form action="{{ route('orders.moveToKitchen', $order->id) }}"
                                                                method="POST" class="d-inline">
                                                                @csrf
                                                                <button type="submit" class="btn btn-primary btn-sm">
                                                                    <i class="fa fa-paper-plane me-1"></i>
                                                                    Send to Kitchen
                                                                </button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="6" class="text-center text-muted">No recent orders yet
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!-- Served Orders Table -->
                            <div class="card card-danger">
                                <div class="card-header">
                                    <h3 class="card-title"><i class="fas fa-concierge-bell mr-1"></i> Served Orders</h3>
                                </div>
                                <div class="card-body table-responsive">
                                    <table class="table table-sm table-hover">
                                        <thead class="bg-light">
                                            <tr>
                                                <th>Order ID</th>
                                                <th>Customer</th>
                                                <th>Items</th>
                                                <th>Served Time</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($servedOrders as $order)
                                                <tr>
                                                    <td>#ORD-{{ $order->id }}</td>
                                                    <td>{{ $order->customer->name ?? 'Guest' }}</td>
                                                    <td>
                                                        <small>
                                                            @foreach ($order->items as $item)
                                                                {{ $item->qty }}x {{ $item->menu->name }}@if (!$loop->last)
                                                                    ,
                                                                @endif
                                                            @endforeach
                                                        </small>
                                                    </td>
                                                    <td>{{ $order->updated_at->format('h:i A') }}</td>
                                                    <td><span class="badge badge-success">{{ ucfirst($order->status) }}</span>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center text-muted">No served orders yet
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Top Selling Items -->
                            <div class="card card-success">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        <i class="fas fa-chart-bar mr-1"></i>
                                        Popular Menu Items
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <div class="chart">
                                        <canvas id="popularItemsChart"
                                            style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                                    </div>
                                </div>
                            </div>

                            <!-- Quick Actions -->
                            <div class="card card-info">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        <i class="fas fa-bolt mr-1"></i>
                                        Quick Actions
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <div class="row text-center">
                                        <div class="col-4">
                                            <button class="btn btn-outline-primary btn-block">
                                                <i class="fas fa-plus"></i><br>
                                                <a href="{{ route('neworders') }}"
                                                    class="nav-link {{ request()->routeIs('neworders') ? 'active' : '' }}">
                                                    New Order
                                                </a>
                                            </button>
                                        </div>
                                        <div class="col-4">
                                            <button class="btn btn-outline-success btn-block">
                                                <i class="fas fa-cog"></i><br>
                                                <a href="{{ route('menus.index') }}" class="nav-link pl-2">
                                                    Menus
                                                </a>
                                            </button>
                                        </div>
                                        <div class="col-4">
                                            <button class="btn btn-outline-warning btn-block">
                                                <i class="fas fa-users"></i><br>
                                                <a href="{{ route('users.index') }}"
                                                    class="nav-link {{ request()->routeIs('users.index') ? 'active' : '' }}">
                                                    Staff
                                                </a>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <!-- Right Column -->
                        <section class="col-lg-5 connectedSortable">
                            <!-- Kitchen Orders -->
                            <div class="card card-warning">
                                <div class="card-header">
                                    <h3 class="card-title"><a href="{{ route('kitchenorders') }}"
                                            class="nav-link {{ request()->routeIs('kitchenorders') ? 'active' : '' }}">
                                            <i class="fas fa-fire mr-1"></i> Kitchen Queue
                                        </a></h3>
                                </div>
                                <div class="card-body">
                                    @forelse ($kitchenOrders as $order)
                                        <div
                                            class="order-item alert alert-warning d-flex justify-content-between align-items-center">
                                            <div>
                                                <strong>#ORD-{{ $order->id }}</strong><br>
                                                <small>
                                                    @foreach ($order->items as $item)
                                                        {{ $item->qty }}x {{ $item->menu->name }}@if (!$loop->last)
                                                            ,
                                                        @endif
                                                    @endforeach
                                                </small>
                                            </div>
                                            <div class="text-right">
                                                <span
                                                    class="badge badge-info">{{ $order->created_at->diffForHumans() }}</span>
                                                <br>
                                                <button class="btn btn-xs btn-success mt-1 serve-kitchen-btn"
                                                    data-order="{{ $order->id }}">
                                                    <i class="fas fa-check"></i> Mark Ready
                                                </button>
                                            </div>
                                        </div>
                                    @empty
                                        <p class="text-center text-muted">No active kitchen orders</p>
                                    @endforelse
                                </div>
                            </div>

                            <!-- Completed Orders Table -->
                            <div class="card card-danger">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        <a href="{{ route('completedorders') }}"
                                            class="nav-link {{ request()->routeIs('completedorders') ? 'active' : '' }}">
                                            <i class="fas fa-check-circle mr-1"></i> Completed Orders
                                        </a>
                                    </h3>
                                </div>
                                <div class="card-body table-responsive">
                                    <table class="table table-sm table-hover">
                                        <thead class="bg-light">
                                            <tr>
                                                <th>Order ID</th>
                                                <th>Customer</th>
                                                <th>Items</th>
                                                <th>Served Time</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($completedOrders as $order)
                                                <tr>
                                                    <td>#ORD-{{ $order->id }}</td>
                                                    <td>{{ $order->customer->name ?? 'Guest' }}</td>
                                                    <td>
                                                        <small>
                                                            @foreach ($order->items as $item)
                                                                {{ $item->qty }}x {{ $item->menu->name }}@if (!$loop->last)
                                                                    ,
                                                                @endif
                                                            @endforeach
                                                        </small>
                                                    </td>
                                                    <td>{{ $order->updated_at->format('h:i A') }}</td>
                                                    <td><span class="badge badge-success">{{ ucfirst($order->status) }}</span>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center text-muted">No completed orders yet
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                    </div>
                </div>
        </div>

        </section>
        </div>
        </div>
        </section>
        </div>

        <style>
            .small-box {
                border-radius: 10px;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                transition: transform 0.3s ease;
            }

            .small-box:hover {
                transform: translateY(-5px);
            }

            .card {
                border-radius: 10px;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            }

            .order-item {
                border-radius: 8px;
                margin-bottom: 10px;
                border: none;
            }

            .bg-gradient-primary {
                background: linear-gradient(45deg, #007bff, #6610f2);
            }

            .bg-gradient-success {
                background: linear-gradient(45deg, #28a745, #20c997);
            }

            .bg-gradient-warning {
                background: linear-gradient(45deg, #ffc107, #fd7e14);
            }

            .bg-gradient-danger {
                background: linear-gradient(45deg, #dc3545, #e83e8c);
            }

            .icon i {
                opacity: 0.8;
                font-size: 70px;
            }

            .btn-sm {
                padding: 0.25rem 0.5rem;
                font-size: 0.875rem;
            }

            .table-sm td,
            .table-sm th {
                padding: 0.5rem;
            }

            .served-orders-table {
                max-height: 300px;
                overflow-y: auto;
            }

            .view-all-served-btn {
                font-size: 0.8rem;
                padding: 0.2rem 0.8rem;
            }
        </style>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Popular Items Chart
                const popularCtx = document.getElementById('popularItemsChart').getContext('2d');

                // Pass PHP variables to JS
                const popularLabels = @json($popularLabels);
                const popularData = @json($popularData);

                const popularChart = new Chart(popularCtx, {
                    type: 'bar',
                    data: {
                        labels: popularLabels,
                        datasets: [{
                            label: 'Items Sold',
                            data: popularData,
                            backgroundColor: popularLabels.map(() => '#' + Math.floor(Math.random() *
                                16777215).toString(16)) // random colors
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });

                // Notification function (unchanged)
                function showNotification(type, message) {
                    const notification = document.createElement('div');
                    notification.className = `alert alert-${type} alert-dismissible fade show`;
                    notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
             min-width: 300px;
                     `;
                    notification.innerHTML = `
            ${message}
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
                    `;
                    document.body.appendChild(notification);
                    setTimeout(() => {
                        if (notification.parentNode) {
                            notification.parentNode.removeChild(notification);
                        }
                    }, 3000);
                }
            });
        </script>
    @endcan

    @can('access_kitchen_management')
        <div class="content-wrapper">
            <!-- Content Header -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0 text-dark"><i class="fas fa-utensils mr-2"></i>Kitchen Dashboard</h1>
                            <small class="text-muted">Manage all kitchen orders in real-time</small>
                        </div>
                        <div class="col-sm-6">
                            <div class="float-sm-right">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-info btn-sm" onclick="window.location.reload()">
                                        <i class="fas fa-sync-alt mr-1"></i> Refresh Orders
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <section class="content">
                <div class="container-fluid">
                    <!-- Kitchen Statistics Cards -->
                    <div class="row mb-4">
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-gradient-info">
                                <div class="inner">
                                    <h3>{{ $todaysOrders }}</h3>
                                    <p>Today's Total Orders</p>
                                </div>
                                <div class="icon"><i class="fas fa-clipboard-list"></i></div>
                                <a href="#" class="small-box-footer">View All <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>

                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-gradient-danger">
                                <div class="inner">
                                    <h3>{{ $kitchenOrdersCount }}</h3>
                                    <p>Pending Kitchen Orders</p>
                                </div>
                                <div class="icon"><i class="fas fa-fire"></i></div>
                                <a href="#kitchen-orders-table" class="small-box-footer">View Orders <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>

                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-gradient-warning">
                                <div class="inner">
                                    <h3>{{ $servingOrdersCount }}</h3>
                                    <p>Ready to Serve</p>
                                </div>
                                <div class="icon"><i class="fas fa-concierge-bell"></i></div>
                                <a href="#" class="small-box-footer">Check Status <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>

                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-gradient-success">
                                <div class="inner">
                                    <h3>{{ $completedOrdersCount }}</h3>
                                    <p>Completed Today</p>
                                </div>
                                <div class="icon"><i class="fas fa-check-circle"></i></div>
                                <a href="#" class="small-box-footer">View History <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                    </div>

                    <!-- Kitchen Orders Table -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card shadow-sm" id="kitchen-orders-table">
                                <div class="card-header bg-gradient-primary">
                                    <h3 class="card-title text-white">
                                        <i class="fas fa-utensil-spoon mr-2"></i>Kitchen Orders Queue
                                        <span class="badge badge-light ml-2">{{ $kitchenOrdersCount }} Pending</span>
                                    </h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-minus text-white"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body table-responsive p-0">
                                    <table class="table table-hover table-striped">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th width="5%">#ID</th>
                                                <th width="20%">Customer/Office</th>
                                                <th width="10%">Type</th>
                                                <th width="20%">Order Items</th>
                                                <th width="15%">Order Time</th>
                                                <th width="10%">Status</th>
                                                <th width="10%">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($kitchenOrdersdash as $order)
                                                <tr class="align-middle">
                                                    <td>
                                                        <strong>#{{ $order->id }}</strong>
                                                        <br>
                                                        <small class="text-muted">Table:
                                                            {{ $order->table_id ?? 'N/A' }}</small>
                                                    </td>
                                                    <td>
                                                        @if ($order->customer)
                                                            <div class="d-flex align-items-center">
                                                                <div class="mr-2">
                                                                    <i class="fas fa-user text-primary"></i>
                                                                </div>
                                                                <div>
                                                                    <strong>{{ $order->customer->name ?? 'N/A' }}</strong>
                                                                    <br>
                                                                    <small
                                                                        class="text-muted">{{ $order->customer->phone ?? '' }}</small>
                                                                </div>
                                                            </div>
                                                        @elseif($order->office)
                                                            <div class="d-flex align-items-center">
                                                                <div class="mr-2">
                                                                    <i class="fas fa-building text-info"></i>
                                                                </div>
                                                                <div>
                                                                    <strong>{{ $order->office->name ?? 'N/A' }}</strong>
                                                                    <br>
                                                                    <small
                                                                        class="text-muted">{{ $order->office->contact_numbers ?? '' }}</small>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <span class="text-muted">Walk-in Customer</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($order->order_type == 'office')
                                                            <span class="badge badge-info">
                                                                <i class="fas fa-building mr-1"></i>{{ $order->order_type }}
                                                            </span>
                                                        @else
                                                            <span class="badge badge-primary">
                                                                <i class="fas fa-user mr-1"></i>{{ $order->order_type }}
                                                            </span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="order-items-list">
                                                            @foreach ($order->items as $item)
                                                                <div class="mb-1 p-2 bg-light rounded">
                                                                    <div class="d-flex justify-content-between">
                                                                        <strong>{{ $item->menu->name ?? 'N/A' }}</strong>
                                                                        <span
                                                                            class="badge badge-secondary">x{{ $item->qty }}</span>
                                                                    </div>

                                                                    {{-- This is the correct way to access the variation --}}
                                                                    @if ($item->variation)
                                                                        <div class="mt-1">
                                                                            <small class="text-muted">
                                                                                <i class="fas fa-list-ul mr-1"></i>
                                                                                Variation:
                                                                                <span
                                                                                    class="badge badge-primary">{{ $item->variation->name }}</span>
                                                                                <span class="badge badge-info ml-1">Rs.
                                                                                    {{ $item->variation->price }}</span>
                                                                            </small>
                                                                        </div>
                                                                    @endif

                                                                    @if ($item->note)
                                                                        <div class="mt-1">
                                                                            <small class="text-warning">
                                                                                <i class="fas fa-sticky-note mr-1"></i>
                                                                                {{ $item->note }}
                                                                            </small>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="text-center">
                                                            <div class="font-weight-bold">
                                                                {{ $order->created_at->format('h:i A') }}
                                                            </div>
                                                            <small class="text-muted">
                                                                {{ $order->created_at->format('M d, Y') }}
                                                            </small>
                                                            <br>
                                                            <small class="badge badge-info">
                                                                {{ $order->created_at->diffForHumans() }}
                                                            </small>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        @if ($order->status == 'sent to kitchen')
                                                            <span class="badge badge-warning">
                                                                <i class="fas fa-clock mr-1"></i> Waiting
                                                            </span>
                                                        @elseif($order->status == 'preparing')
                                                            <span class="badge badge-danger">
                                                                <i class="fas fa-fire mr-1"></i> Preparing
                                                            </span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="btn-group-vertical" role="group">
                                                            <form action="{{ route('kitchen.start.cooking', $order->id) }}"
                                                                method="POST" class="d-inline">
                                                                @csrf
                                                                <button type="submit" class="btn btn-sm btn-warning"
                                                                    style="min-width: 90px;"">
                                                                    <i class="fas fa-fire me-1"></i> Preparing
                                                                </button>
                                                            </form>

                                                            <form action="{{ route('kitchen.markServed', $order->id) }}"
                                                                method="POST" class="d-inline">
                                                                @csrf
                                                                <button type="submit" class="btn btn-sm btn-success"
                                                                    style="min-width: 90px;"
                                                                    onclick="return confirm('Mark this order as served?')">
                                                                    <i class="fas fa-check mr-1"></i> Mark Served
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="7" class="text-center py-5">
                                                        <div class="empty-state">
                                                            <i class="fas fa-utensils fa-3x text-muted mb-3"></i>
                                                            <h4 class="text-muted">No Kitchen Orders</h4>
                                                            <p class="text-muted">All orders are processed. Kitchen is clear!
                                                            </p>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                @if ($kitchenOrders->count() > 0)
                                    <div class="card-footer">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <small class="text-muted">
                                                    Showing {{ $kitchenOrders->count() }} pending orders
                                                </small>
                                            </div>
                                            <div class="col-md-6 text-right">
                                                <small class="text-muted">
                                                    Last updated: {{ now()->format('h:i:s A') }}
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <style>
            .content-wrapper {
                background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
                min-height: calc(100vh - 56px);
            }

            .content-header h1 {
                font-weight: 700;
                text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
            }

            .small-box {
                border-radius: 15px;
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
                transition: all 0.3s ease;
                border: none;
                overflow: hidden;
            }

            .small-box:hover {
                transform: translateY(-5px);
                box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            }

            .small-box .icon {
                position: absolute;
                top: -10px;
                right: 10px;
                z-index: 0;
                font-size: 70px;
                color: rgba(255, 255, 255, 0.3);
                transition: all 0.3s ease;
            }

            .small-box:hover .icon {
                transform: scale(1.1);
            }

            .card {
                border-radius: 15px;
                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
                border: none;
                overflow: hidden;
            }

            .card-header {
                border-top-left-radius: 15px !important;
                border-top-right-radius: 15px !important;
                border-bottom: none;
            }

            .table thead th {
                border-top: none;
                font-weight: 600;
                text-transform: uppercase;
                font-size: 0.85rem;
                letter-spacing: 0.5px;
                background: #343a40;
                color: white;
                vertical-align: middle;
                padding: 1rem;
            }

            .table tbody tr {
                transition: all 0.2s ease;
                border-bottom: 1px solid #f0f0f0;
            }

            .table tbody tr:hover {
                background-color: #f8f9fa;
                transform: scale(1.002);
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            }

            .order-items-list {
                max-height: 200px;
                overflow-y: auto;
                padding-right: 5px;
            }

            .order-items-list::-webkit-scrollbar {
                width: 5px;
            }

            .order-items-list::-webkit-scrollbar-track {
                background: #f1f1f1;
                border-radius: 10px;
            }

            .order-items-list::-webkit-scrollbar-thumb {
                background: #c1c1c1;
                border-radius: 10px;
            }

            .empty-state {
                padding: 40px 20px;
                text-align: center;
                background: #f8f9fa;
                border-radius: 10px;
            }

            .badge {
                font-weight: 500;
                padding: 0.35em 0.65em;
            }

            .bg-gradient-info {
                background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);
            }

            .bg-gradient-danger {
                background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            }

            .bg-gradient-warning {
                background: linear-gradient(135deg, #ffc107 0%, #e0a800 100%);
            }

            .bg-gradient-success {
                background: linear-gradient(135deg, #28a745 0%, #218838 100%);
            }

            .bg-gradient-primary {
                background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            }

            .start-cooking-btn {
                transition: all 0.3s ease;
            }

            .start-cooking-btn:hover {
                background-color: #e0a800;
                border-color: #d39e00;
                transform: scale(1.05);
            }

            .btn-group-vertical .btn {
                border-radius: 8px !important;
                margin-bottom: 5px;
                font-size: 0.85rem;
            }

            @media (max-width: 768px) {
                .table-responsive {
                    font-size: 0.85rem;
                }

                .btn-group-vertical {
                    flex-direction: row;
                    flex-wrap: wrap;
                }

                .btn-group-vertical .btn {
                    margin-right: 5px;
                    margin-bottom: 5px;
                }
            }
        </style>

        <script>
            Auto refresh every 30 seconds
            setTimeout(function() {
                window.location.reload();
            }, 600000);

            // Start cooking button handler
            document.querySelectorAll('.start-cooking-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const orderId = this.getAttribute('data-order-id');

                    // Update button state
                    this.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i> Starting...';
                    this.disabled = true;
                    this.classList.remove('btn-warning');
                    this.classList.add('btn-secondary');

                    // Send AJAX request
                    fetch(`/kitchen/${orderId}/start`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                this.innerHTML = '<i class="fas fa-fire mr-1"></i> Cooking...';
                                this.classList.remove('btn-secondary');
                                this.classList.add('btn-danger');

                                // Show success message
                                showToast('Order started cooking!', 'success');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            this.innerHTML = '<i class="fas fa-fire mr-1"></i> Start Cooking';
                            this.disabled = false;
                            this.classList.remove('btn-secondary');
                            this.classList.add('btn-warning');
                        });
                });
            });

            function showToast(message, type = 'success') {
                // Simple toast notification
                const toast = document.createElement('div');
                toast.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
                toast.style.cssText = 'position: fixed; top: 20px; right: 20px; z-index: 9999;';
                toast.innerHTML = `
            ${message}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        `;
                document.body.appendChild(toast);

                setTimeout(() => {
                    toast.remove();
                }, 3000);
            }
        </script>
    @endcan

@endsection
