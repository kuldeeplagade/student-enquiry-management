@extends('dashboard')

@section('content')
<div class="container-fluid mt-4">
    <h4 class="mb-4 d-flex align-items-center">
        <i class="bi bi-bar-chart-line-fill me-2"></i> Revenue Report
    </h4>

    {{-- Filters --}}
    <form method="GET" class="row g-3 align-items-end mb-4">
        {{-- Month --}}
        <div class="col-md-2">
            <label class="form-label">Month</label>
            <select name="month" class="form-select">
                <option value="">All Months</option>
                @foreach(range(1, 12) as $m)
                    <option value="{{ sprintf('%02d', $m) }}"
                        {{ (request('month') ?? $month) == sprintf('%02d', $m) ? 'selected' : '' }}>
                        {{ DateTime::createFromFormat('!m', $m)->format('F') }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Year --}}
        <div class="col-md-2">
            <label class="form-label">Year</label>
            <select name="year" class="form-select">
                <option value="">All Years</option>
                @foreach(range(date('Y') - 3, date('Y') + 1) as $y)
                    <option value="{{ $y }}" {{ (request('year') ?? $year) == $y ? 'selected' : '' }}>
                        {{ $y }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Branch --}}
        <div class="col-md-3">
            <label class="form-label">Branch</label>
            <select name="branch_name" class="form-select">
                <option value="">All Branches</option>
                <option value="Mumbai Branch 1" {{ request('branch_name') == 'Mumbai Branch 1' ? 'selected' : '' }}>Mumbai Branch 1</option>
                <option value="Mumbai Branch 2" {{ request('branch_name') == 'Mumbai Branch 2' ? 'selected' : '' }}>Mumbai Branch 2</option>
            </select>
        </div>

        {{-- Class --}}
        <div class="col-md-3">
            <label class="form-label">Class</label>
            <select name="admission_for" class="form-select">
                <option value="">All Groups</option>
                @foreach(['Playgroup', 'Nursery', 'Jr.KG', 'Sr.KG', 'Day Care'] as $group)
                    <option value="{{ $group }}" {{ request('admission_for') == $group ? 'selected' : '' }}>{{ $group }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-2 d-flex gap-2">
            <button class="btn btn-primary w-50">
                <i class="bi bi-filter-circle me-1"></i> Filter
            </button>
            <a href="{{ route('reports.revenue') }}" class="btn btn-outline-secondary w-50">
                <i class="bi bi-x-circle me-1"></i> Clear
            </a>
        </div>
    </form>

    {{-- Summary Cards --}}
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-success shadow-sm">
                <div class="card-body text-success">
                    <h6 class="mb-1"><i class="bi bi-cash-coin me-1"></i> Total Revenue</h6>
                    <h5 class="fw-bold">₹{{ number_format($totalPaid, 2) }}</h5>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-info shadow-sm">
                <div class="card-body text-info">
                    <h6 class="mb-1"><i class="bi bi-wallet2 me-1"></i> Expected Revenue</h6>
                    <h5 class="fw-bold">₹{{ number_format($totalFinalFee, 2) }}</h5>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-warning shadow-sm">
                <div class="card-body text-warning">
                    <h6 class="mb-1"><i class="bi bi-percent me-1"></i> Total Discount</h6>
                    <h5 class="fw-bold">₹{{ number_format($totalDiscount, 2) }}</h5>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-danger shadow-sm">
                <div class="card-body text-danger">
                    <h6 class="mb-1"><i class="bi bi-cash-stack me-1"></i> Pending Amount</h6>
                    <h5 class="fw-bold">₹{{ number_format($totalPending, 2) }}</h5>
                </div>
            </div>
        </div>
    </div>

    {{-- Revenue Table --}}
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover align-middle text-center mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>SN</th>
                            <th>Student</th>
                            <th>Class</th>
                            <th>Branch</th>
                            <th>Base Fee (₹)</th>
                            <th>Discount (₹)</th>
                            <th>Final Fee (₹)</th>
                            <th>Paid (₹)</th>
                            <th>Pending (₹)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($paginatedEnquiries as $index => $enquiry)
                            @php
                                $paid = $enquiry->payments->sum('amount_paid');
                                $final = $enquiry->final_fee ?? $enquiry->default_fee ?? 0;
                                $pending = max(0, $final - $paid);
                            @endphp
                            <tr>
                                <td>{{ ($paginatedEnquiries->currentPage() - 1) * $paginatedEnquiries->perPage() + $index + 1 }}</td>
                                <td>{{ $enquiry->surname }} {{ $enquiry->first_name }}</td>
                                <td>{{ $enquiry->admission_for }}</td>
                                <td>{{ $enquiry->branch_name }}</td>
                                <td>₹{{ number_format($enquiry->default_fee ?? 0, 2) }}</td>
                                <td>₹{{ number_format($enquiry->discount_amount ?? 0, 2) }}</td>
                                <td>₹{{ number_format($final, 2) }}</td>
                                <td>₹{{ number_format($paid, 2) }}</td>
                                <td class="text-danger fw-bold">₹{{ number_format($pending, 2) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted py-4">
                                    <i class="bi bi-emoji-frown me-2 fs-5"></i> No records found for selected filters.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{-- Pagination --}}
            <div class="p-3">
                {{ $paginatedEnquiries->withQueryString()->links('components.shared-pagination', ['paginator' => $paginatedEnquiries]) }}
            </div>

        </div>
    </div>
</div>
@endsection
