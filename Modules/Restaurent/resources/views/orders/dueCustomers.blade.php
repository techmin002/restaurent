@extends('setting::layouts.master')

@section('title', 'Due Customers')

@section('content')
<div class="content-wrapper">
    <section class="content-header mb-3">
        <h1 class="fw-bold">Due Customers</h1>
    </section>

    <section class="content">
        <div class="container-fluid">

            <!-- CSRF token for JS -->
            <meta name="csrf-token" content="{{ csrf_token() }}">

            <div class="card shadow-sm border-primary">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fa fa-users me-2"></i>Due Customers List</h5>
                    <span class="text-white-50">{{ $dueOrders->count() }} records</span>
                </div>

                <div class="card-body p-0">
                    <table class="table table-hover table-bordered mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Order ID</th>
                                <th>Customer Name</th>
                                <th>Due Amount (Rs.)</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($dueOrders as $index => $due)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>#RCO000{{ $due->order_id }}</td>
                                    <td>{{ $due->customer_name }}</td>
                                    <td class="text-end fw-bold">{{ number_format($due->due_amount, 2) }}</td>
                                    <td>{{ $due->created_at->format('Y-m-d') }}</td>
                                    <td>
                                        @if ($due->status === 'Due')
                                            <span class="badge bg-warning text-dark">Due</span>
                                        @else
                                            <span class="badge bg-success">Completed</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if ($due->status === 'Due')
                                            <button class="btn btn-primary btn-sm " data-toggle="modal" data-target="#exampleModal{{ $due->order_id }}">
                                                <i class="fa fa-money-bill-wave me-1"></i>Pay
                                            </button>
                                        


                            <form action="" method="POST">
                                                @csrf
                                                <input type="hidden" name="order_id" value="{{ $due->order_id }}">
                                                <input type="hidden" name="customer_id" value="{{ $due->customer_name ?? ($due->customer['id'] ?? null) }}">

                                                <div class="modal fade serveModal" id="exampleModal{{ $due->order_id }}" tabindex="-1" aria-labelledby="serveModalLabel{{ $due->order_id }}" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg modal-dialog-centered">
                                                        <div class="modal-content rounded-4 shadow">

                                                            <div class="modal-header bg-primary text-white rounded-top">
                                                                <h5 class="modal-title" id="serveModalLabel{{ $due->order_id }}">Due Summary</h5>
                                                                <button type="button" class="btn-close btn-close-white" data-dismiss="modal" aria-label="Close"></button>
                                                            </div>

                                                            <div class="modal-body p-4">
                                                                <div class="d-flex justify-content-between mb-3">
                                                                    <p class="mb-0"><strong>Order ID:</strong> #RCO000{{ $due->order_id }}</p>
                                                                    <p class="mb-0"><strong>Customer:</strong> {{ $due->customer_name?? 'N/A' }}</p>
                                                                </div>
                                                                <hr>
                                                                

                                                            </div>

                                                            <div class="modal-footer border-0">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-primary">Save changes</button>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </form>





                                        @else
                                            <button class="btn btn-success btn-sm" disabled>
                                                <i class="fa fa-check-circle me-1"></i>Paid
                                            </button>
                                        @endif
                                    </td>
                                   

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-3">No due customers found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </section>
</div>

//////////////////

                                            <!-- Modal -->


////////////////////



<script>
    document.addEventListener('DOMContentLoaded', () => {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        document.querySelectorAll('.payBtn').forEach(button => {
            button.addEventListener('click', () => {
                const dueId = button.getAttribute('data-id');

                if (!confirm('Mark this due as Paid?')) return;

                fetch(`{{ route('due.pay', ['id' => '__id__']) }}`.replace('__id__', dueId), {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({})
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            button.textContent = '';
                            button.className = 'btn btn-success btn-sm';
                            button.innerHTML = '<i class="fa fa-check-circle me-1"></i>Paid';
                            button.disabled = true;

                            const row = button.closest('tr');
                            row.querySelector('td:nth-child(6)').innerHTML = '<span class="badge bg-success">Completed</span>';
                        } else {
                            alert(data.message || 'Failed to update status');
                        }
                    })
                    .catch(() => alert('Failed to connect to server'));
            });
        });
    });
</script>
@endsection
