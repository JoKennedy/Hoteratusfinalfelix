{{-- pageConfigs variable pass to Helper's updatePageConfig function to update page configuration  --}}
@isset($pageConfigs)
{!! Helper::updatePageConfig($pageConfigs) !!}
@endisset
<!DOCTYPE html>
@php
$configData = Helper::applClasses();
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <title>{{env("APP_DISPLAY_NAME")}}</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicons -->
    <link rel="apple-touch-icon" href="{{asset('images/favicon/logo2.png')}}">
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('images/favicon/logo2.png')}}">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700,700i|Montserrat:300,400,500,700"
        rel="stylesheet">

    <!-- Bootstrap CSS File -->
    <link href="{{asset('vendors/lib/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">

    <!-- Libraries CSS Files -->
    <link href="{{asset('vendors/lib/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{asset('vendors/lib/remixicon/remixicon.css')}}" rel="stylesheet">
    <link href="{{asset('vendors/lib/animate/animate.min.css')}}" rel="stylesheet">
    <link href="{{asset('vendors/lib/ionicons/css/ionicons.min.css')}}" rel="stylesheet">
    <link href="{{asset('vendors/lib/owlcarousel/assets/owl.carousel.min.css')}}" rel="stylesheet">
    <link href="{{asset('vendors/lib/lightbox/css/lightbox.min.css')}}" rel="stylesheet">

    <!-- Main Stylesheet File -->
    <link href="{{asset('vendors/css/style.css')}}" rel="stylesheet">

</head>

<body>

    <!--==========================
                Header
    ============================-->
    <header id="header" class="fixed-top">
        <div class="container">

            <div class="logo float-left">
                <!-- Uncomment below if you prefer to use an image logo -->
                <!--<h1 class="text-light"><a href="#header"><span>{{env("APP_NAME")}}</span></a></h1>-->
                <a href="{{url('/')}}#intro" class="scrollto"><img src="{{asset($configData['smallScreenLogo'])}}" alt=""
                        class="img-fluid"></a>
            </div>

            <nav class="main-nav float-right d-none d-lg-block">
                <ul>
                    <li class="active"><a href="../#intro">Home</a></li>
                    <li><a href="{{ url('/') }}#about">About Us</a></li>
                    <li><a href="{{ url('/') }}#services">Services</a></li>
                    <li><a href="{{ url('/') }}#pricing">Prices</a></li>
                    <!--<li><a href="#portfolio">Portfolio</a></li>-->
                    <!--<li><a href="#team">Team</a></li>-->
                    <!--
                    <li class="drop-down"><a href="">Drop Down</a>
                        <ul>
                            <li><a href="#">Drop Down 1</a></li>
                            <li class="drop-down"><a href="#">Drop Down 2</a>
                                <ul>
                                    <li><a href="#">Deep Drop Down 1</a></li>
                                    <li><a href="#">Deep Drop Down 2</a></li>
                                    <li><a href="#">Deep Drop Down 3</a></li>
                                    <li><a href="#">Deep Drop Down 4</a></li>
                                    <li><a href="#">Deep Drop Down 5</a></li>
                                </ul>
                            </li>
                            <li><a href="#">Drop Down 3</a></li>
                            <li><a href="#">Drop Down 4</a></li>
                            <li><a href="#">Drop Down 5</a></li>
                        </ul>
                    </li>-->
                    <li><a href="{{ url('/') }}#contact">Contact Us</a></li>
                    @if (Route::has('login'))

                    @auth
                    <li>
                        <a href="{{ url('/dashboard') }}"><i class="fa fa-tachometer"></i> Dashboard</a>
                    </li>
                    <li>
                        <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();"><i
                                class="fa fa-sign-out"></i> {{ __('Logout') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                    @else
                    <li>
                        <a href="{{ route('login') }}" class="border border-primary rounded-pill"><i
                                class="fa fa-sign-in"></i> Login</a>
                    </li>
                    @if (Route::has('register'))
                    <li>
                        <a href="{{ route('register') }}" class="border border-primary rounded-pill ml-1">Register</a>
                    </li>
                    @endif
                    @endauth
                    </li>
                    @endif
                </ul>
            </nav><!-- .main-nav -->

        </div>
    </header><!-- #header -->

    <!--==========================
            Intro Section
    ============================-->
    <section id="intro" class="clearfix">
        <div class="container">

            <div class="intro-img">
                <img src="{{asset('vendors/img/intro-img.svg')}}" alt="" class="img-fluid">
            </div>

            <div class="intro-info">
                <h2>We provide<br><span>solutions</span><br>for your business!</h2>
                <div>
                    <a href="#pricing" class="btn-get-started scrollto">Get Started</a>
                    <a href="#services" class="btn-services scrollto">Our Services</a>
                </div>
            </div>

        </div>
    </section><!-- #intro -->

    <main id="main">
        @yield("content")
    </main>

    <!--==========================
        Footer
    ============================-->
    <footer id="footer">
        <div class="footer-top">
            <div class="container">
                <div class="row">

                    <div class="col-lg-4 col-md-6 footer-info">
                        <h3>{{env('APP_NAME')}}</h3>
                        <p>The first fully integrated hospitality software offering a one-step solution for all your
                            operational needs. From property management system to channel manager, including guest
                            satisfaction surveys, customer relations management, maintenance, accounting, rate
                            management system and competitive set analysis.
                        </p>
                    </div>

                    <div class="col-lg-2 col-md-6 footer-links">
                        <h4>Useful Links</h4>
                        <ul>
                            <li><a href="{{ url('/') }}#intro">Home</a></li>
                            <li><a href="{{ url('/') }}#about">About us</a></li>
                            <li><a href="{{ url('/') }}#services">Services</a></li>
                            <li><a href="{{ url('/terms-of-service')}}">Terms of service</a></li>
                            <li><a href="{{ url('/privacy-policy') }}">Privacy policy</a></li>
                        </ul>
                    </div>

                    <div class="col-lg-3 col-md-6 footer-contact">
                        <h4>Contact Us</h4>
                        <p>
                            2440 Ouagadougou Place <br>
                            Dulles, Virginia<br>
                            United States <br>
                            <strong>Phone:</strong> +5 7193 47603<br>
                            <strong>Email:</strong> info@hoteratus.com<br>
                        </p>

                        <div class="social-links">
                            <a target="_blank" href="https://twitter.com/hoteratus" class="twitter"><i class="fa fa-twitter"></i></a>
                            <a target="_blank" href="https://www.facebook.com/pg/Hoteratus-Hospitality-Software-Solutions-462711787450572/" class="facebook"><i class="fa fa-facebook"></i></a>
                            <a target="_blank" href="https://www.youtube.com/channel/UCksSLNLux7D_VRkItbIjH3g" class="youtube"><i class="fa fa-youtube"></i></a>
                            <a target="_blank" href="live:info_613816" class="skype"><i class="fa fa-skype"></i></a>
                        </div>

                    </div>

                    <div class="col-lg-3 col-md-6 footer-newsletter">
                        <h4>Our Newsletter</h4>
                        <p>subscribe to newsletters to receive updates on news, prices and more.</p>
                        <form action="" method="post">
                            <input type="email" name="email"><input type="submit" value="Subscribe">
                        </form>
                    </div>

                </div>
            </div>
        </div>

        <div class="container">
            <div class="copyright">
                &copy; Copyright <strong>{{env("APP_NAME")}}</strong>. All Rights Reserved
            </div>
            <div class="credits">
                <!--
                All the links in the footer should remain intact.
                You can delete the links only if you purchased the pro version.
                Licensing information: https://bootstrapmade.com/license/
                Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/buy/?theme=NewBiz
                -->
                <!--Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>-->
            </div>
        </div>
    </footer><!-- #footer -->

    <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>
    <!-- Uncomment below i you want to use a preloader -->
    <!-- <div id="preloader"></div> -->

    <!-- JavaScript Libraries -->
    <script src="{{asset('vendors/lib/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('vendors/lib/jquery/jquery-migrate.min.js')}}"></script>
    <script src="{{asset('vendors/lib/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('vendors/lib/easing/easing.min.js')}}"></script>
    <script src="{{asset('vendors/lib/mobile-nav/mobile-nav.js')}}"></script>
    <script src="{{asset('vendors/lib/wow/wow.min.js')}}"></script>
    <script src="{{asset('vendors/lib/waypoints/waypoints.min.js')}}"></script>
    <script src="{{asset('vendors/lib/counterup/counterup.min.js')}}"></script>
    <script src="{{asset('vendors/lib/owlcarousel/owl.carousel.min.js')}}"></script>
    <script src="{{asset('vendors/lib/isotope/isotope.pkgd.min.js')}}"></script>
    <script src="{{asset('vendors/lib/lightbox/js/lightbox.min.js')}}"></script>
    <!-- Contact Form JavaScript File -->
    <script src="{{asset('vendors/contactform/contactform.js')}}"></script>

    <!-- Template Main Javascript File -->
    <script src="{{asset('js/main.js')}}"></script>
    <script>
        $(document).ready(function () {
            $("#searhTerms").on("keyup", function () {
                var value = $(this).val().toLowerCase();
                $("#listTerms a").filter(function () {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
    </script>
</body>
</html>