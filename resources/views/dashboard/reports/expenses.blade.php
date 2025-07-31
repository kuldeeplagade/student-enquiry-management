@extends('dashboard')

@section('content')
<div class="container-fluid mt-4">
    <h4 class="mb-4 d-flex align-items-center">
        <i class="bi bi-receipt me-2"></i> Expense Report
    </h4>

    {{-- Filter Section --}}
    <form method="GET" class="row g-3 align-items-end mb-4">
        <div class="col-md-2">
            <label class="form-label">Month</label>
            <select name="month" class="form-select">
                <option value="">All Months</option>
                @foreach(range(1, 12) as $m)
                    <option value="{{ sprintf('%02d', $m) }}"
                        {{ (old('month', $month) == sprintf('%02d', $m)) ? 'selected' : '' }}>
                        {{ DateTime::createFromFormat('!m', $m)->format('F') }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-2">
            <label class="form-label">Year</label>
            <select name="year" class="form-select">
            <option value="" {{ $year == "" ? 'selected' : '' }}>All Years</option>
            @foreach(range(date('Y') - 3, date('Y') + 1) as $y)
                <option value="{{ $y }}" {{ old('year', $year) == $y ? 'selected' : '' }}>
                    {{ $y }}
                </option>
            @endforeach

            </select>

        </div>

        <div class="col-md-2">
            <label class="form-label">Branch</label>
            <select name="branch_name" class="form-select">
                <option value="">All Branches</option>
                <option value="Mumbai Branch 1" {{ request('branch_name') == 'Mumbai Branch 1' ? 'selected' : '' }}>Mumbai Branch 1</option>
                <option value="Mumbai Branch 2" {{ request('branch_name') == 'Mumbai Branch 2' ? 'selected' : '' }}>Mumbai Branch 2</option>
            </select>
        </div>

        <div class="col-md-2">
            <label class="form-label">Category</label>
            <select name="category" class="form-select">
                <option value="">All Categories</option>
                @foreach ($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
        </div>



        <div class="col-md-2">
            <label class="form-label">Payment Mode</label>
            <select name="payment_mode" class="form-select">
                <option value="">All Modes</option>
                @foreach(['Cash', 'UPI', 'Bank Transfer'] as $mode)
                    <option value="{{ $mode }}" {{ request('payment_mode') == $mode ? 'selected' : '' }}>
                        {{ $mode }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-2 d-flex gap-2">
            <button class="btn btn-primary w-50">
                <i class="bi bi-filter-circle me-1"></i> Filter
            </button>
            <a href="{{ route('reports.expenses') }}" class="btn btn-outline-secondary w-50">
                <i class="bi bi-x-circle me-1"></i> Clear
            </a>
        </div>
    </form>

    {{-- Summary Card --}}
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card border-danger shadow-sm">
                <div class="card-body text-danger">
                    <h6 class="mb-1"><i class="bi bi-cash-stack me-1"></i> Total Expenses</h6>
                    <h5 class="fw-bold">₹{{ number_format($totalExpense, 2) }}</h5>
                </div>
            </div>
        </div>
    </div>

    {{-- Expenses Table --}}
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover text-center mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>SN</th>
                            <th>Title</th>
                            <th>Amount (₹)</th>
                            <th>Category</th>
                            <th>Mode</th>
                            <th>Branch</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($expenses as $index => $expense)
                            <tr>
                                <td>{{ ($expenses->currentPage() - 1) * $expenses->perPage() + $index + 1 }}</td>
                                <td>{{ $expense->title }}</td>
                                <td>₹{{ number_format($expense->amount, 2) }}</td>
                                <td>{{ $expense->category->name ?? 'N/A' }}</td>
                                <td>{{ $expense->payment_mode }}</td>
                                <td>{{ $expense->branch_name }}</td>
                                <td>{{ \Carbon\Carbon::parse($expense->date)->format('d M Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">
                                    <i class="bi bi-emoji-frown me-2 fs-5"></i> No expense records found for selected filters.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="p-3">
                {{ $expenses->withQueryString()->links('components.shared-pagination', ['paginator' => $expenses]) }}
            </div>
        </div>
    </div>
</div>
@endsection
