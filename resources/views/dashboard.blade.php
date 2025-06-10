<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">Welcome, {{ auth()->user()->name }}!</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-header bg-primary text-white">
            Dashboard Navigation
        </div>
        <div class="card-body">
            <ul class="list-group">

                <!-- Common to Admin and Super Admin -->
                <li class="list-group-item">
                    <a href="{{ route('enquiries.index') }}">📋 View Enquiries</a>
                </li>


                <!-- Super Admin Only
                @if(auth()->user()->role === 'superadmin')
                    <li class="list-group-item">
                        <a href="{{ route('admin.activities.index') }}">🧾 View Admin Activities</a>
                    </li>

                    <li class="list-group-item">
                        <a href="{{ route('expenses.index') }}">💰 View Expenses</a>
                    </li>

                    <li class="list-group-item">
                        <a href="{{ route('reports.income_vs_expense') }}">📈 Income vs Expense Report</a>
                    </li>
                @endif -->

                <li class="list-group-item">
                    <form action="{{ route('logout') }}" method="POST" onsubmit="return confirm('Logout?')">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-danger mt-2">Logout</button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</div>
</body>
</html>
