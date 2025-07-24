<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Enquiry Form</title>
    <!-- Site Icon -->
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">


    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/wordpress-style.css') }}" rel="stylesheet">
        <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!--  Bootstrap Icons (required for phone icon) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Custom WordPress Style -->
    <link href="{{ asset('css/wordpress-style.css') }}" rel="stylesheet">

</head>
<body>

    {{--  Header --}}
    @include('public.enquiry.header')

    {{--  Main Content (form will come here) --}}
    <main class="container py-4">
        @yield('content')
    </main>

    {{--  Footer --}}
    @include('public.enquiry.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
