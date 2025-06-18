@extends('dashboard')

@section('content')
<div class="container mt-4">
    <h4 class="mb-4">📊 Revenue & Expense Summary </h4>

    <div class="row mb-4">
        <!-- Total Revenue -->
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5 class="card-title">💰 Total Revenue</h5>
                    <p class="card-text fs-4 ms-4">₹{{ number_format($totalRevenue, 2) }}</p>
                </div>
            </div>
        </div>

        <!-- Total Expenses -->
        <div class="col-md-3">
            <div class="card bg-danger text-white">
                <div class="card-body">
                    <h5 class="card-title">💸 Total Expenses</h5>
                    <p class="card-text fs-4 ms-4">₹{{ number_format($totalExpenses, 2) }}</p>
                </div>
            </div>
        </div>

        <!-- Net Profit -->
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5 class="card-title">📈 Net Profit</h5>
                    <p class="card-text fs-4 ms-4">₹{{ number_format($netProfit, 2) }}</p>
                </div>
            </div>
        </div>

        <!-- Expected Revenue -->
        <div class="col-md-3">
            <div class="card bg-warning text-dark">
                <div class="card-body">
                    <h5 class="card-title">🧾 Expected Revenue</h5>
                    <p class="card-text fs-4 ms-4">₹{{ number_format($expectedRevenue, 2) }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection