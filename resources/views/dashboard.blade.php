<!-- resources/views/dashboard.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            display: flex;
            margin: 0;
        }

        .sidebar {
            width: 250px;
            background: rgb(68, 142, 222);
            color: #fff;
            min-height: 100vh;
            padding-top: 1rem;
        }

        .sidebar h4 {
            padding: 1rem 1.25rem;
            font-weight: bold;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar a {
            color: #fff;
            display: block;
            padding: 12px 20px;
            text-decoration: none;
            transition: background 0.2s, padding-left 0.2s;
        }

        .sidebar a:hover {
            background: rgba(255, 255, 255, 0.1);
            padding-left: 25px;
        }

        .content {
            flex: 1;
            padding: 20px;
            background: #f4f6f9;
        }

        .navbar {
            background-color: #fff;
            border-bottom: 1px solid #dee2e6;
        }

        /*  Dropdown Hover Fix */
        .dropdown-menu .dropdown-item:hover {
            background-color: #e6eaf0 !important;  /* Light blue/gray */
            color: #000 !important;
            font-weight: 500;
        }

        /*  Optional: Hover highlight effect for Logout in red */
        .dropdown-menu .dropdown-item.text-danger:hover {
            background-color: #ffdddd !important;
            color: #c82333 !important;
        }
    </style>

</head>
<body>


<!-- Sidebar -->
<div class="sidebar">
    <h4 class="p-3">Dashboard</h4>

    <!-- View All Enquiries -->
    <a href="{{ route('enquiries.index') }}">
        <i class="bi bi-card-list me-2"></i> View Enquiries
    </a>

    <!-- View All Expenses -->
    <a href="{{ route('expenses.index') }}">
        <i class="bi bi-cash-coin me-2"></i> View Expenses
    </a>

    <!-- View All Revenue Summary -->
    @auth
        @if(auth()->user()->role === 'superadmin')
            <a href="{{ route('revenue.summary') }}">
                <i class="bi bi-graph-up-arrow me-2"></i> Revenue Summary
            </a>
        @endif
    @endauth

    <!-- View Admin Activities -->
    @if(auth()->user()->role === 'superadmin')
        <a href="{{ route('admin.activities') }}">
            <i class="bi bi-tools me-2"></i> Admin Activities
        </a>
    @endif
</div>

<!-- Content -->
<div class="content">
    <!-- Navbar with user dropdown -->
    <nav class="navbar navbar-light px-4 d-flex justify-content-between align-items-center border-bottom" style="background: #fff;">

        <!-- Left: School Name -->
        <div class="text-primary fw-bold fs-5">
            <i class="bi bi-mortarboard-fill"></i> Hamare Nhane Kadam School
        </div>


        <!-- User Dropdown -->
        <div class="dropdown">
            <a class="btn text-white dropdown-toggle px-3 py-2" 
            href="#" role="button" 
            id="userDropdown" 
            data-bs-toggle="dropdown" 
            aria-expanded="false"
            style="border-radius: 8px; background-color: rgb(68, 142, 222);">
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

<!-- Auto-hide welcome message -->
@if(session('show_welcome'))
<script>
    setTimeout(() => {
        const msg = document.getElementById('welcomeMessage');
        if (msg) {
            msg.style.transition = "opacity 1s ease";
            msg.style.opacity = 0;
            setTimeout(() => msg.remove(), 1000);
        }
    }, 12000); // 12 seconds
</script>
@endif

</body>
</html>
