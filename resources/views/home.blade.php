<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>Dreams LMS</title>
    
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/img/favicon.svg') }}">
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    
    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/all.min.css') }}">

    <!-- Owl Carousel CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/owl.theme.default.min.css') }}">
    
    <!-- Slick CSS -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/slick/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/slick/slick-theme.css') }}">
    
    <!-- Select2 CSS -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
    
    <!-- Aos CSS -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/aos/aos.css') }}">

    <!-- Main CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

</head>
<body>

    <!-- Main Wrapper -->
    <div class="main-wrapper">
    
        <!-- Header -->
        <header class="header">
            <div class="header-fixed">
                <nav class="navbar navbar-expand-lg header-nav scroll-sticky">
                    <div class="container">
                        <div class="navbar-header">
                            <a id="mobile_btn" href="javascript:void(0);">
                                <span class="bar-icon">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </span>
                            </a>
                            <a href="/" class="navbar-brand logo">
                                <img src="{{ asset('assets/img/logo.svg') }}" class="img-fluid" alt="Logo">
                            </a>
                        </div>
                        <div class="main-menu-wrapper">
                            <div class="menu-header">
                                <a href="/" class="menu-logo">
                                    <img src="{{ asset('assets/img/logo.svg') }}" class="img-fluid" alt="Logo">
                                </a>
                                <a id="menu_close" class="menu-close" href="javascript:void(0);">
                                    <i class="fas fa-times"></i>
                                </a>
                            </div>
                            <ul class="main-nav">
                                <li class="has-submenu active">
                                    <a href="#">Home <i class="fas fa-chevron-down"></i></a>
                                </li>
                                <li class="has-submenu">
                                    <a href="#">Instructor <i class="fas fa-chevron-down"></i></a>
                                </li>
                                <li class="has-submenu">
                                    <a href="#">Student <i class="fas fa-chevron-down"></i></a>
                                </li>
                                <li class="has-submenu">
                                    <a href="#">Pages <i class="fas fa-chevron-down"></i></a>
                                </li>
                                <li class="login-link">
                                    <a href="{{ route('login') }}">Login / Signup</a>
                                </li>
                            </ul>     
                        </div>     
                        <ul class="nav header-navbar-rht">
                            @guest
                                <li class="nav-item">
                                    <a class="nav-link header-sign" href="{{ route('login') }}">Signin</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link header-login" href="{{ route('register') }}">Signup</a>
                                </li>
                            @else
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </li>
                            @endguest
                        </ul>
                    </div>
                </nav>
            </div>
        </header>
        <!-- /Header -->
        
        <!-- Home Banner -->
        <section class="home-slide d-flex align-items-center">
            <div class="container">
                <div class="row ">
                    <div class="col-md-7">
                        <div class="home-slide-face" data-aos="fade-up">
                            <div class="home-slide-text">
                                <h5>The Leader in Online Learning</h5>
                                <h1>Engaging & Accessible Online Courses For All</h1>
                                <p>Own your future learning new skills online</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5 d-flex align-items-center">
                        <div class="girl-slide-img" data-aos="fade-up">
                            <img src="{{ asset('assets/img/object.png') }}" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- /Home Banner -->
        
        <!-- Add remaining sections as per your HTML structure -->
        <!-- Example for the course section -->
        <section class="section student-course">
            <div class="container">
                <div class="course-widget">
                    <div class="row">
                        <div class="col-lg-3 col-md-6">
                            <div class="course-full-width">
                                <div class="blur-border course-radius align-items-center" data-aos="fade-up">
                                    <div class="online-course d-flex align-items-center">
                                        <div class="course-img">
                                            <img src="{{ asset('assets/img/pencil-icon.svg') }}" alt="">
                                        </div>
                                        <div class="course-inner-content">
                                            <h4><span>10</span>K</h4>
                                            <p>Online Courses</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Add more course categories here as per your design -->
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="footer">
            <!-- Footer Top -->
            <div class="footer-top" data-aos="fade-up">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-4 col-md-6">
                            <!-- Footer Widget -->
                            <div class="footer-widget footer-about">
                                <div class="footer-logo">
                                    <img src="{{ asset('assets/img/logo.svg') }}" alt="logo">
                                </div>
                                <div class="footer-about-content">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut consequat mauris Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut consequat mauris</p>
                                </div>
                            </div>
                        </div>
                        <!-- Add more footer content here -->
                    </div>
                </div>
            </div>
            <!-- /Footer Top -->
        </footer>
        <!-- /Footer -->
       
    </div>
    <!-- /Main Wrapper -->
  
    <!-- jQuery -->
    <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
    
    <!-- Bootstrap Core JS -->
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    
    <!-- counterup JS -->
    <script src="{{ asset('assets/js/jquery.waypoints.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.counterup.min.js') }}"></script>
    
    <!-- Select2 JS -->
    <script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>

    <!-- Owl Carousel -->
    <script src="{{ asset('assets/js/owl.carousel.min.js') }}"></script>    

    <!-- Slick Slider -->
    <script src="{{ asset('assets/plugins/slick/slick.js') }}"></script>
    
    <!-- Aos -->
    <script src="{{ asset('assets/plugins/aos/aos.js') }}"></script>
    
    <!-- Custom JS -->
    <script src="{{ asset('assets/js/script.js') }}"></script>
    
</body>
</html>
