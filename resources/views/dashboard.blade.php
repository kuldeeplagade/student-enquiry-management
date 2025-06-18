<!-- resources/views/dashboard.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            display: flex;
        }
        .sidebar {
            width: 250px;
            background: #343a40;
            color: #fff;
            min-height: 100vh;
        }
        .sidebar a {
            color: #fff;
            display: block;
            padding: 12px 20px;
            text-decoration: none;
        }
        .sidebar a:hover {
            background: #495057;
        }
        .content {
            flex: 1;
            padding: 20px;
            background: #f8f9fa;
        }
        .navbar {
            background-color: #fff;
            border-bottom: 1px solid #dee2e6;
        }
    </style>
</head>
<body>


<!-- Sidebar -->
<div class="sidebar">
    <h4 class="p-3">Dashboard</h4>
    
    <!--View All Enquiries--->
    <a href="{{ route('enquiries.index') }}">📋 View Enquiries</a>

    <!--View All Expenses --->
    @auth
        @if(auth()->user()->role === 'superadmin')
            <a href="{{ route('expenses.index') }}">💸 View Expenses</a>
        @endif
    @endauth
    
    <!--View All Revenue Summary --->
    @auth
        @if(auth()->user()->role === 'superadmin')
            <a href="{{ route('revenue.summary') }}">📈 Revenue Summary</a>
        @endif
    @endauth

    <!--View Admin Adctivities --->
    @if(auth()->user()->role === 'superadmin')
        <a href="{{ route('admin.activities') }}">🛠️ View Admin Activities</a>
    @endif



    {{-- More menu items can be added later --}}
</div>

<div class="content">
    <nav class="navbar navbar-light">
        <div class="container-fluid">
            <span class="navbar-brand mb-0 h5">
                Welcome! You're logged in as <strong>{{ ucfirst(auth()->user()->name) }}</strong>.
            </span>
        </div>
    </nav>

    {{-- Page-specific content --}}
    <div class="mt-4">
        @yield('content')
    </div>
</div>

</body>
</html>
