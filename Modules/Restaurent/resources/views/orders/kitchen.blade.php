@extends('setting::layouts.master')
<meta name="csrf-token" content="{{ csrf_token() }}">

@section('title', 'Kitchen Orders')

@section('content')
    <div class="content-wrapper bg-light">
        <!-- Header -->
        <section class="content-header">
            <div class="container-fluid d-flex justify-content-between align-items-center">
                <h1 class="mb-0 text-orange font-weight-bold">🍳 Kitchen Orders</h1>
                <small class="text-muted">Manage ongoing orders efficiently</small>
            </div>
        </section>

        <!-- Main Content -->
        <section class="content">
            <div class="container-fluid">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-orange text-white d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-utensils"></i> Order Queue</span>
                        <span class="badge bg-light text-dark">{{ count($orders) }} Active Orders</span>
                    </div>

                    <div class="card">
                        <div class="card-header">

                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Order ID</th>
                                        <th>Items</th>
                                        <th>Qty</th>
                                        <th>Type</th>
                                        <th>Source</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($orders as $res)
                                        <tr id="order-row-{{ $res->id }}" class="text-center">
                                            <td>{{ $loop->iteration }}</td>
                                            <td class="fw-bold text-orange">#RCO000{{ $res->id }}</td>
                                            <td class="text-start">
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
                                                        <li><i
                                                                class="fas fa-check-circle text-success me-1"></i> {{ $variation->name ?? 'N/A' }}-{{ $menu->name ?? 'N/A' }}
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </td>
                                            <td>
                                                <ul class="list-unstyled mb-0">
                                                    @foreach ($res->items as $item)
                                                        <li>{{ $item->qty }}</li>
                                                    @endforeach
                                                </ul>
                                            </td>
                                            <td><span class="badge bg-info">{{ ucfirst($res->order_type) }}</span></td>
                                            <td><span class="badge bg-primary">{{ ucfirst($res->order_source) }}</span></td>
                                            <td id="status-{{ $res->id }}">
                                                @if ($res->status === 'pending')
                                                    <span class="badge bg-warning text-dark">Pending</span>
                                                @elseif ($res->status === 'cooking')
                                                    <span class="badge bg-orange">Cooking</span>
                                                @elseif ($res->status === 'served')
                                                    <span class="badge bg-success">Served</span>
                                                @else
                                                    <span class="badge bg-secondary">Unknown</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <button class="btn btn-warning btn-sm" data-action="start"
                                                        data-id="{{ $res->id }}"
                                                        data-url="{{ route('kitchen.start', $res->id) }}"
                                                        style="height:38px;"> <!-- match the default form button height -->
                                                        <i class="fas fa-fire me-1"></i>Start
                                                    </button>

                                                    <form action="{{ route('kitchen.markServed', $res->id) }}"
                                                        method="POST" style="display:inline;">
                                                        @csrf
                                                        <button type="submit" class="btn btn-success btn-sm"
                                                            style="height:38px;">
                                                            <i class="fas fa-check me-1"></i>Served
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center text-muted py-4">
                                                <i class="fas fa-inbox fa-2x mb-2 text-secondary"></i><br>
                                                No active orders in the kitchen.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>Order ID</th>
                                        <th>Items</th>
                                        <th>Qty</th>
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
    </section>
    </div>





    <!-- JavaScript -->
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            document.querySelectorAll('button[data-action]').forEach(btn => {
                btn.addEventListener('click', () => {
                    const action = btn.dataset.action;
                    const id = btn.dataset.id;
                    const url = btn.dataset.url;

                    if (!confirm(
                            `Mark this order as ${action === 'served' ? 'Served' : 'Cooking'}?`))
                        return;

                    fetch(url, {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": csrfToken
                            },
                            body: JSON.stringify({
                                action
                            })
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                const row = document.getElementById(`order-row-${id}`);
                                if (action === 'served' && row) {
                                    row.remove();
                                    alert('✅ Order served and sent to Reception successfully!');
                                } else {
                                    const statusCell = document.getElementById(`status-${id}`);
                                    if (statusCell) statusCell.innerHTML =
                                        `<span class="badge bg-orange">Cooking</span>`;
                                }
                            } else {
                                alert('❌ Failed: ' + (data.message || 'Unknown error'));
                            }
                        })
                        .catch(err => console.error(err));
                });
            });
        });
    </script>
@endsection
