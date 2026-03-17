@extends('setting::layouts.master')

@section('title', 'Contact Messages')

@section('content')
<div class="content-wrapper">

    <!-- Page Header -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Contact Messages</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Contact Messages</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- Main Content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    <!-- Stats Card -->
                    <div class="row mb-3">
                        <div class="col-md-3 col-sm-6">
                            <div class="info-box">
                                <span class="info-box-icon bg-info"><i class="fas fa-envelope"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Total Messages</span>
                                    <span class="info-box-number">{{ $messages->total() }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="info-box">
                                <span class="info-box-icon bg-success"><i class="fas fa-eye"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Read</span>
                                    <span class="info-box-number">{{ \App\Models\ContactMessage::where('is_read', true)->count() }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="info-box">
                                <span class="info-box-icon bg-warning"><i class="fas fa-clock"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Unread</span>
                                    <span class="info-box-number">{{ \App\Models\ContactMessage::where('is_read', false)->count() }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="info-box">
                                <span class="info-box-icon bg-danger"><i class="fas fa-trash"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Deleted</span>
                                    <span class="info-box-number">0</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Search Box -->
                    <div class="card card-info mb-3">
                        <div class="card-header">
                            <h3 class="card-title">Search & Filter</h3>
                        </div>
                        <div class="card-body">
                            <form method="GET" action="{{ route('contact-messages.index') }}">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Search</label>
                                            <input type="text" name="search" class="form-control" 
                                                   placeholder="Search by name, email, or message..." 
                                                   value="{{ request('search') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Status</label>
                                            <select name="status" class="form-control">
                                                <option value="">All</option>
                                                <option value="read" {{ request('status') == 'read' ? 'selected' : '' }}>Read</option>
                                                <option value="unread" {{ request('status') == 'unread' ? 'selected' : '' }}>Unread</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Date From</label>
                                            <input type="date" name="date_from" class="form-control" 
                                                   value="{{ request('date_from') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>&nbsp;</label>
                                            <button type="submit" class="btn btn-primary btn-block">
                                                <i class="fas fa-search"></i> Search
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Messages Table -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">All Contact Messages</h3>
                            <div class="card-tools">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-danger" id="bulkDeleteBtn" disabled>
                                        <i class="fas fa-trash"></i> Delete Selected
                                    </button>
                                    <button type="button" class="btn btn-sm btn-success" id="markReadBtn" disabled>
                                        <i class="fas fa-check"></i> Mark as Read
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            @if($messages->isEmpty())
                                <div class="text-center py-5">
                                    <i class="fas fa-inbox fa-4x text-muted mb-3"></i>
                                    <h4 class="text-muted">No Messages Found</h4>
                                    <p class="text-muted">No contact messages have been received yet.</p>
                                </div>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th width="50">
                                                    <input type="checkbox" id="selectAll">
                                                </th>
                                                <th width="60">ID</th>
                                                <th>Sender</th>
                                                <th>Contact Info</th>
                                                <th>Message Preview</th>
                                                <th>Status</th>
                                                <th>Date</th>
                                                <th width="200" class="text-center">Actions</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach($messages as $message)
                                            <tr class="{{ $message->is_read ? '' : 'bg-info-light' }}">
                                                <td>
                                                    <input type="checkbox" class="messageCheckbox" value="{{ $message->id }}">
                                                </td>
                                                <td>{{ $message->id }}</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="mr-2">
                                                            <div class="avatar-circle bg-primary text-white">
                                                                {{ strtoupper(substr($message->full_name, 0, 1)) }}
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <strong>{{ $message->full_name }}</strong>
                                                            @if($message->company)
                                                                <br><small class="text-muted">{{ $message->company }}</small>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div>
                                                        <i class="fas fa-envelope text-primary mr-1"></i>
                                                        <a href="mailto:{{ $message->email }}" class="text-decoration-none">
                                                            {{ $message->email }}
                                                        </a>
                                                    </div>
                                                    <div class="mt-1">
                                                        <i class="fas fa-phone text-success mr-1"></i>
                                                        {{ $message->phone_number }}
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="message-preview">
                                                        {{ Str::limit($message->message, 80) }}
                                                        @if(strlen($message->message) > 80)
                                                            <a href="#" class="text-primary" data-toggle="modal" data-target="#viewMessageModal{{ $message->id }}">
                                                                ...read more
                                                            </a>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td>
                                                    @if($message->is_read)
                                                        <span class="badge badge-success">
                                                            <i class="fas fa-check mr-1"></i> Read
                                                        </span>
                                                    @else
                                                        <span class="badge badge-warning">
                                                            <i class="fas fa-clock mr-1"></i> Unread
                                                        </span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div>
                                                        {{ $message->created_at->format('M d, Y') }}
                                                    </div>
                                                    <small class="text-muted">
                                                        {{ $message->created_at->format('h:i A') }}
                                                    </small>
                                                </td>
                                                <td class="text-center">
                                                    <div class="btn-group" role="group">
                                                        <!-- Mark as Read Button (only for unread messages) -->
                                                        @if(!$message->is_read)
                                                            <form action="{{ route('contact-messages.mark-read', $message->id) }}" 
                                                                  method="POST" class="d-inline">
                                                                @csrf
                                                                @method('PATCH')
                                                                <button type="submit" class="btn btn-sm btn-warning" title="Mark as Read">
                                                                    <i class="fas fa-check"></i>
                                                                </button>
                                                            </form>
                                                        @else
                                                            <span class="btn btn-sm btn-secondary disabled" title="Already Read">
                                                                <i class="fas fa-check-double"></i>
                                                            </span>
                                                        @endif
                                                        
                                                        <!-- View Button -->
                                                        <button type="button" class="btn btn-sm btn-info view-message-btn" 
                                                                data-id="{{ $message->id }}"
                                                                data-toggle="modal" 
                                                                data-target="#viewMessageModal{{ $message->id }}">
                                                            <i class="fas fa-eye"></i>
                                                        </button>

                                                        <!-- Reply Button -->
                                                        <a href="mailto:{{ $message->email }}" class="btn btn-sm btn-success" title="Reply">
                                                            <i class="fas fa-reply"></i>
                                                        </a>

                                                        <!-- Delete Form -->
                                                        <form action="{{ route('contact-messages.destroy', $message->id) }}" 
                                                              method="POST" class="d-inline delete-form">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger delete-btn" 
                                                                    data-message="Are you sure you want to delete this message?">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>

                                            <!-- View Message Modal -->
                                            <div class="modal fade" id="viewMessageModal{{ $message->id }}" tabindex="-1">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-primary text-white">
                                                            <h5 class="modal-title">
                                                                <i class="fas fa-envelope mr-2"></i>Message Details
                                                            </h5>
                                                            <button type="button" class="close text-white" data-dismiss="modal">
                                                                <span>&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-md-6 mb-3">
                                                                    <label class="font-weight-bold">Full Name</label>
                                                                    <p>{{ $message->full_name }}</p>
                                                                </div>
                                                                <div class="col-md-6 mb-3">
                                                                    <label class="font-weight-bold">Email</label>
                                                                    <p>
                                                                        <a href="mailto:{{ $message->email }}">{{ $message->email }}</a>
                                                                    </p>
                                                                </div>
                                                                <div class="col-md-6 mb-3">
                                                                    <label class="font-weight-bold">Phone Number</label>
                                                                    <p>{{ $message->phone_number }}</p>
                                                                </div>
                                                                <div class="col-md-6 mb-3">
                                                                    <label class="font-weight-bold">Company</label>
                                                                    <p>{{ $message->company ?: 'Not specified' }}</p>
                                                                </div>
                                                                <div class="col-md-6 mb-3">
                                                                    <label class="font-weight-bold">Date Received</label>
                                                                    <p>{{ $message->created_at->format('F d, Y \a\t h:i A') }}</p>
                                                                </div>
                                                                <div class="col-md-6 mb-3">
                                                                    <label class="font-weight-bold">Status</label>
                                                                    <p>
                                                                        @if($message->is_read)
                                                                            <span class="badge badge-success">Read</span>
                                                                        @else
                                                                            <span class="badge badge-warning">Unread</span>
                                                                        @endif
                                                                    </p>
                                                                </div>
                                                                <div class="col-12">
                                                                    <label class="font-weight-bold">Message</label>
                                                                    <div class="border rounded p-3 bg-light">
                                                                        {!! nl2br(e($message->message)) !!}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            @if(!$message->is_read)
                                                                <!-- Mark as Read Button in Modal -->
                                                                <form action="{{ route('contact-messages.mark-read', $message->id) }}" 
                                                                      method="POST" class="d-inline">
                                                                    @csrf
                                                                    @method('PATCH')
                                                                    <button type="submit" class="btn btn-warning">
                                                                        <i class="fas fa-check mr-1"></i> Mark as Read
                                                                    </button>
                                                                </form>
                                                            @endif
                                                            
                                                            <a href="mailto:{{ $message->email }}" class="btn btn-success">
                                                                <i class="fas fa-reply mr-1"></i> Reply
                                                            </a>
                                                            <form action="{{ route('contact-messages.destroy', $message->id) }}" 
                                                                  method="POST" class="d-inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger" 
                                                                        onclick="return confirm('Delete this message?')">
                                                                    <i class="fas fa-trash mr-1"></i> Delete
                                                                </button>
                                                            </form>
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </tbody>

                                    </table>
                                </div>

                                <!-- Pagination -->
                                <div class="mt-3">
                                    {{ $messages->links() }}
                                </div>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
</div>

<!-- Bulk Action Forms (Hidden) -->
<form id="bulkDeleteForm" action="{{ route('contact-messages.bulk-delete') }}" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
    <input type="hidden" name="ids" id="bulkDeleteIds">
</form>

<form id="bulkMarkReadForm" action="{{ route('contact-messages.mark-read-bulk') }}" method="POST" style="display: none;">
    @csrf
    <input type="hidden" name="ids" id="bulkMarkReadIds">
</form>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Bulk selection
    const selectAll = document.getElementById('selectAll');
    const checkboxes = document.querySelectorAll('.messageCheckbox');
    const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');
    const markReadBtn = document.getElementById('markReadBtn');
    
    function updateButtonStates() {
        const selected = document.querySelectorAll('.messageCheckbox:checked').length;
        bulkDeleteBtn.disabled = selected === 0;
        markReadBtn.disabled = selected === 0;
    }
    
    // Select all
    if (selectAll) {
        selectAll.addEventListener('change', function() {
            checkboxes.forEach(cb => cb.checked = this.checked);
            updateButtonStates();
        });
    }
    
    // Individual checkboxes
    checkboxes.forEach(cb => {
        cb.addEventListener('change', updateButtonStates);
    });
    
    // Bulk delete
    if (bulkDeleteBtn) {
        bulkDeleteBtn.addEventListener('click', function() {
            const selectedIds = Array.from(document.querySelectorAll('.messageCheckbox:checked'))
                .map(cb => cb.value);
            
            if (selectedIds.length === 0) {
                alert('Please select messages to delete.');
                return;
            }
            
            if (confirm(`Delete ${selectedIds.length} selected message(s)?`)) {
                // Set the IDs in the hidden form
                document.getElementById('bulkDeleteIds').value = JSON.stringify(selectedIds);
                // Submit the form
                document.getElementById('bulkDeleteForm').submit();
            }
        });
    }
    
    // Mark as read (bulk)
    if (markReadBtn) {
        markReadBtn.addEventListener('click', function() {
            const selectedIds = Array.from(document.querySelectorAll('.messageCheckbox:checked'))
                .map(cb => cb.value);
            
            if (selectedIds.length === 0) {
                alert('Please select messages to mark as read.');
                return;
            }
            
            if (confirm(`Mark ${selectedIds.length} message(s) as read?`)) {
                // Set the IDs in the hidden form
                document.getElementById('bulkMarkReadIds').value = JSON.stringify(selectedIds);
                // Submit the form
                document.getElementById('bulkMarkReadForm').submit();
            }
        });
    }
    
    // Delete button confirmation for single delete
    document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const message = this.getAttribute('data-message') || 'Are you sure?';
            const form = this.closest('form');
            
            if (confirm(message)) {
                form.submit();
            }
        });
    });
    
    // Auto-mark as read when viewing modal (optional feature)
    document.querySelectorAll('.view-message-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const messageId = this.getAttribute('data-id');
            const row = this.closest('tr');
            
            // If you want automatic marking when viewing, uncomment this:
            /*
            if (row.classList.contains('bg-info-light')) {
                // Auto-mark as read via AJAX
                fetch(`/contact-messages/${messageId}/mark-read`, {
                    method: 'PATCH',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    }
                }).then(response => {
                    if (response.ok) {
                        // Update UI immediately
                        row.classList.remove('bg-info-light');
                        const statusBadge = row.querySelector('td:nth-child(6) span');
                        if (statusBadge) {
                            statusBadge.className = 'badge badge-success';
                            statusBadge.innerHTML = '<i class="fas fa-check mr-1"></i> Read';
                        }
                        // Update the Mark as Read button
                        const markReadBtn = row.querySelector('.btn-warning');
                        if (markReadBtn) {
                            markReadBtn.outerHTML = '<span class="btn btn-sm btn-secondary disabled" title="Already Read"><i class="fas fa-check-double"></i></span>';
                        }
                    }
                });
            }
            */
        });
    });
});
</script>
@endpush

@push('styles')
<style>
.avatar-circle {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 16px;
}
.message-preview {
    max-width: 300px;
    word-wrap: break-word;
}
.bg-info-light {
    background-color: #e8f4fd !important;
}
.table-hover tbody tr:hover {
    background-color: rgba(0,0,0,.02);
}
.info-box {
    box-shadow: 0 0 1px rgba(0,0,0,.125);
    border-radius: .25rem;
    background: #fff;
    display: flex;
    margin-bottom: 0;
    min-height: 80px;
    padding: .5rem;
    position: relative;
}
.info-box-icon {
    border-radius: .25rem;
    align-items: center;
    display: flex;
    font-size: 1.875rem;
    justify-content: center;
    text-align: center;
    width: 70px;
}
.info-box-content {
    flex: 1;
    padding: 5px 10px;
}
.info-box-text {
    display: block;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}
.info-box-number {
    display: block;
    font-weight: 700;
    font-size: 1.5rem;
}
.btn-group .btn {
    margin: 0 2px;
}
</style>
@endpush