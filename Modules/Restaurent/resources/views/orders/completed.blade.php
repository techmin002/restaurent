@extends('setting::layouts.master')
<meta name="csrf-token" content="{{ csrf_token() }}">
@section('title', 'Completed Orders')

@section('content')
<div class="content-wrapper bg-light">
    <!-- Header Section -->
    <section class="content-header">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <h1 class="text-success mb-0"><i class="fas fa-check-circle"></i> Completed Orders</h1>
            <ol class="breadcrumb float-sm-right mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active">Completed Orders</li>
            </ol>
        </div>
    </section>

    <!-- Main Content -->
    <section class="content mt-2">
        <div class="container-fluid">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-success text-white d-flex justify-content-between align-items-center rounded-top-4">
                    <span><i class="fas fa-clipboard-check"></i> Completed Orders Queue</span>
                    <span class="badge bg-light text-success fs-6">{{ count($orders) }} Orders</span>
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
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                  </thead>
                   <tbody>
                                @forelse ($orders as $order)
                                    <tr class="text-center">
                                        <td>{{ $loop->iteration }}</td>
                                        <td class="fw-bold text-success">#RCO000{{ $order->id }}</td>
                                        <td>{{ $order->customer['name'] ?? $order->office['name'] }}</td>
                                        <td>{{ $order->customer['phone'] ??$order-> office['contact_numbers'] }}</td>
                                        <td class="text-start">
                                            <ul class="list-unstyled mb-0">
                                                @foreach ($order->items as $item)
                                                    @php
                                                        $variation = Modules\Restaurent\Models\MenuVariation::select('name','price')->where('id',$item->variation_id)->first();
                                                    @endphp
                                                    <li>
                                                        <i class="fas fa-check text-success"></i>
                                                        {{ $variation->name ?? 'N/A' }} 
                                                        (x{{ $item->qty }}) - Rs. {{ $variation->price ?? 0 }}
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </td>
                                        <td><span class="badge bg-info">{{ ucfirst($order->order_type ?? 'N/A') }}</span></td>
                                        <td>
                                            <span class="badge bg-success px-3 py-2">
                                                <i class="fas fa-check-circle me-1"></i> {{ ucfirst($order->status) }}
                                            </span>
                                        </td>
                                       <td>
    <form action="{{ route('orders.destroy', $order->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this order?');">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-outline-danger btn-sm">
            <i class="fa fa-trash"></i> Delete
        </button>
    </form>
</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-4 text-muted">
                                            <i class="fas fa-inbox fa-2x mb-2"></i><br>
                                            No completed orders yet.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                  <tfoot>
                   <tr>
                                    <th>S.N</th>
                                    <th>Order ID</th>
                                    <th>Customer</th>
                                    <th>Phone</th>
                                    <th>Items</th>
                                    <th>Type</th>
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

@endsection
