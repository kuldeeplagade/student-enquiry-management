@extends('dashboard')

@section('content')
<div class="container mt-4">
    <h4 class="mb-4"><i class="bi bi-bar-chart-line"></i> Revenue & Expense Summary</h4>

    <!-- Filter Form -->
    <form method="GET" class="row g-3 mb-4">
        <div class="col-md-3">
            <label for="month" class="form-label">Select Month</label>
            <select class="form-select" name="month" id="month">
                @foreach(range(1,12) as $m)
                    <option value="{{ $m }}" {{ request('month', date('n')) == $m ? 'selected' : '' }}>
                        {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3">
            <label for="year" class="form-label">Select Year</label>
            <select class="form-select" name="year" id="year">
                @for($y = now()->year; $y >= 2023; $y--)
                    <option value="{{ $y }}" {{ request('year', date('Y')) == $y ? 'selected' : '' }}>{{ $y }}</option>
                @endfor
            </select>
        </div>

        <div class="col-md-3 d-flex align-items-end">
            <button type="submit" class="btn btn-outline-dark w-100"><i class="bi bi-search"></i> Filter</button>
        </div>
    </form>

    <!-- Revenue Summary Cards -->
    <div class="row mb-4">
        <!-- Total Revenue -->
        <div class="col-md-3">
            <div class="card text-white" style="background-color: #28a745;">
                <div class="card-body">
                    <h5 class="card-title"><i class="bi bi-cash-stack"></i> Total Revenue</h5>
                    <p class="card-text fs-4 ms-4">₹{{ number_format($totalRevenue, 2) }}</p>
                </div>
            </div>
        </div>

        <!-- Total Expenses -->
        <div class="col-md-3">
            <div class="card text-white" style="background-color: #dc3545;">
                <div class="card-body">
                    <h5 class="card-title"><i class="bi bi-currency-exchange"></i> Total Expenses</h5>
                    <p class="card-text fs-4 ms-4">₹{{ number_format($totalExpenses, 2) }}</p>
                </div>
            </div>
        </div>

        <!-- Net Profit -->
        <div class="col-md-3">
            <div class="card text-white" style="background-color: #007bff;">
                <div class="card-body">
                    <h5 class="card-title"><i class="bi bi-graph-up-arrow"></i> Net Profit</h5>
                    <p class="card-text fs-4 ms-4">₹{{ number_format($netProfit, 2) }}</p>
                </div>
            </div>
        </div>

        <!-- Expected Revenue -->
        <div class="col-md-3">
            <div class="card text-dark bg-warning">
                <div class="card-body">
                    <h5 class="card-title"><i class="bi bi-receipt"></i> Expected Revenue</h5>
                    <p class="card-text fs-4 ms-4">₹{{ number_format($expectedRevenue, 2) }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
