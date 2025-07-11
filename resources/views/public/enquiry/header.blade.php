<!-- File: resources/views/public/enquiry/header.blade.php -->

<!-- Add this in your <head> for font (Poppins or Baloo) -->
<link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;600;700&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<style>
    body {
        font-family: 'Fredoka', sans-serif;
    }

    .main-header a {
        font-weight: 600;
        color: #6c757d; /* muted grey */
        text-decoration: none;
        transition: color 0.3s ease;
        font-size: 16px;
        font-family: 'Fredoka', sans-serif;
    }

    .main-header a:hover,
    .main-header a.active {
        color: #7e3f98; /* purple tone */
    }

    .call-circle {
        background-color: #f4c17a;
        width: 40px;
        height: 40px;
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: 50%;
    }

    .call-icon {
        color: #fff;
        font-size: 18px;
    }
</style>


<header class="bg-white shadow-sm py-2 main-header">
    <div class="container-fluid px-4 d-flex align-items-center justify-content-between">
        <!-- Logo -->
        <div class="d-flex align-items-center">
            <img src="{{ asset('images/logo.jpeg') }}" alt="Logo" style="height: 60px;">
        </div>

        <!-- Navbar -->
        <nav class="d-none d-md-flex gap-4 justify-content-center flex-grow-1">
            <a href="http://localhost:8081/hnk_web/#home">Home</a>
            <a href="http://localhost:8081/hnk_web/#about">About Us</a>
            <a href="http://localhost:8081/hnk_web/#academics">Academics</a>
            <a href="http://localhost:8081/hnk_web/#gallery">Gallery</a>
            <a href="http://localhost:8081/hnk_web/#teachers">Our Teacher</a>
            <a href="http://localhost:8081/hnk_web/#testimonials">Testimonial</a>
            <a href="http://localhost:8081/hnk_web/#events">Our Events</a>
            <a href="http://localhost:8081/hnk_web/#admission">Admission</a>
            <a href="http://localhost:8081/hnk_web/#contact">Contact</a>
        </nav>



        <!-- Contact Info -->
        <div class="d-flex align-items-center gap-2">
            <div class="call-circle">
                <i class="bi bi-telephone-fill call-icon"></i>
            </div>
            <div class="d-flex flex-column">
                <small class="text-muted mb-0">Call to Questions</small>
                <strong class="text-dark">9850454156</strong>
            </div>
        </div>
    </div>
</header>
