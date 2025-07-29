{{-- resources/views/dashboard/reports/index.blade.php --}}
@extends('dashboard')

@section('content')
<div class="container mt-4">
    <h4 class="mb-4"><i class="bi bi-bar-chart"></i> Reports & Filters</h4>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="card shadow border-0 bg-success text-white">
                <div class="card-body">
                    <h5 class="card-title"><i class="bi bi-graph-up-arrow"></i> Revenue Report</h5>
                    <p>Group-wise, Branch-wise and Student-wise revenue.</p>
                    <a href="{{ route('reports.revenue') }}" class="btn btn-light btn-sm">View Report</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow border-0 bg-danger text-white">
                <div class="card-body">
                    <h5 class="card-title"><i class="bi bi-cash-coin"></i> Expense Report</h5>
                    <p>Category-wise and Branch-wise expense summary.</p>
                    <a href="{{ route('reports.expenses') }}" class="btn btn-light btn-sm">View Report</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
