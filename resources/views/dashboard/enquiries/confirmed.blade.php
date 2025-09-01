@extends('dashboard')

@section('content')
<h3 class="mb-4 d-flex align-items-center">
    <i class="bi bi-person-check-fill text-dark fs-4 me-2"></i> Confirmed Admissions
</h3>

<!-- Filter by Class -->
<form method="GET" action="{{ route('enquiries.confirmed') }}" class="row g-2 align-items-end mb-3">
    <div class="col-md-2">
        <label class="form-label">Group</label>
        <select name="class" class="form-select">
            <option value="All">All Groups</option>
            @foreach($classes as $class)
                <option value="{{ $class }}" {{ request('class') == $class ? 'selected' : '' }}>
                    {{ $class }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-2">
        <label class="form-label">Branch</label>
        <select name="branch_name" class="form-select">
            <option value="All">All Branches</option>
            @foreach($branches as $branch)
                <option value="{{ $branch }}" {{ request('branch_name') == $branch ? 'selected' : '' }}>
                    {{ $branch }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-3">
        <label class="form-label">Search</label>
        <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Name / Mobile">
    </div>

    <div class="col-md-2">
        <label class="form-label">&nbsp;</label>
        <button type="submit" class="btn btn-primary w-100">
            <i class="bi bi-funnel-fill me-1"></i> Filter
        </button>
    </div>

    <div class="col-md-2">
        <label class="form-label">&nbsp;</label>
        <a href="{{ route('enquiries.confirmed') }}" class="btn btn-outline-secondary w-100">
            <i class="bi bi-x-circle me-1"></i> Reset
        </a>
    </div>
</form>



<!-- Table -->
<div class="card shadow-sm border-0">
    <div class="card-body p-0 enquiry-table-wrapper">
        <div style="max-height: 420px; overflow-y: auto;">
            <table class="table table-bordered table-hover mb-0 align-middle text-center">
                <thead class="table-primary text-dark">
                    <tr>
                        <th>SR</th>
                        <th>Candidate Name</th>
                        <th>DOB</th>
                        <th>Contact</th>
                        <th>Class</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @php $index = ($enquiries->currentPage() - 1) * $enquiries->perPage() + 1; @endphp
                    @forelse($enquiries as $enquiry)
                        <tr>
                            <td>{{ $index++ }}</td>
                            <td>{{ $enquiry->first_name }} {{ $enquiry->surname }}</td>
                            <td>{{ $enquiry->dob }}</td>
                            <td>{{ $enquiry->father_mobile }}</td>
                            <td>{{ $enquiry->admission_for }}</td>
                            <td>
                                <a href="{{ route('enquiries.edit', $enquiry->id) }}" class="btn btn-sm custom-btn edit-btn me-1 mb-1">
                                    <i class="bi bi-pencil-square me-1"></i> Edit
                                </a>

                                <a href="{{ route('enquiries.show', $enquiry->id) }}" class="btn btn-sm custom-btn view-btn me-1 mb-1">
                                    <i class="bi bi-eye me-1"></i> View
                                </a>

                                <a href="{{ route('payments.index', $enquiry->id) }}" class="btn btn-sm custom-btn payment-btn me-1 mb-1">
                                    <i class="bi bi-currency-rupee me-1"></i> Payment
                                </a>

                                @if($enquiry->discount_amount == 0 && $enquiry->payments->count() == 0)
                                    <button class="btn btn-sm btn-danger mb-1" onclick="confirmDelete({{ $enquiry->id }})">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">
                                <i class="bi bi-emoji-frown fs-4 me-2"></i> No confirmed admissions found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Pagination -->
@include('components.shared-pagination', ['paginator' => $enquiries])

<!-- Delete JS -->
<script>
    function confirmDelete(id) {
        if (confirm("Are you sure you want to delete this unconfirmed enquiry? This action cannot be undone.")) {
            window.location.href = `/enquiries/${id}/delete`;
        }
    }
</script>

<!-- Button Styles -->
<style>
    .custom-btn {
        color: #fff;
        border-radius: 6px;
        padding: 6px 12px;
        font-size: 0.875rem;
        transition: background-color 0.3s ease;
    }

    .edit-btn {
        background-color: #f0ad4e;
    }

    .edit-btn:hover {
        background-color: #e0962f;
    }

    .view-btn {
        background-color: #5bc0de;
    }

    .view-btn:hover {
        background-color: #31a6c4;
    }

    .payment-btn {
        background-color: #5cb85c;
    }

    .payment-btn:hover {
        background-color: #449d44;
    }
</style>
@endsection
