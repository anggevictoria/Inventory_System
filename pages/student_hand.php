<?php

include "admin_connect.php";

$servername = "localhost";
$username = "root";
$password = ""; // Your MySQL password
$dbname = "inventory";

// Create connection
$db = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

$db->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>MyPortfolio Bootstrap Template - Index</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="student/MyPortfolio/assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=https://fonts.googleapis.com/css?family=Inconsolata:400,500,600,700|Raleway:400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="student/MyPortfolio/assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="student/MyPortfolio/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="student/MyPortfolio/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="student/MyPortfolio/assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="student/MyPortfolio/assets/css/style.css" rel="stylesheet">

  

<body>

  <!-- ======= Navbar ======= -->
  <div class="collapse navbar-collapse custom-navmenu" id="main-navbar">
    <div class="container py-2 py-md-5">
      <div class="row align-items-start">
        <div class="col-md-2">
          <ul class="custom-menu">
            <li class="active"><a href="homepage_student.php">Home</a></li>
            
          </ul>
        </div>
            <div>
              <p><em>Hand tools are essential for computer engineers, allowing them to assemble, disassemble, and repair various hardware components.</p>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>

  <nav class="navbar navbar-light custom-navbar">
    <div class="container">
      <a class="navbar-brand" href="homepage_student.php">CPE Tools</a>
      <a href="#" class="burger" data-bs-toggle="collapse" data-bs-target="#main-navbar">
        <span></span>
      </a>
    </div>
  </nav>

  <main id="main">

    <!-- ======= Works Section ======= -->
    <section class="section site-portfolio">
      <div class="container">
        <div class="row mb-5 align-items-center">
          <div class="col-md-12 col-lg-6 mb-4 mb-lg-0" data-aos="fade-up">
            <h2>Hand Tools</h2>
           
          </div>
          <div class="col-md-12 col-lg-6 text-start text-lg-end" data-aos="fade-up" data-aos-delay="100">
            <div id="filters" class="filters">

            </div>
          </div>
        </div>
        <div id="portfolio-grid" class="row no-gutter" data-aos="fade-up" data-aos-delay="200">
          <div class="item web col-sm-6 col-md-4 col-lg-4 mb-4">
            <a href="student_cutting_wireCutter.php" class="item-wrap fancybox">
              <div class="work-info">
                <h3>Wire Cutter</h3>
                <span>Tool</span>
              </div>
              <img class="img-fluid" src="student/MyPortfolio/assets/img/Wire Cutter.jpg" style="width: 500px; height: 350px;">>
            </a>
          </div>
          <div class="item photography col-sm-6 col-md-4 col-lg-4 mb-4">
            <a href="work-single2.php" class="item-wrap fancybox">
              <div class="work-info">
                <h3>SolderingIron</h3>
                <span>Tool</span>
              </div>
              <img class="img-fluid" src="student/MyPortfolio/assets/img/SolderingIron.jpg" style="width: 500px; height: 350px;">
            </a>
          </div>
          <div class="item branding col-sm-6 col-md-4 col-lg-4 mb-4">
            <a href="work-single3.php" class="item-wrap fancybox">
              <div class="work-info">
                <h3>Drill</h3>
                <span>Tool</span>
              </div>
              <img class="img-fluid" src="student/MyPortfolio/assets/img/Drill.jpg" style="width: 500px; height: 350px;">
            </a>
          </div>
          <div class="item design col-sm-6 col-md-4 col-lg-4 mb-4">
            <a href="work-single4.php" class="item-wrap fancybox">
              <div class="work-info">
                <h3>Cable Crimper</h3>
                <span>Tool</span>
              </div>
              <img class="img-fluid" src="student/MyPortfolio/assets/img/Cable Crimper.jpg" style="width: 500px; height: 350px;">
            </a>
          </div>
          <div class="item photography col-sm-6 col-md-4 col-lg-4 mb-4">
            <a href="work-single5.php" class="item-wrap fancybox">
              <div class="work-info">
                <h3>DesolderingPump</h3>
                <span>Tool</span>
              </div>
              <img class="img-fluid" src="student/MyPortfolio/assets/img/DesolderingPump.jpg" style="width: 500px; height: 350px;">
            </a>
          </div>
         
        </div>
      </div>
    </section><!-- End  Works Section -->
          </div>
          <div class="swiper-pagination"></div>
        </div>

      </div>
    </section><!-- End Testimonials Section -->

  </main><!-- End #main -->

 
  <!-- Vendor JS Files -->
  <script src="student/MyPortfolio/assets/vendor/aos/aos.js"></script>
  <script src="student/MyPortfolio/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="student/MyPortfolio/assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="student/MyPortfolio/assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="student/MyPortfolio/assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="student/MyPortfolio/assets/js/main.js"></script>

</body>

</html>