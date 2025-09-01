<!-- resources/views/dashboard.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">

    <!-- {{-- Allow child views to inject page-specific styles --}} -->
    @yield('head')
</head>
<body>


<!-- Sidebar -->
<div class="sidebar">
    <h4 class="p-3">Dashboard</h4>

    <!-- View All Enquiries -->
    <a href="{{ route('enquiries.index') }}"
    class="{{ request()->routeIs('enquiries.index') ? 'active' : '' }}">
        <i class="bi bi-card-list me-2"></i> View Enquiries
    </a>

    <!-- Confirmed Admissions -->
    <a href="{{ route('enquiries.confirmed') }}"
    class="{{ request()->routeIs('enquiries.confirmed') ? 'active' : '' }}">
        <i class="bi bi-check-circle me-1"></i> Confirmed Admissions
    </a>

    <!-- Add Expenses -->
    <a href="{{ route('expenses.index') }}"
    class="{{ request()->routeIs('expenses.index') ? 'active' : '' }}">
        <i class="bi bi-cash-coin me-2"></i> Add Expenses
    </a>

    <!-- Expense Report -->
    @if(auth()->user()->role === 'superadmin')
        <a href="{{ route('reports.expenses') }}"
        class="{{ request()->routeIs('reports.expenses') ? 'active' : '' }}">
            <i class="bi bi-receipt me-2"></i> Expense Report
        </a>
    @endif

    <!-- Revenue Summary -->
    @if(auth()->user()->role === 'superadmin')
        <a href="{{ route('revenue.summary') }}"
        class="{{ request()->routeIs('revenue.summary') ? 'active' : '' }}">
            <i class="bi bi-graph-up-arrow me-2"></i> Revenue Summary
        </a>
    @endif

    <!-- Revenue Report -->
    @if(auth()->user()->role === 'superadmin')
        <a href="{{ route('reports.revenue') }}"
        class="{{ request()->routeIs('reports.revenue') ? 'active' : '' }}">
            <i class="bi bi-bar-chart-line-fill me-2"></i> Revenue Report
        </a>
    @endif

    <!-- Admin Activities -->
    @if(auth()->user()->role === 'superadmin')
        <a href="{{ route('admin.activities') }}"
        class="{{ request()->routeIs('admin.activities') ? 'active' : '' }}">
            <i class="bi bi-tools me-2"></i> Admin Activities
        </a>
    @endif


</div>

<!-- Content -->
<div class="content">
    <!-- Navbar with user dropdown -->
    <nav class="navbar navbar-light px-4 d-flex justify-content-between align-items-center border-bottom" style="background: #fff;">

        <!-- Left: School Name -->
        <div class="fw-bold fs-5" style="color: #6B4378;">
            <i class="bi bi-mortarboard-fill"></i> Hamare Nhane Kadam School
        </div>


        <!-- User Dropdown -->
        <div class="dropdown">
            <a class="btn text-white dropdown-toggle px-3 py-2" 
            href="#" role="button" 
            id="userDropdown" 
            data-bs-toggle="dropdown" 
            aria-expanded="false"
            style="border-radius: 8px;">
                {{ auth()->user()->name }}
            </a>

            <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="userDropdown">
                @auth
                    @if(auth()->user()->role === 'superadmin')
                        <li>
                            <a class="dropdown-item" href="{{ route('admin.management') }}">
                                <i class="bi bi-person-gear me-2"></i> Admin Management
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                    @endif
                @endauth
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item text-danger">
                            <i class="bi bi-box-arrow-right me-2"></i> Logout
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </nav>

        
    <!-- Page Content -->
    <div class="mt-4">
        @yield('content')
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
