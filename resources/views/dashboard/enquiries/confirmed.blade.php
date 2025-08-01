@extends('dashboard')

@section('content')
<h2 class="mb-4 d-flex align-items-center">
    <i class="bi bi-person-check-fill text-success fs-4 me-2"></i> Confirmed Admissions
</h2>

<!-- Filter by Class -->
<form method="GET" action="{{ route('enquiries.confirmed') }}" class="mb-4">
    <div class="row g-3 align-items-center">
        <div class="col-md-4">
            <label for="class" class="form-label fw-semibold">Filter by Class</label>
            <select name="class" id="class" class="form-select" onchange="this.form.submit()">
                <option value="All" {{ $selectedClass == 'All' ? 'selected' : '' }}>All</option>
                @foreach($classes as $class)
                    <option value="{{ $class }}" {{ $selectedClass == $class ? 'selected' : '' }}>
                        {{ $class }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
</form>

<!-- Search -->
<form method="GET" class="d-flex mb-3">
    <input type="text" name="search" class="form-control me-2" placeholder="Search..." value="{{ request('search') }}">
    <button type="submit" class="btn btn-outline-primary">Search</button>
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
