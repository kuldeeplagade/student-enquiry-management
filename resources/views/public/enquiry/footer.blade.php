<!-- Wave Shape Top -->
<div class="position-relative">
  <div class="footer-wave">
    <svg class="wave-svg" viewBox="0 0 1440 40" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
      <path fill="#0B213E"
        d="M0,20 
           C 30,10 60,30 90,20 
           C 120,10 150,30 180,20 
           C 210,10 240,30 270,20 
           C 300,10 330,30 360,20 
           C 390,10 420,30 450,20 
           C 480,10 510,30 540,20 
           C 570,10 600,30 630,20 
           C 660,10 690,30 720,20 
           C 750,10 780,30 810,20 
           C 840,10 870,30 900,20 
           C 930,10 960,30 990,20 
           C 1020,10 1050,30 1080,20 
           C 1110,10 1140,30 1170,20 
           C 1200,10 1230,30 1260,20 
           C 1290,10 1320,30 1350,20 
           C 1380,10 1410,30 1440,20 
           V40 H0 Z" />
    </svg>
  </div>
</div>

<!-- Footer Section -->
<footer style="background-color: #0B213E;" class="text-light py-5">
  <div class="container">
    <!-- <div class="row justify-content-center text-center text-md-start align-items-start"> -->
    <div class="row g-4 justify-content-center text-center text-md-start align-items-start">
  
      <!-- Logo + Address -->
      <div class="col-md-3 mb-4">
        <img src="{{ asset('images/logo.jpeg') }}" alt="Hamare Nanhe Kadam" style="max-width: 150px;" class="mb-3">
        <p style="color: #C6A4DB;">Hamare Nanhe Kadam</p>
        <p class="footer-text"><i class="bi bi-geo-alt-fill me-2"></i>Sector 8, Ghansoli Gaon, Ghansoli,<br>Thane, Navi Mumbai, Maharashtra 400701</p>
        <p class="footer-text"><i class="bi bi-telephone-fill me-2"></i>9850454156</p>
        <p class="footer-text"><i class="bi bi-envelope-fill me-2"></i>hamare.nanhekadam@gmail.com</p>
        <div class="d-flex justify-content-center justify-content-md-start mt-3 gap-3">
          <a href="#" class="footer-icon"><i class="bi bi-twitter"></i></a>
          <a href="#" class="footer-icon"><i class="bi bi-facebook"></i></a>
          <a href="#" class="footer-icon"><i class="bi bi-pinterest"></i></a>
          <a href="#" class="footer-icon"><i class="bi bi-instagram"></i></a>
        </div>
      </div>

      <!-- Links -->
       <div class="col-md-2 mb-4 pe-1">
        <h5 class="fw-bold mb-3" style="font-family: 'Fredoka', sans-serif;">Links</h5>
        <ul class="list-unstyled small">
            <li class="mb-2"><a href="http://localhost:8081/hnk_web/#home" class="footer-link">Home</a></li>
            <li class="mb-2"><a href="http://localhost:8081/hnk_web/#about" class="footer-link">About Us</a></li>
            <li class="mb-2"><a href="http://localhost:8081/hnk_web/#academics" class="footer-link">Academics</a></li>
            <li class="mb-2"><a href="http://localhost:8081/hnk_web/#gallery" class="footer-link">Gallery</a></li>
            <li class="mb-2"><a href="http://localhost:8081/hnk_web/#teachers" class="footer-link">Our Teacher</a></li>
            <li class="mb-2"><a href="http://localhost:8081/hnk_web/#testimonials" class="footer-link">Testimonial</a></li>
            <li class="mb-2"><a href="http://localhost:8081/hnk_web/#events" class="footer-link">Our Events</a></li>
            <li class="mb-2"><a href="http://localhost:8081/hnk_web/#admission" class="footer-link">Admission</a></li>
            <li class="mb-2"><a href="http://localhost:8081/hnk_web/#contact" class="footer-link">Contact</a></li>
        </ul>
      </div>

      <!-- Gallery -->
       <div class="col-md-3 mb-4 ps-0 ms-0">
        <h5 class="fw-bold mb-3 text-start" style="font-family: 'Fredoka', sans-serif;">Gallery</h5>
        <div class="row g-2">
          @for ($i = 1; $i <= 6; $i++)
            <div class="col-4">
              <img src="{{ asset('images/gallery1.jpg') }}" alt="Gallery {{ $i }}"
                  class="img-fluid rounded gallery-img" style="height: 80px; object-fit: cover;">
            </div>
          @endfor
        </div>
      </div>
    </div>

    <!-- Copyright -->
    <hr class="border-top border-light my-4">
    <div class="text-center small text-light">
      <p class="mb-0">
        © Copyright by 2025 Hamare Nanhe Kadam.<br>
        Website design and development by 
        <a href="#" class="text-decoration-none text-purple">Infinity Dsign</a>
      </p>
    </div>
  </div>
</footer>

<!-- Custom Styles -->
<style>
.footer-wave svg {
  display: block;
  width: 100%;
  height: 100px;
  margin-bottom: -1px;
}

.text-purple {
  color: #C6A4DB !important;
}

.footer-link,
.footer-text {
  color: #C6A4DB;
  transition: color 0.3s ease;
  display: block;
  padding: 4px 0;
  text-decoration: none;
}

.footer-link:hover,
.footer-text:hover {
  color: #ffffff !important;
}

.footer-icon {
  color: #C6A4DB;
  font-size: 18px;
  transition: color 0.3s ease;
}

.footer-icon:hover {
  color: #ffffff;
}
</style>
