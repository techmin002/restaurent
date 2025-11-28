@extends('setting::layouts.master')
@section('title', 'Restaurant Dashboard')
@section('content')
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
                                    <i class="fas fa-list-alt mr-1"></i>
                                    Recent Accepted Orders
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
                                                    <td colspan="6" class="text-center text-muted">No recent orders yet</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
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
                                <h3 class="card-title"><i class="fas fa-fire mr-1"></i> Kitchen Queue</h3>
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
                                            <span class="badge badge-info">{{ $order->created_at->diffForHumans() }}</span>
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


                                <!-- Completed Orders Table -->
                                <div class="card card-danger">
                                    <div class="card-header">
                                        <h3 class="card-title"><i class="fas fa-check-circle mr-1"></i> Completed Orders</h3>
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


            @endsection
