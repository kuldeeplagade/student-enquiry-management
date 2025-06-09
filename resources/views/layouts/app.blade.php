<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Enquiry - Mantis</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Mantis CSS -->
    <link rel="stylesheet" href="{{ asset('mantis/assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('mantis/assets/css/icons.css') }}">
    <link rel="stylesheet" href="{{ asset('mantis/assets/libs/bootstrap/css/bootstrap.min.css') }}">
</head>

<body>
    <!-- Sidebar, header, etc., can stay if needed -->
    
    <!-- Page content -->
    <div class="container mt-5">
        @yield('content')
    </div>

    <!-- JS -->
    <script src="{{ asset('mantis/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('mantis/assets/js/app.js') }}"></script>

    @stack('scripts')
</body>
</html>
