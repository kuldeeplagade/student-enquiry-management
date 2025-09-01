@extends('dashboard')

@section('content')
<h3 class="mb-4 d-flex align-items-center">
    <i class="bi bi-journal-text text-dark fs-4 me-2"></i> Enquiry List
</h3>

@section('head')
    <link href="{{ asset('css/enquiries.css') }}" rel="stylesheet">
@endsection

    <form method="GET" action="{{ route('enquiries.index') }}" class="row g-2 align-items-end mb-4">
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
            <a href="{{ route('enquiries.index') }}" class="btn btn-outline-secondary w-100">
                <i class="bi bi-x-circle me-1"></i> Reset
            </a>
        </div>
    </form>




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
                            <td class="text-center align-middle">
                                <div class="d-flex flex-wrap justify-content-center gap-1">
                                    {{-- Edit --}}
                                    <a href="{{ route('enquiries.edit', $enquiry->id) }}" class="btn btn-sm custom-btn edit-btn">
                                        <i class="bi bi-pencil-square me-1"></i> Edit
                                    </a>

                                    {{-- View --}}
                                    <a href="{{ route('enquiries.show', $enquiry->id) }}" class="btn btn-sm custom-btn view-btn">
                                        <i class="bi bi-eye me-1"></i> View
                                    </a>

                                    {{-- Payment --}}
                                    <a href="{{ route('payments.index', $enquiry->id) }}" class="btn btn-sm custom-btn payment-btn">
                                        <i class="bi bi-currency-rupee me-1"></i> Payment
                                    </a>

                                    {{-- Delete --}}
                                    @if($enquiry->discount_amount == 0 && $enquiry->payments->count() == 0)
                                        <button class="btn btn-sm custom-btn delete-btn"
                                                onclick="confirmDelete({{ $enquiry->id }})"
                                                title="Delete this enquiry">
                                            <i class="bi bi-trash me-1"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">
                                <i class="bi bi-emoji-frown fs-4 me-2"></i> No enquiries found.
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


<script>
    function confirmDelete(id) {
        if (confirm("Are you sure you want to delete this unconfirmed enquiry?")) {
            window.location.href = `/enquiries/${id}/delete`;
        }
    }
</script>

@endsection
